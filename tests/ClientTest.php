<?php

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ciromattia\Teamwork\Client;

class ClientTest extends TestCase
{

    protected $guzzle;

    public function setUp()
    {
        parent::setUp();
        $this->guzzle = m::mock('GuzzleHttp\Client');
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @group client
     */
    public function test_it_builds_the_request_get()
    {
        $client = new Client($this->guzzle, 'key', 'http://teamwork.com');

        $this->guzzle
            ->shouldReceive('request')->once()
            ->with('GET',
                'http://teamwork.com/packages.json',
                ['auth' => ['key', 'X']])
            ->andReturn(m::mock('GuzzleHttp\Message\Request'));

        $returned = $client->buildRequest('packages', 'GET');

        $this->assertInstanceOf('Ciromattia\Teamwork\Client', $returned);
        $this->assertInstanceOf('GuzzleHttp\Message\Request', $returned->getRequest());
    }

    /**
     * @group client
     */
    public function test_it_builds_the_request_post()
    {
        $client = new Client($this->guzzle, 'key', 'http://teamwork.com');

        $this->guzzle
            ->shouldReceive('request')->once()
            ->with('POST',
                'http://teamwork.com/packages.json',
                ['body' => '{"key":"value"}', 'auth' => ['key', 'X']])
            ->andReturn(m::mock('GuzzleHttp\Message\Request'));

        $returned = $client->buildRequest('packages', 'POST', ['key' => 'value']);

        $this->assertInstanceOf('Ciromattia\Teamwork\Client', $returned);
        $this->assertInstanceOf('GuzzleHttp\Message\Request', $returned->getRequest());
    }

    /**
     * @group client
     */
    public function test_build_url()
    {
        $client = new Client($this->guzzle, 'key', 'http://teamwork.com/');

        $url = $client->buildUrl('test');

        $this->assertEquals('http://teamwork.com/test.json', $url);
    }

    /**
     * @group client
     */
    public function test_build_url_with_no_trailing_slash()
    {
        $client = new Client($this->guzzle, 'key', 'http://teamwork.com');

        $url = $client->buildUrl('test');

        $this->assertEquals('http://teamwork.com/test.json', $url);
    }

    /**
     * @group client
     */
    public function test_build_url_with_full_url()
    {
        $url = 'http://teamwork.com/authenticate/test/url';
        $expectedUrl = $url . '.json';
        $client = new Client($this->guzzle, 'key', 'http://teamwork.com');

        $actualUrl = $client->buildUrl($url);

        $this->assertEquals($expectedUrl, $actualUrl);
    }
}