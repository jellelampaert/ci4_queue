<?php namespace jellelampaert\ci4_queue\Models;

use CodeIgniter\Model;

class QueueModel extends Model
{
    protected $table = 'queue';

    public function deleteTask($id)
    {
        $this->db->table($this->table)->where('id', $id)->delete();
    }

    public function getAllTasks($queue)
    {
        $dbdata = $this->db->table($this->table)->where('queue', $queue)->orderBy('created', 'DESC')->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
        }
        return $dbdata;
    }

    public function getAllUnprocessed()
    {
        $dbdata = $this->db->table($this->table)->where('processed', 0)->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
        }
        return $dbdata;
    }

    public function getUnprocessed($queue)
    {
        $dbdata = $this->db->table($this->table)->where('processed', 0)->where('queue', $queue)->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
        }
        return $dbdata;
    }
    
    public function queue($queue, $data)
    {
        $this->db->table($this->table)->insert(array(
            'queue'     => $queue,
            'data'      => base64_encode(serialize($data)),
            'created'   => time()
        ));
    }

    public function setProcessed($id)
    {
        $this->db->table($this->table)->where('id', $id)->update(array(
            'processed' => time()
        ));
    }
}