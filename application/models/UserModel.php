<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

    }

    public function get()
    {
        return $this->db->select('*')->from('user')->order_by('id','desc')->get()->result();
    }

    public function getById($id)
    {
        return $this->db->select('*')->from('user')->where('user_type_id', $id)->order_by('id','desc')->get()->result();
    }

    public function detail($id)
    {
        return $this->db->select('*')->from('user')->where('id', $id)->get()->row();
    }

    public function create($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->insert('user', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function update($data)
    {
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->where('id', $data['id'])->update('user', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('user');
    }

}
