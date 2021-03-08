<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected function createClientThenRequest(string $path, ?string $method = 'GET'): Crawler
    {
        return static::createClient()->request($method, $path);
    }
}
