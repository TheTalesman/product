<?php
namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
class ImageUploader {

    private $params;
    private $slugger;
    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger)
    {
        $this->params = $params;
        $this->slugger = $slugger;
    }


    public function upload($file, $product){
        $originalFilename = pathinfo($file["file"]->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file["file"]->guessExtension();

        try {
            $file["file"]->move(
                $this->params->get('images_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            var_dump($e);
            // ... handle exception if something happens during file upload
        }


        $image = new Image();
        $image->setName($originalFilename);
        $image->setTitle($file["title"]);
        $image->setProduct($product);
        $image->setPath("uploads/images/" . $newFilename);

        return $image;
    }
}