<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\{Product, Tag};
use App\Form\Type\ImageType;
use App\Services\ImageUploader;
use App\Services\Utils;
use Symfony\Component\HttpFoundation\{Request};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, SubmitType,  CollectionType, ButtonType};
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\{File, All};
use Symfony\Component\Validator\Validation;

class ProductController extends AbstractController

{

    private $imgUploader;
    private $utils;
    public function __construct(ImageUploader $imgUploader, Utils $utils)
    {
        $this->imgUploader = $imgUploader;
        $this->utils = $utils;
    }



    /**
     * @Route("/customerView/{query}", name="customerView_product")
     */
    public function search(Request $request, $query)
    {

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $form = $this->searchBar();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $query =  $form->get("query")->getData();

            if ($query == 'all') {
                $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
            } else {

                $productsByQuery = $productsByTag =  $products = [];
                $productsByTag = $this->getDoctrine()->getRepository(Tag::class)->findByTag($query);
                $productsByQuery = $this->getDoctrine()->getRepository(Product::class)->findLike($query);
                $products = $this->utils->joinArray($products, $productsByQuery, $productsByTag );
                
            }
        }
        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
            'products' => $products
        ]);
    }

    /**
     * @Route("/", name="list_product")
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }


    private function buildForm($product)
    {
        $form =  $this->createFormBuilder($product)
            ->add('title', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => true,
            ))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('price', TextType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('stock', TextType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('imagesFiles', CollectionType::class, array(
                'mapped' => false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'label' => false,



            ))
            ->add('tags', TextType::class, array(
                'mapped' => false,
                'required' => false,
                'attr' => array('class' => 'form-control myTags')
            ))


            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        return $form;
    }

    /**
     * @Route("/product/new", name="new_product", priority=3)
     * @Method({"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, ValidatorInterface $validator)
    {
        $product = new Product(null, null, null, null);

        $form = $this->buildForm($product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get("imagesFiles")->getData();

            $validator = Validation::createValidator();
            $violations = $validator->validate($files, [

                new All([
                    'constraints' => [
                        new File([
                            'maxSize' => '5M',
                            'maxSizeMessage' => 'File must be inferior to 5MB'
                        ])
                    ],
                ]),
            ]);

            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    echo $violation->getMessage() . '<br>';
                }
            }

            if ($files) {

                foreach ($files as $file) {

                    $em = $this->getDoctrine()->getManager();
                    $originalFilename = pathinfo($file["file"]->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $file["file"]->guessExtension();
                    $image = $this->imgUploader->upload($file, $product, $originalFilename, $newFilename);
                    $em->persist($image);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();

            $tagsForm = $form->get("tags")->getData();
            $tagsForm = explode(",", $tagsForm);

            foreach ($tagsForm as $tagName) {
                $tag = new Tag($tagName);
                $tag->addProduct($product);
                $product->addTag($tag);
                $entityManager->persist($tag);
            }

            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('list_product');
        }


        return $this->render('product/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/product/edit/{id}", name="edit_product")
     * @Method({"GET","POST"})
     */
    public function edit(Request $request, $id)
    {
        $product = new Product(null, null, null, null);
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $product->getTags();
        $form = $this->buildForm($product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('list_product');
        }
        $tags = $product->getTags();
      
        //$images = $product->getImages();

        return $this->render('product/edit.html.twig', array(
            'form' => $form->createView(),
            'tags' => $tags,
            
          //  'images' => $images,
        ));
    }


    /**
     * @Route("/product/{id}", name="show_product",  priority=2)
     */
    public function show($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $images = $product->getImages();
        return $this->render('product/show.html.twig', array('product' => $product, 'images' => $images));
    }


    /**
     * @Route("/product/delete/{id}", name="delete_product")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('list_product');
    }


    private function searchBar()
    {
        return $this->createFormBuilder(null)
            ->add('query', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'label' => 'Search'
                ]
            ])
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary right'
                ]
            ])
            ->getForm();
    }

    /**
     * @Route("/product/save/", priority=10)
     * Used for development
     public function save()
     {
         $entityManager = $this->getDoctrine()->getManager();
         $title = "Roupa do Goku";
         $description = "Roupa que Goku usou para derrotar Freeza";
         $product = new Product($title, $description, 5, 100);
         $entityManager->persist($product);
         $entityManager->flush();
         
         return new Response("Salvou produto com id " . $product->getId());
        }
        
     */
}
