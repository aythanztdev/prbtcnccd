<?php

namespace App\Tests;

use App\Entity\Category;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /** @var Client */
    protected $client;

    /**
     * Retrieves the category list.
     */
    public function testRetrieveTheCategoryList(): void
    {
        $response = $this->request('GET', '/api/categories');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertCount(5, $json);

        foreach ($json as $key => $value) {
            $this->assertArrayHasKey('id', $json[$key]);
            $this->assertArrayHasKey('name', $json[$key]);
            $this->assertArrayHasKey('createdAt', $json[$key]);  
        }  
    }
    
    /**
     * Retrieves the tax list.
     */
    public function testRetrieveTheTaxList(): void
    {
        $response = $this->request('GET', '/api/taxes');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertCount(5, $json);

        foreach ($json as $key => $value) {
            $this->assertArrayHasKey('id', $json[$key]);
            $this->assertArrayHasKey('name', $json[$key]);
            $this->assertArrayHasKey('value', $json[$key]);  
            $this->assertArrayHasKey('createdAt', $json[$key]);  
            $this->assertArrayHasKey('updatedAt', $json[$key]);  
        }  
    }

    /**
     * Retrieves the mediaObject list.
     */
    public function testRetrieveTheMediaObjectList(): void
    {
        $response = $this->request('GET', '/api/media_objects');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertCount(10, $json);

        foreach ($json as $key => $value) {
            $this->assertArrayHasKey('id', $json[$key]);
            $this->assertArrayHasKey('fileName', $json[$key]);
            $this->assertArrayHasKey('mimeType', $json[$key]);
            $this->assertArrayHasKey('createdAt', $json[$key]);
        }  
    }
            
    /**
     * Retrieves the product list.
     */
    public function testRetrieveTheProductList(): void
    {
        $response = $this->request('GET', '/api/products');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertCount(10, $json);

        foreach ($json as $key => $value) {
            $this->assertArrayHasKey('id', $json[$key]);
            $this->assertArrayHasKey('name', $json[$key]);
            $this->assertArrayHasKey('description', $json[$key]);
            $this->assertArrayHasKey('price', $json[$key]);
            $this->assertArrayHasKey('priceWithTax', $json[$key]);
            $this->assertArrayHasKey('category', $json[$key]);
            $this->assertArrayHasKey('id', $json[$key]['category']);
            $this->assertArrayHasKey('name', $json[$key]['category']);
            $this->assertArrayHasKey('tax', $json[$key]);
            $this->assertArrayHasKey('id', $json[$key]['tax']);
            $this->assertArrayHasKey('name', $json[$key]['tax']);
            $this->assertArrayHasKey('value', $json[$key]['tax']);
            $this->assertArrayHasKey('images', $json[$key]);
            foreach ($json[$key]['images'] as $image) {
                $this->assertArrayHasKey('id', $image);
                $this->assertArrayHasKey('fileName', $image);
                $this->assertArrayHasKey('mimeType', $image);
            }
            $this->assertArrayHasKey('updatedAt', $json[$key]);
            $this->assertArrayHasKey('createdAt', $json[$key]);
        }  
    }
    
    /**
     * Throws errors when data are invalid.
     */
    public function testThrowErrorsWhenDataAreInvalid(): void
    {
        $data = [
            "name" => "",
            "description" => "The Star Wars The Last Jedi Collection 9TWENTY is constructed of a black poly fabric. A Star Wars fighter plane is embroidered on the front panels and the cap features a D-Ring closure.",
            "price" => "20.50",
            "category" => [
                "id" => 1
            ],
            "images" => [
                [
                    "id" => 1
                ]
            ]
        ];

        $response = $this->request('POST', '/api/products', $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('violations', $json);
        $this->assertCount(2, $json['violations']);

        $this->assertArrayHasKey('propertyPath', $json['violations'][0]);
        $this->assertEquals('name', $json['violations'][0]['propertyPath']);

        $this->assertArrayHasKey('propertyPath', $json['violations'][1]);
        $this->assertEquals('tax', $json['violations'][1]['propertyPath']);
    }

    /**
     * Creates a product.
     */
    public function testCreateAProduct(): void
    {
        $data = [
            "name" => "Cap of Star Wars The Last Jedi",
            "description" => "The Star Wars The Last Jedi Collection 9TWENTY is constructed of a black poly fabric. A Star Wars fighter plane is embroidered on the front panels and the cap features a D-Ring closure.",
            "price" => "20.50",
            "category" => [
                "id" => 1
            ],
            "tax" => [
                "id" => 1
            ],
            "images" => [
                [
                    "id" => 1
                ]
            ]
        ];

        $response = $this->request('POST', '/api/products', $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('id', $json);
        $this->assertEquals('Cap of Star Wars The Last Jedi', $json['name']);
        $this->assertArrayHasKey('priceWithTax', $json);
    }

    /**
     * Retrieves the documentation.
     */
    public function testRetrieveTheDocumentation(): void
    {
        $response = $this->request('GET', '/api', null, ['Accept' => 'text/html']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/html; charset=UTF-8', $response->headers->get('Content-Type'));

        $this->assertContains('API Platform', $response->getContent());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /**
     * @param string|array|null $content
     */
    protected function request(string $method, string $uri, $content = null, array $headers = []): Response
    {
        $server = ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'];
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'content-type') {
                $server['CONTENT_TYPE'] = $value;

                continue;
            }

            $server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
        }

        if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
            $content = json_encode($content);
        }

        $this->client->request($method, $uri, [], [], $server, $content);

        return $this->client->getResponse();
    }

    protected function findOneIriBy(string $resourceClass, array $criteria): string
    {
        $resource = static::$container->get('doctrine')->getRepository($resourceClass)->findOneBy($criteria);

        return static::$container->get('api_platform.iri_converter')->getIriFromitem($resource);
    }
}