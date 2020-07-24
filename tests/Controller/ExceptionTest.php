<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ExceptionTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testSendsJsonOn404()
    {
        $this->client->request('GET', '/thisRouteDoesNotExist');

        $this->assertEquals('application/json', $this->client->getResponse()->headers->get('Content-Type'));
    }
}
