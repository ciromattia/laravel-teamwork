<?php

namespace Ciromattia\Teamwork;

class Authenticate extends TeamworkObject
{
    protected $url = "https://authenticate.teamwork.com/authenticate.json";

    /**
     * Authenticate Details
     *
     * @link https://developer.teamwork.com/account#the_'authenti
     * @return mixed
     */
    public function authenticate()
    {
        return $this->client->get($this->url)->response();
    }
}