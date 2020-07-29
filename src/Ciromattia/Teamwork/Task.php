<?php

namespace Ciromattia\Teamwork;

use Ciromattia\Teamwork\Traits\TimeTrait;
use Ciromattia\Teamwork\Traits\RestfulTrait;

class Task extends TeamworkObject
{
    use RestfulTrait, TimeTrait;

    protected $wrapper = 'task';
    protected $endpoint = 'tasks';

    /**
     * Get All Tasks
     * GET /tasks.json
     *
     * @param null $args
     *
     * @return mixed
     */
    public function all($args = null)
    {
        $this->areArgumentsValid($args, ['filter', 'page', 'pageSize', 'startdate', 'enddate', 'updatedAfterDate', 'completedAfterDate', 'completedBeforeDate', 'showDeleted', 'includeCompletedTasks', 'includeCompletedSubtasks', 'creator-ids', 'include', 'responsible-party-ids', 'sort', 'getSubTasks', 'nestSubTasks', 'getFiles', 'dataSet', 'includeToday', 'ignore-start-date', 'tag-ids']);

        return $this->client->get($this->endpoint, $args)->response();
    }
    
     /**
     * Get detail of a single task
     * GET tasks/{id}.json
     *
     * @return mixed
     */
    public function details()
    {
        return $this->client->get("$this->endpoint/$this->id", [])->response();
    }

    /**
     * Complete A Task
     * PUT tasks/{id}/complete.json
     *
     * @return mixed
     */
    public function complete()
    {
        return $this->client->put("$this->endpoint/$this->id/complete", [])->response();
    }

    /**
     * Uncomplete A Task
     * PUT tasks/{id}/uncomplete.json
     *
     * @return mixed
     */
    public function uncomplete()
    {
        return $this->client->put("$this->endpoint/$this->id/uncomplete", [])->response();
    }

    /**
     * Time Totals
     * GET /projects/{id}/time/total.json
     *
     * @return mixed
     */
    public function timeTotal()
    {
        return $this->client->get("$this->endpoint/$this->id/time/total")->response();
    }

    /**
     * Create Time Entry
     * POST /tasks/{id}/time_entries.json
     *
     * @param $data
     *
     * @return mixed
     */
    public function createTime($data)
    {
        return $this->client->post("$this->endpoint/$this->id/time_entries", ['time-entry' => $data])->response();
    }

    /**
     * Edit A Task
     * PUT tasks/{id}.json
     *
     * @return mixed
     */
    public function edit($args)
    {
        return $this->client->put("$this->endpoint/$this->id.json", ['todo-item' => $args])->response();
    }
}
