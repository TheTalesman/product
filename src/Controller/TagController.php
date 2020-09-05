<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\{Product, Tag, Image};

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
}
