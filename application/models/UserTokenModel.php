<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserTokenModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

    }

    public function get()
    {
        return $this->db->select('*')->from('user_token')->order_by('id','desc')->get()->result();
    }

    public function detail($id)
    {
        return $this->db->select('*')->from('user_token')->where('id', $id)->get()->row();
    }

    public function create($data)
    {
        $this->db->insert('user_token', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function update($data)
    {
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->where('id', $data['id'])->update('user_token', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('user_token');
    }

}
