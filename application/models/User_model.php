<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    function getAllUsersWithProfile()
    {
        $this->db->select("*");;
        $this->db->from("users");;
        $this->db->join("profiles", "profiles.user_id = users.id", "inner");
        $query = $this->db->get;
        return $query;
    }
}


?>