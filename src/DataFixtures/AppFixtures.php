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
            $manager->flush();
        }


     
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
        foreach ($parsedTags as $k=> $tagName) {
            $tag = $this->manager->getRepository(Tag::class)->findOneByName(ltrim($tagName));
           
            if (is_null($tag)) {
            
                $tag = new Tag(ltrim($tagName));
            }
            $tag->addProduct($product);
            $product->addTag($tag);
            $this->manager->persist($tag);
            $this->manager->flush();
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
        $files = glob("public".$directory . "/*.*");
       
        foreach ($files as $k => $file) {
            $file = str_replace("public", "", $file);
            $file = str_replace("\\", "/", $file);
          
            $originalName = $file;
            $fileNameExploded = explode('.', $file);
            $newFilename = $product->getTitle()." image ". ($k+1);
            $image =new Image($originalName, $file, $newFilename);
            
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
                    'tags' => 'Progressive, Guitar, Rock, Music',
                ],
                [
                    'title' => 'The Burned Strat - Jimi Hendrix\'s Guitar',
                    'description' => '
                As legend has it, Hendrix doused the Strat in lighter fluid during \'Wild Thing,\' and lit a match (or flicked a lighter) at the Monterey International Pop Festival in San Fransisco that year. Wright tells English newspaper the Metro that the guitarist had planned to just smash it, but saw Pete Townshend do the same thing earlier that night.
                ',
                    'stock' => '1',
                    'price' => '23700000',
                    'imagesFolder' => '2',
                    'tags' => 'Guitar, Rock, Music, Awesome, Old, Hero',
                ],
                [
                    'title' => '(RARE) Iron Maiden - Maiden Japan',
                    'description' => '
                    Maiden Japan, also known as Heavy Metal Army, is a live EP by the British heavy metal band Iron Maiden. The title is a pun of Deep Purple\'s live album Made in Japan. 
                ',
                    'stock' => '10',
                    'price' => '300',
                    'imagesFolder' => '3',
                    'tags' => 'Iron Maiden, Heavy Metal, Music, LP, Old',
                ],
                [
                    'title' => '(SIGNED) Metallica - Kill\'em All',
                    'description' => '
                First Metallica album LP, signed by the band, including Cliff Burton\'s Autograph.
                ',
                    'stock' => '1',
                    'price' => '6600',
                    'imagesFolder' => '4',
                    'tags' => 'Metallica, Heavy Metal, Music, Signed, LP, Old',
                ],
                [
                    'title' => '(SIGNED) Queen - A Night at the Opera',
                    'description' => '
Fourth Studio Album by Queen, signed by all members. Includes 2 classical songs: \'Love of my Life\' and \'Bohemian Raphsody\'.                 ',
                    'stock' => '1',
                    'price' => '150000',
                    'imagesFolder' => '5',
                    'tags' => 'Queen, Signed, Rock, Music, LP, Old, Bohemian',
                ],
                [
                    'title' => 'Elvis Original Costume',
                    'description' => '
                The original clothes Elvis used during his performances at live shows.
                ',
                    'stock' => '1',
                    'price' => '2750000',
                    'imagesFolder' => '6',
                    'tags' => 'Elvis, Rockabilly, Old, Music, Outfit, Costume, Clothing',
                ],
                [
                    'title' => 'Ace Freheley\'s Spaceman Boots',
                    'description' => '
                Legend says that whoever wear this boot instantly become a god of thunder and rock\'n\'roll. Used at live performances by the great Ace Freheley, KISS lead guitarrist.
                ',
                    'stock' => '2',
                    'price' => '500',
                    'imagesFolder' => '7',
                    'tags' => 'Guitar, Rock, Music, Costume, Awesome',
                ],
                [
                    'title' => 'Beatles Party Cake',
                    'description' => '
                Party Cake decorations inspired by the beatles, sold in the 70\'s. 
                ',
                    'stock' => '10',
                    'price' => '0.98',
                    'imagesFolder' => '8',
                    'tags' => 'Decoration, Rock, Music, Old',
                ],
                [
                    'title' => '(Signed) ELP Tambourine',
                    'description' => '
                A brand-new tambourine signed by all members of the virtuose trio Emerson, Lake and Palmer. (Does not reproduce pagode music style)
                ',
                    'stock' => '3',
                    'price' => '700',
                    'imagesFolder' => '9',
                    'tags' => 'Progressive, Tambourine, Virtuose, Music, Awesome, Signed',
                ],
                [
                    'title' => 'Raul Seixas Magic Robe',
                    'description' => 'Used by one of the greatest Brazilian Magician, Raul Seixas, this was the exactly same robe that was used to bring the new aeon.',
                    'stock' => '1',
                    'price' => '666',
                    'imagesFolder' => '10',
                    'tags' => 'Outfit, Costume, Magic, Rock, Music, Old',
                ],
                [
                    'title' => 'Rock in Rio Festival Ticket',
                    'description' => '
                Legend says that this ticket could take you to a magic place where rock\'n\'roll, heavy metal and peace ruled the whole universe. Unfortunatelly it only worked in the year of 1985. A great decorative and memorabilia nevertheless.
                ',
                    'stock' => '1',
                    'price' => '145',
                    'imagesFolder' => '11',
                    'tags' => 'Ticket, Magic, Rock, Music, Old',
                ],
               
                [
                    'title' => 'Roberto Carlos LP Collection',
                    'description' => '
                A fine collection of vinyl LP by the artist Roberto Carlos. The folders are in normal condition accordingly to the time of use, but the LPs don\'t have a single scratch.
                ',
                    'stock' => '1',
                    'price' => '200',
                    'imagesFolder' => '12',
                    'tags' => 'LP, Rock, Music, Old',
                ],
                 [
                    'title' => 'Ozzy\'s Bat',
                    'description' => '
                The very single bat which Ozzy took a byte in the head.
                ',
                    'stock' => '1',
                    'price' => '976',
                    'imagesFolder' => '13',
                    'tags' => 'Bat, Heavy Metal',
                ],
                [
                    'title' => '(Signed) Nina Simone at the Carnegie Hall',
                    'description' => '
                A Signed Live LP by the great singer Nina Simone. Folder in good condition, LP untouched. 
                ',
                    'stock' => '1',
                    'price' => '4500000',
                    'imagesFolder' => '14',
                    'tags' => 'Singer, Music, Signed, LP, Bohemian, Old',
                ],
                [
                    'title' => 'Hermeto Pascoal\'s Magic Accordion',
                    'description' => '
                A Wizards instrument. Used to produce sounds and music that causes awe and makes people dance.
                ',
                    'stock' => '1',
                    'price' => '23000',
                    'imagesFolder' => '15',
                    'tags' => 'Instrument, Accordion, Music, Magic',
                ],
                [
                    'title' => 'Cartola\'s Sunglasses',
                    'description' => '
                    These were used to produce great bohemian samba songs with a glass of beer and a cigarrete. By the magnificent poet Cartola.
                ',
                    'stock' => '1',
                    'price' => '44400',
                    'imagesFolder' => '16',
                    'tags' => 'Samba, Sunglasses, Music, Bohemian, Old',
                ],
                [
                    'title' => '(Signed) Ayrton Senna Helmet',
                    'description' => '
                This helmet was used back in the days by the velocist Ayrton Senna. Many GPs were won using this. Autograph suposedly by the same.
                ',
                    'stock' => '1',
                    'price' => '427000',
                    'imagesFolder' => '17',
                    'tags' => 'F1, Signed, Old, Hero',
                ],
                [
                    'title' => 'First computer program ever - Note G - By Ada Lovelace.',
                    'description' => '
                Published in 1843, these notes were written by Ada Lovelace and are considered the first algorithm ever. The algorithm computes Bernoulli numbers. More about: https://en.wikipedia.org/wiki/Ada_Lovelace#First_computer_program
                ',
                    'stock' => '1',
                    'price' => '65535',
                    'imagesFolder' => '18',
                    'tags' => 'Old, Algorithm, Hero',
                ],
                [
                    'title' => 'Not a Flamethrower',
                    'description' => '
                Elon Musk is known by many inventions and is considered by some, the Thomas Edson of XXI century. This is a multi-purpose tool that fires FIRE! Fire Extinguisher sold separatedly. Caution is advised.
                ',
                    'stock' => '100',
                    'price' => '750',
                    'imagesFolder' => '19',
                    'tags' => 'Awesome, Fire, Instrument, Hero',
                ],
                [
                    'title' => '(Signed) Rush - 2112 LP',
                    'description' => '
                One of the classic\'s of progressive rock. This album contains the 2112 complete song, 20m:33s of pure awesomeness. Also contains another 5 songs by the band. This LP is in great condition and the folder is signed by the power trio.
                ',
                    'stock' => '1',
                    'price' => '80700',
                    'imagesFolder' => '20',
                    'tags' => 'Progressive, Rock, Music, Old, Signed, Awesome',
                ]
            


            ];
    }
}
