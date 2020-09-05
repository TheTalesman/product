<?php

namespace App\DataFixtures;

use App\Entity\{Product, Tag, Image};
use App\Services\ImageUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    private $imgUploader;
    private $params;
    private $manager;



    public function __construct(ParameterBagInterface $params, ImageUploader $imgUploader)
    {
        $this->imgUploader = $imgUploader;
        $this->params = $params;
    }


    /**
     * Loads product, tags and images data in DB.
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;


        foreach ($this->getData() as $data) {
            $product = $this->getProduct($data);
            $this->manager->persist($product);
        }


        $manager->flush();
    }


    /**
     * Receives data, treats all associations and returns the product to be persisted.
     */
    private function getProduct($data)
    {
        $product =  new Product(
            $data['title'],
            $data['description'],
            $data['stock'],
            $data['price'],

        );
        $product = $this->parseTags($product, $data['tags']);
        $imagesDir = $data['imagesFolder'];
        $product = $this->parseImages($product, $imagesDir );

        return $product;
    }

    /**
     * Receives data from tags, associate with product, persist tags and return product.
     */
    private function parseTags($product, $tags)
    {
        $parsedTags = explode(',', $tags);
        foreach ($parsedTags as $tagName) {
            $tag = new Tag($tagName);
            $product->addTag($tag);
            $this->manager->persist($tag);
        }

        return $product;
    }


    /**
     * Receives data from image directory and product and returns product witg treated images persisted.
     */
    private function parseImages($product, $imagesDir)
    {
        $images = [];
        
        $directory = $this->params->get('images_fixture_directory') . $imagesDir;
        $files = glob($directory . "/*.*");
       
        foreach ($files as $k => $file) {
            $file = str_replace("\\", "/", $file);
          
            $originalName = $file;
            $fileNameExploded = explode('.', $file);
            $newFilename = $k . end($fileNameExploded);
            $image =new Image($originalName, "../".$file, $newFilename);
            $image->setProduct($product);
            $this->manager->persist($image);
            $product->addImage($image);
        }
        
        return $product;
    }

    /**
     * Returns data for product fixture.
     */
    private function getData()
    {
        return
            [
                [
                    'title' => 'The Black Strat - David Gilmour\'s Guitar',
                    'description' => 'Gilmour purchased the guitar, a 1969 model with a maple cap fingerboard and large headstock, in 1970 from Manny\'s Music in New York City to replace a similar guitar his parents bought him for his 21st birthday, which had been lost while touring with Pink Floyd in the United States in 1968. The Black Strat was originally a sunburst colour, but had been repainted black at Manny\'s. Since then, it has undergone numerous modifications.  ',
                    'stock' => '1',
                    'price' => '200000000',
                    'imagesFolder' => '1',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '2',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '3',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '4',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '5',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '6',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '7',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '8',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '9',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '10',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Black Strat - David Gilmour\'s Guitar',
                    'description' => 'Gilmour purchased the guitar, a 1969 model with a maple cap fingerboard and large headstock, in 1970 from Manny\'s Music in New York City to replace a similar guitar his parents bought him for his 21st birthday, which had been lost while touring with Pink Floyd in the United States in 1968. The Black Strat was originally a sunburst colour, but had been repainted black at Manny\'s. Since then, it has undergone numerous modifications.  ',
                    'stock' => '1',
                    'price' => '200000000',
                    'imagesFolder' => '1',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '2',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '3',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '4',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '5',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '6',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '7',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '8',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '9',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '10',
                    'tags' => 'Guitar, Rock, Music',
                ]
            


            ];
    }
}
