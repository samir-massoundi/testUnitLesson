<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Product;
use App\Entity\Cart;
use App\Service\RickAndMortyApiService;
use App\Service\RickAndMortyGestion;


class AppFixtures extends Fixture
{
    private RickAndMortyApiService $rickAndMortyService;
    private $prices = ["8", "9,99", "15", "16.50", "20", "35"];
    private $quantites = [1, 2, 5, 20, 30, 70];

    public function __construct(RickAndMortyApiService $rickAndMortyService)
    {
        $this->rickAndMortyService = $rickAndMortyService;
    }

    public function load(ObjectManager $manager): void
    {
        $data = $this->rickAndMortyService->loadApi();
        foreach ($data as $key => $model) {
            $product = new Product();
            $product->setName($model->getName());
            $product->setPrice($this->prices[$key % 6]);
            $product->setQuantity($this->quantites[$key % 6]);
            $product->setImage($model->getImage());
            $manager->persist($product);
        }
        

        $manager->flush();
    }
}
