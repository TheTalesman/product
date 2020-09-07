<?php

namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageUploader
{

    private $params;
    private $slugger;
    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger)
    {
        $this->params = $params;
        $this->slugger = $slugger;
    }


    public function upload($file, $product, $originalFilename, $newFilename)
    {


        try {
            $file["file"]->move(
                $this->params->get('images_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            var_dump($e);
            // ... handle exception if something happens during file upload
        }

        $path = "uploads/images/" . $newFilename;
        $image = new Image($originalFilename, "/".$path, $file["title"]);
        $image->setProduct($product);


        return $image;
    }
}
