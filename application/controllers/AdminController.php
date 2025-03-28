<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public $db; // 🔹 Declare db property to avoid dynamic property issue
    public $session;
    public $form_validation;
    public $UserModel;
    public $AdminModel;
    public $upload;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db = $this->load->database(); 
        $this->load->model('UserModel'); 
        $this->load->model('AdminModel'); 
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation', 'upload']);
    }

    public function dashboard() {
        if (!$this->session->userdata('user_id')) {
            redirect('WebController/login');
            return;
        }
        if ($this->session->userdata('user_role')!=2) {
            redirect('WebController/index');
            return;
        }
    
        $this->load->library('pagination');
        $config['base_url'] = site_url('AdminController/dashboard');
        $config['total_rows'] = $this->AdminModel->get_users_count();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['users'] = $this->AdminModel->get_users_paginated($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();
        $this->load->view('admin/dashboard', $data);
    }
    
    public function user_list() {
       
        if (!$this->session->userdata('user_id')) {
            redirect('WebController/login');
            return;
        }
        $data['users'] = $this->AdminModel->get_all_users();
        $this->load->view('admin/user_list', $data);
    }
    public function add_user(){
        $this->load->view('admin/add_user');
    }
    public function add_new_user() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/add_user');
        } else {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            ];
    
    
            if ($this->UserModel->insert_user($data)) {
                $this->session->set_flashdata('success', 'New  user add successfully.');
                redirect('AdminController/add_user');
            } else {
                $this->session->set_flashdata('error', 'Error in adding new user.');
                redirect('AdminController/add_user');
            }
        }
    }
    public function user_profile($id) {
        $data['user'] = $this->AdminModel->get_user_by_id($id);
        
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect('dashboard');  
            return; 
        }
    
        // Fetch user image
        $image = $this->AdminModel->get_user_image($id);
        $data['user_image']=$image;
    
        // Debugging
        // echo "<pre>";
        // print_r($data['user_image']);
        // die;
    
        $this->load->view('admin/user_profile', $data);
    }
    
    
    
    public function edit_user($id) {
        $data['user'] = $this->AdminModel->get_user_by_id($id);

        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect('dashboard');
        }

        $this->load->view('admin/edit_user', $data);
    }
    // public function update_user() {
    //     // echo "test";die;
    //     // Get the user ID from the form
    //     $user_id = $this->input->post('user_id', TRUE);
        
    //     // Validate form input
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim');
    //     $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
    //     // echo "test";die;
    //     if ($this->form_validation->run() == FALSE) {
    //         // Load user data again if validation fails
    //         $data['user'] = $this->AdminModel->get_user_by_id($user_id); 
    //         $this->load->view('admin/edit_user', $data);
    //     }
        
    //     // Handle Profile Image Upload
    //         if (!empty($_FILES['profile_image']['name'])) {
    //             $upload_path = BASEPATH . '../public/userImage/';
    //             if (!is_dir($upload_path)) {
    //                 mkdir($upload_path, 0777, true);
    //             }
                
    //             $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    //             $unique_filename = time() . '_' . uniqid() . '.' . $file_ext;
                
    //             $config['upload_path'] = $upload_path;
    //             $config['allowed_types'] = 'jpg|jpeg|png';
    //             $config['max_size'] = 5048;
    //             $config['file_name'] = $unique_filename;
    
    //             $this->load->library('upload', $config);
    //             $this->upload->initialize($config);
    
    //             if ($this->upload->do_upload('profile_image')) {
                   
    //                 $data['image'] = $unique_filename; // Save only the filename
    //             } else {
                    
    //                 $this->session->set_flashdata('error', $this->upload->display_errors());
    //                 redirect('AdminController/edit_user/'. $user_id);
    //             }
    //         }
            
    //         else {
    //         // Prepare user data for update
    //         $data = [
    //             'name' => $this->input->post('name', TRUE),
    //             'email' => $this->input->post('email', TRUE),
    //         ];
            
    //         // Update user in DB
    //         if (!$this->AdminModel->update_user_image($user_id,$data['image'])) {
    //             $this->session->set_flashdata('error', 'image does not upload .');
    //             redirect('AdminController/user_profile/' . $user_id);
    //         }
    //         if ($this->AdminModel->update_user($user_id, $data)) {
    //             $this->session->set_flashdata('success', 'User updated successfully.');
    //             redirect('AdminController/user_profile/' . $user_id);
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update user.');
    //             redirect('AdminController/edit_user/' . $user_id);
    //         }
    //     }
    // }
    public function update_user() {
        // Get the user ID from the form
        $user_id = $this->input->post('user_id', TRUE);
        
        // Validate form input
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
        
        if ($this->form_validation->run() == FALSE) {
            // Load user data again if validation fails
            $data['user'] = $this->AdminModel->get_user_by_id($user_id); 
            $this->load->view('admin/edit_user', $data);
            return;
        }
        
        // Prepare user data
        $data = [
            'name' => $this->input->post('name', TRUE),
            'email' => $this->input->post('email', TRUE),
        ];
        
        // Handle Profile Image Upload
        if (!empty($_FILES['profile_image']['name'])) {
            $upload_path = BASEPATH . '../public/userImage/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            
            $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $unique_filename = time() . '_' . uniqid() . '.' . $file_ext;
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $unique_filename;
    
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('profile_image')) {
                $Image_data=['image'=> $unique_filename]; // Save only the filename
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('AdminController/edit_user/' . $user_id);
                return;
            }
        }
        
        // Update user in DB
        if (isset($Image_data) && !$this->AdminModel->update_user_image($user_id, $Image_data)) {
            $this->session->set_flashdata('error', 'Image upload failed.');
            redirect('AdminController/user_profile/' . $user_id);
            return;
        }
        
        if ($this->AdminModel->update_user($user_id, $data)) {
            $this->session->set_flashdata('success', 'User updated successfully.');
            redirect('AdminController/user_profile/' . $user_id);
        } else {
            $this->session->set_flashdata('error', 'Failed to update user.');
            redirect('AdminController/edit_user/' . $user_id);
        }
    }
    
    
    
    // Callback function to check unique email for update
    public function email_check($email, $user_id) {
        $user = $this->AdminModel->get_user_by_email($email);
    
        if ($user && $user->id != $user_id) {
            $this->form_validation->set_message('email_check', 'The {field} is already in use by another user.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete_user($user_id) {
        // Load the AdminModel if not loaded
        $this->load->model('AdminModel');
    
        // Check if the user exists before attempting to delete
        $user = $this->AdminModel->get_user_by_id($user_id);
        
        if ($user) {
            // Attempt to delete the user
            $deleted = $this->AdminModel->delete_user($user_id);
    
            if ($deleted) {
                $this->session->set_flashdata('success', 'User deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete user. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error', 'User not found.');
        }
    
        // Redirect to user list
        redirect('AdminController/user_list');
    }
    public function change_password() {
        
        $id = $this->input->post('user_id');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
       
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/user_profile/' . $id);
            return;
        }

        // Fetch user details
        $user = $this->AdminModel->get_user_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('AdminController/user_profile/' . $id);
            return;
        }

        // Verify current password
        if (!password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('AdminController/user_profile/' . $id);
            return;
        }
        if (password_verify($new_password, $user->password)) {
            $this->session->set_flashdata('error', 'New password must be different from the old password.');
            redirect('AdminController/user_profile/' . $id);
            return;
        }
        

        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password
        if ($this->AdminModel->update_password($id, $hashed_password)) {
            $this->session->set_flashdata('success', 'Password updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update password.');
        }

        // Redirect back to user profile page
        redirect('AdminController/user_profile/' . $id);
    }

    
    
    
    
    
    
    

    
    
}