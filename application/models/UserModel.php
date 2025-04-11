<?php
class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

   
    public function get_all_users() {
        return $this->db->order_by('id', 'DESC')->get('user')->result_array();
    }

   
    public function insert_user($data) {
        return $this->db->insert('user', $data);
    }

  
    public function register($data) {
        return $this->insert_user($data);
    }

    
    public function get_user($id) {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    
   
    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('user', $data);
    }
    public function update_user_image($user_id, $data) {
       
        $query = $this->db->get_where('users_image', ['user_id' => $user_id]);
    
        if ($query->num_rows() > 0) {
          
            return $this->db->where('user_id', $user_id)->update('users_image', $data);
        } else {
          
            $data['user_id'] = $user_id; 
            return $this->db->insert('users_image', $data);
        }
    }

    public function delete_user($id) {
        return $this->db->delete('user', ['id' => $id]);
    }
    public function get_user_by_email($email) {
        return $this->db->where('email', $email)->get('user')->row();
    }
    public function get_user_by_id($user_id) {
        return $this->db->get_where('user', ['id' => $user_id])->row();
    }
    public function get_user_image($user_id) {
        $query = $this->db->select('image')
                          ->get_where('users_image', ['user_id' => $user_id])
                          ->row();
        return $query ? $query->image : null;
    }

    
    public function get_user_image_by_id($user_id) {
        return $this->db->get_where('users_image', ['user_id' => $user_id])->row();
    }
    

    public function update_password($id, $hashed_password) {
        $this->db->where('id', $id);
        $this->db->set('password', $hashed_password);
        
        if ($this->db->update('user')) {
            return $this->db->affected_rows() > 0; 
        }
        return false; 
    }
    public function get_latest_post()
    {
        $this->db->where('category','1');
        $this->db->where('status',1);
        $this->db->order_by('id', 'DESC'); 
        return $this->db->get('posts')->result();

    }
    
    public function get_post_by_id($id) {
        $this->db->where('status',1);
        return $this->db->where('id', $id)->get('posts')->row();
    }
    public function get_all_post() {
        return $this->db->where('status', 1)
           ->get('posts')->result();
    }
    public function get_related_posts($id, $category) {
        return $this->db->where('status', 1)->where('id !=', $id)->where('category', $category)
            ->limit(10)->get('posts')->result();
    }
    public function get_banners_by_type($type) {
        return $this->db->get_where('banner', ['banner_type' => $type, 'status'=>1])->result();
    }
    public function get_logo($type) {
        return $this->db->where(['banner_type' => $type, 'status' => 1])->order_by('id', 'DESC')->limit(1)->get('banner')->row();
    }
    public function get_user_post_comment() {
        return $this->db->where([ 'status' => 1])->order_by('id', 'DESC')->limit(1)->get('user_coments')->row();
    } 
    public function get_user_post_comment_by($post_id) {
        return $this->db
            ->where(['post_id' => $post_id, 'status' => 0])
            ->order_by('id', 'DESC')
           
            ->get('user_coments')
            ->result(); // use result() to get multiple comments, not row()
    }
    
    public function get_all_categories() {
        return $this->db
           ->get('post_category')->result();
    }
    
    
    public function add_post_comment($data){
       return $this->db->insert('user_coments', $data);
    }
    
    
    
    public function get_all_post_paginated($limit, $offset)
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get('posts')
                        ->result();
    }
    public function search_posts($query)
    {
        $this->db->like('post_title', $query);
        $this->db->or_like('short_desc', $query);
        $this->db->or_like('content', $query);
        return $this->db->get('posts')->result(); // adjust 'posts' to your table name
    }

    public function get_post_count()
    {
        return $this->db->count_all('posts');
    }

}
?>
