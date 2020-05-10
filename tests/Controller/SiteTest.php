<?php

namespace App\Tests\Controller;

use App\Controller\Site;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class SiteTest extends TestCase
{

    /**
     * Testing the searching
     */
    public function testSearch() {
        $client = HttpClient::create([
            'http_version' => '2.0',
            'verify_peer' => false,
            'verify_host' => false,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $_SERVER["HTTP_HOST"] = "https://localhost:8000";
        $url = $_SERVER["HTTP_HOST"];

        $response = $client->request('POST', $url . '/search', [
            'body' => "&search=fr"
        ]);

        $response_data = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('success', $response_data);
    }

    /**
     * Testing the creation of a new contact
     */
    public function testCreate() {

        $client = HttpClient::create([
            'http_version' => '2.0',
            'verify_peer' => false,
            'verify_host' => false,
            'headers' => [
                //'Content-Type' => 'application/json',
            ]
        ]);

        $_SERVER["HTTP_HOST"] = "https://localhost:8000";
        $url = $_SERVER["HTTP_HOST"];

        $response = $client->request('POST', $url . '/add', [
            'body' => urlencode("&lastname=santa&firstname=zsolt&email=zs0lt.santa@gmail.com&phone=06303882524")
            //'body' => ["lastname" => 'santa', "firstname" => 'zsolt', "email" => "zs0lt.santa@gmail.com", "phone" => "06303882524"]
        ]);

        $response_data = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('success', $response_data);
    }
}