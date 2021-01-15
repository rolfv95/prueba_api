<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserTypeModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

    }

    public function get()
    {
        return $this->db->select('*')->from('user_type')->order_by('id','desc')->get()->result();
    }

    public function detail($id)
    {
        return $this->db->select('*')->from('user_type')->where('id', $id)->get()->row();
    }

    public function create($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->insert('user_type', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function update($data)
    {
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->where('id', $data['id'])->update('user_type', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('user_type');
    }

}
