<?php

namespace Ciromattia\Teamwork\Contracts;

use Ciromattia\Teamwork\Client;

interface RequestableInterface
{
    /**
     * @param $endpoint
     * @param $params
     * @return Client
     */
    public function get($endpoint, $params = '');

    /**
     * @param $endpoint
     * @param $payload
     * @return Client
     */
    public function post($endpoint, $payload);

    /**
     * @param $endpoint
     * @param $payload
     * @return Client
     */
    public function put($endpoint, $payload = []);

    /**
     * @param $endpoint
     * @return Client
     */
    public function delete($endpoint);
}