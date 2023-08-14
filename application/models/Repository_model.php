<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Repository_model extends CI_Model
{
    function getAll($table) 
    {
        return $this->db->get($table);
    }

    function getDetail($table, $id)
    {
        return $this->db->get_where($table, ["id" => $id]);
    }

    function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function update($data, $where, $table)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    function delete($table, $id)
    {
        return $this->db->delete($table, ['id' => $id]);
    }
}


?>