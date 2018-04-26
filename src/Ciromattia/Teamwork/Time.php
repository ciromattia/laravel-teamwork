<?php

namespace Ciromattia\Teamwork;

use Ciromattia\Teamwork\Traits\RestfulTrait;

class Time extends TeamworkObject
{
    use RestfulTrait;

    protected $wrapper = 'time-entry';
    protected $endpoint = 'time_entries';

    /**
     * GET /time_entries.json
     *
     * @return mixed
     */
    public function all($args = null, $fullResponse = false)
    {
        $this->areArgumentsValid($args, ['page', 'pageSize']);

        return $this->client->get($this->endpoint, $args)->response($fullResponse);
    }

    /**
     * GET /time_entries/id.json
     *
     * @return mixed
     */
    public function find($args = null)
    {
        $this->areArgumentsValid($args, ['page', 'pageSize']);

        return $this->client->get("$this->endpoint/$this->id.json", $args)->response();
    }

    /**
     * Edit A Time entry
     * PUT /time_entries/{id}.json
     *
     * @return mixed
     */
    public function edit($data)
    {
        return $this->client->put("$this->endpoint/$this->id.json", ['time-entry' => $data])->response();
    }

    /**
     * Delete A Time entry
     * DELETE /time_entries/{id}.json
     *
     * @return mixed
     */
    public function delete()
    {
        return $this->client->delete("$this->endpoint/$this->id.json")->response();
    }
}
