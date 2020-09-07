<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\{Product, Tag, Image};
use Symfony\Component\HttpFoundation\{Request, Response};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/delete/{id}", name="delete_image")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $image = $this->getDoctrine()->getRepository(Image::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $product = $image->getProduct();
        $product->removeImage($image);
        $entityManager->persist($product);
        $entityManager->remove($image);
        $entityManager->flush();
        $response = new Response();
        $response->send();
    }
}
