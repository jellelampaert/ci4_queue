<?php

namespace jellelampaert\ci4_queue;

use jellelampaert\ci4_queue\Models\QueueModel;

class Queue
{

    private $queue;

    private $model;

    public function __construct()
    {
        $this->queue = '';
        $this->model = new QueueModel();
    }

    /*
     * Add data to the queue
     * 
     * @param mixed $data
     */
    public function add($data)
    {
        $this->model->queue($this->queue, $data);
    }

    /*
     * Clears tasks older than x hours for a specific queue
     * 
     * @param int $hours
     */
    public function clean($hours = 108000)
    {
        $this->model->cleanOldTasks($this->queue, $hours);
    }

    /*
     * Clears tasks older than x hours for all queues
     * 
     * @param int $hours
     */
    public function cleanAll($hours = 108000)
    {
        $this->model->cleanAllOldTasks($hours);
    }

    /*
     * Delete a task
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->model->deleteTask($id);
    }

    /*
     * Get all tasks from the queue, ignoring their processing-status
     * 
     * @return array
     */
    public function getAllTasks()
    {
        return $this->model->getAllTasks($this->queue);
    }

    /*
     * Get all unprocessed tasks, ignoring the queue
     * 
     * @return array
     */
    public function getAllUnprocessed()
    {
        return $this->model->getAllUnprocessed();
    }

    /*
     * Get a task by it's ID
     * 
     * @return object|boolean
     */
    public function getTask($id)
    {
        return $this->model->getTask($id);
    }

    /*
     * Get all unprocessed tasks from the queue
     * 
     * @param string $queue
     * @return array
     */
    public function getUnprocessed()
    {
        return $this->model->getUnprocessed($this->queue);
    }

    /*
     * Set the task as processed
     * 
     * @param int $id
     */
    public function setProcessed($id)
    {
        $this->model->setProcessed($id);
    }

    /*
     * Set the response of this queue (i.e. when needed for logging)
     * 
     * @param int $id
     * @param mixed $data
     */
    public function setResponse($id, $data)
    {
        $this->model->setResponse($id, $data);
    }

    /*
     * Select the name of the queue to use
     * 
     * @param string $queue
     * @return $this
     */
    public function queue($queue)
    {
        $this->queue = $queue;

        return $this;
    }
}