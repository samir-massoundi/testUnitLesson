<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testApiCall(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(['message' => "Hello world"], $responseData);
    }
    public function testRetreiveProducts():void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/products');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData, "assert variable is array or not");
        $this->assertCount(20, $responseData);

        $element = $responseData[0];
        $this->assertArrayHasKey('id',$element);
        $this->assertArrayHasKey('name',$element);
        $this->assertArrayHasKey('price',$element);
        $this->assertArrayHasKey('quantity',$element);
        $this->assertArrayHasKey('image',$element);

    }

    public function testRetreiveProduct():void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/products/1');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData,'check if its object or not');


        $this->assertArrayHasKey('id',$responseData);
        $this->assertArrayHasKey('name',$responseData);
        $this->assertArrayHasKey('price',$responseData);
        $this->assertArrayHasKey('quantity',$responseData);
        $this->assertArrayHasKey('image',$responseData);
    }

    public function getCart():void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/cart');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData,'check if its object or not');
        $this->assertIsBool($responseData['products'][0],'check if its object or not');
    }

    // public function addProductToCart() {
    //     $client = static::createClient();
    //     // Request a specific page
    //     $client->jsonRequest('post', '/api/products/1');
    // }

    public function deleteCart():void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('DELETE', '/api/cart/1');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($responseData, [
            "id" => 1,
            "products" => []
        ]);
    }
}
