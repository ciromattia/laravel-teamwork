<?php

namespace Ciromattia\Teamwork\Traits;

trait RestfulTrait
{
    /**
     * @param string|array $query The query parameters (optional).
     * @return mixed
     */
    public function all($query = '')
    {
        if (!empty($query)) {
            if (is_array($query)) {
                $query = http_build_query($query);
            } else if (is_string($query)) {

            } else {
                $query = '';
            }
        }
        $response = $this->client->get($this->endpoint, $query)->response();
        if ($response->STATUS == 'OK') {
            return $response->{$this->wrapper};
        } else {
            return $response->status;
        }
    }

    /**
     * @return mixed
     */
    public function find($id = null)
    {
        if (!empty($id))
            $this->id = $id;
        if (!$this->id)
            throw new \InvalidArgumentException('No valid ID provided');
        $response = $this->client->get("$this->endpoint/{$this->id}")->response();
        if ($response->STATUS == 'OK') {
            return $response->{$this->wrapper};
        } else {
            return $response->status;
        }
    }

    /**
     * @return array | companyID
     */
    public function create($data)
    {
        return $this->client->post("$this->endpoint", [$this->wrapper => $data])->response();
    }

    /**
     * @return mixed
     */
    public function update($data, $id = null)
    {
        if (!empty($id))
            $this->id = $id;
        if (!$this->id)
            throw new \InvalidArgumentException('No valid ID provided');
        return $this->client->put("$this->endpoint/$this->id", [$this->wrapper => $data])->response();
    }

    /**
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!empty($id))
            $this->id = $id;
        if (!$this->id)
            throw new \InvalidArgumentException('No valid ID provided');
        return $this->client->delete("$this->endpoint/$this->id")->response();
    }
}