<?php

namespace Ciromattia\Teamwork;

class Account extends TeamworkObject
{
    /**
     * Account Details
     * GET /account.json
     *
     * @link http://developer.teamwork.com/account
     * @return mixed
     */
    public function details()
    {
        return $this->client->get('account')->response();
    }

    /**
     * Authenticate Call
     * GET /authenticate.json
     *
     * @link http://developer.teamwork.com/account
     * @return mixed
     */
    public function authenticate()
    {
        return $this->client->get('authenticate')->response();
    }

}