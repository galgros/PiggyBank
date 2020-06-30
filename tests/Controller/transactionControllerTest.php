<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class transactionControllerTest extends WebTestCase
{
    public function testNewTransaction100()
    {
        $client = static::createClient();

        $crawler = $client->request('POST',
            '/transaction/new',
            ['type' => 'credit'],
            ['amount' => 100]);

        $form = $crawler->selectButton('submit')->form();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
