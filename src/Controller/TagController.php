<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\{Product, Tag, Image};
use App\Services\Utils;
use Symfony\Component\HttpFoundation\{Request, Response};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="list_tags")
     */
    public function index()
    {

        
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findMostUsedTags();
        
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/tag/all", name="list_all_tags")
     * @Method("GET")
     */
    public function allTags(Utils $utils)
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $treatedTag = $utils->turnArrayToString($tags);
        $response = new Response($treatedTag);
        $response->send();
    }


    
}
