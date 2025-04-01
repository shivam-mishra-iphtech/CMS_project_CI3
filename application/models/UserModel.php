<?php
class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all users (returns an array of users)
     */
    public function get_all_users() {
        return $this->db->order_by('id', 'DESC')->get('user')->result_array();
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
    public function get_related_posts($id, $category) {
        return $this->db->where('status', 1)->where('id !=', $id)  
            ->where('category', $category) ->get('posts')  ->result();  
    }
    
    
    
}
?>
