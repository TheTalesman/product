<?php

namespace App\DataFixtures;

use App\Entity\{Product, Tag, Image};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $product = $this->getProduct($data, $manager);
            $manager->persist($product);
        }


        $manager->flush();
    }
    private function getProduct($data, $manager)
    {
        $product =  new Product(
            $data['title'],
            $data['description'],
            $data['stock'],
            $data['price'],

        );
        $product = $this->parseTags($product, $manager, $data['tags']);
        $product = $this->parseImages($product, $data['images']);

        return $product;
    }

    private function parseTags($product, $manager, $tags)
    {
        $parsedTags = explode(',', $tags);
        foreach ($parsedTags as $tag) {
            $product->addTag($tag);
            $manager->persist($tag);
        }

        return $product;
    }
    private function parseImages($product, $images)
    {
        $images;
        $image = new Image();
        return $images;
    }

    private function getData()
    {
        return
            [
                [
                    'title' => 'The Black Strat - David Gilmour\'s Guitar',
                    'description' => 'Gilmour purchased the guitar, a 1969 model with a maple cap fingerboard and large headstock, in 1970 from Manny\'s Music in New York City to replace a similar guitar his parents bought him for his 21st birthday, which had been lost while touring with Pink Floyd in the United States in 1968. The Black Strat was originally a sunburst colour, but had been repainted black at Manny\'s. Since then, it has undergone numerous modifications.  ',
                    'stock' => '1',
                    'price' => '2.000.000,00',
                    'images' => '/1/',
                    'tags' => 'Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '237.000,00',
                    'images' => '/1/',
                    'tags' => 'Guitar, Rock, Music',
                ]


            ];
    }
}
