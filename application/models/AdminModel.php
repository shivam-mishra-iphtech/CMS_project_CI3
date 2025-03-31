<?php
class AdminModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    public function get_all_users() {
        $this->db->where('role <>', 2); 
        $this->db->order_by('id', 'DESC'); 
        return $this->db->get('user')->result(); 
    }
    public function get_users_paginated($limit, $start) {
        $this->db->where('role !=', 2);
        $this->db->limit($limit, $start);
        $query = $this->db->get('user');
        return $query->result();
    }
    
    public function get_users_count() {
        $this->db->where('role !=', 2);
        return $this->db->count_all_results('user');
    }
    
    
    

    /**
     * Insert a new user into the database
     */
    public function insert_user($data) {
        return $this->db->insert('user', $data);
    }


    /**
     * Register user (Alias for insert_user)
     */
    public function register($data) {
        return $this->insert_user($data);
    }

    /**
     * Get a single user by ID
     */
    public function get_user($id) {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    /**
     * Update user details
     */
    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('user', $data);
    }
    public function update_user_image($user_id, $data) {
        // Check if the user already has an image entry
        $query = $this->db->get_where('users_image', ['user_id' => $user_id]);
    
        if ($query->num_rows() > 0) {
            // User exists, update the image
            return $this->db->where('user_id', $user_id)->update('users_image', $data);
        } else {
            // User does not exist, insert a new record
            $data['user_id'] = $user_id; // Ensure user_id is part of the data array
            return $this->db->insert('users_image', $data);
        }
    }
    
    
    

    /**
     * Delete a user by ID
     */
    public function delete_user($id) {
        return $this->db->delete('user', ['id' => $id]);
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
    
    public function get_user_by_email($email) {
        return $this->db->where('email', $email)->get('user')->row();
    }
    public function update_password($id, $hashed_password) {
        $this->db->where('id', $id);
        $this->db->set('password', $hashed_password);
        
        if ($this->db->update('user')) {
            return $this->db->affected_rows() > 0; 
        }
        return false; 
    }
    public function add_new_post($data) {
        return $this->db->insert('posts', $data);
    }
    public function get_all_posts() {
        $this->db->order_by('id', 'DESC'); 
        return $this->db->get('posts')->result();
    }
    public function get_post_by_id($id) {
        return $this->db->where('id', $id)->get('posts')->row();
    }
    public function update_post($id, $data) {
        return $this->db->where('id', $id)->update('posts', $data);
    }
    public function delete_post($post_id) {
        return $this->db->delete('posts', ['id' => $post_id]);
    }


    
    
}
?>
