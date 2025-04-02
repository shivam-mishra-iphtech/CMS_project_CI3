<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebController extends CI_Controller {
    public $db; 
    public $session;
    public $form_validation;
    public $UserModel;
    public $upload;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('UserModel'); 
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation', 'upload']);
    }

    public function index() {
        $data['latest_posts']=$this->UserModel->get_latest_post();
        $this->load->view('web/index', $data);
    }

    public function registration() {
        $this->load->view('web/registration');
    }

    public function add_user() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('web/registration');
        } else {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            ];
            if ($this->UserModel->insert_user($data)) {
                $this->session->set_flashdata('success', 'Registration successful. Please login.');
                redirect('WebController/registration');
            } else {
                $this->session->set_flashdata('error', 'Error registering user.');
                redirect('WebController/registration');
            }
        }
    }

    public function login_user() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('web/login');
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->UserModel->get_user_by_email($email);

            if ($user && password_verify($password, $user->password)) {
                if ($user->status != 1) {
                    $this->session->set_flashdata('error', 'Your account is disabled. Please contact the admin.');
                    redirect('login');
                    return;
                }
                $userdata = [
                    'user_id'    => $user->id,
                    'user_name'  => $user->name,
                    'user_email' => $user->email,
                    'user_image' => $user->image,
                    'user_role'  => $user->role,
                    'logged_in'  => TRUE
                ];
                $this->session->set_userdata($userdata);
                $this->session->set_flashdata('success', 'Login successful.');

                if ($user->role == '2' || $user->role == '1') {
                    redirect('AdminController/dashboard');
                } else {
                    redirect('WebController/index');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password.');
                $this->load->view('web/login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_image', 'logged_in']);
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        $this->load->view('web/login');
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            $user_role = $this->session->userdata('user_role');

            if ($user_role == 1 || $user_role == 2) {
                redirect('AdminController/dashboard'); 
            } else {
                redirect('WebController/index'); 
            }
        }
        $this->load->view('web/login');
    }
    public function user_profile($id){
        if (!$this->session->userdata('user_id')) {
            redirect('WebController/login');
            return;
        }
        $data['user'] = $this->UserModel->get_user_by_id($id);
        
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect('index');  
            return; 
        }
    
        // Fetch user image
        $image = $this->UserModel->get_user_image($id);
        $data['user_image']=$image;
    
        $this->load->view('web/userProfile', $data);
    }
    public function update_user() {
        // Get the user ID from the form
        $user_id = $this->input->post('user_id', TRUE);
        
        // Validate form input
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
        
        if ($this->form_validation->run() == FALSE) {
            // Load user data again if validation fails
            $data['user'] = $this->UserModel->get_user_by_id($user_id); 
            $this->load->view('web/user_profile', $data);
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
                redirect('WebController/user_profile/' . $user_id);
                return;
            }
        }
        
        // Update user in DB
        if (isset($Image_data) && !$this->UserModel->update_user_image($user_id, $Image_data)) {
            $this->session->set_flashdata('error', 'Image upload failed.');
            redirect('WebController/user_profile/' . $user_id);
            return;
        }
        
        if ($this->UserModel->update_user($user_id, $data)) {
            $this->session->set_flashdata('success', 'User updated successfully.');
            redirect('WebController/user_profile/' . $user_id);
        } else {
            $this->session->set_flashdata('error', 'Failed to update user.');
            redirect('WebController/user_profile/' . $user_id);
        }
    }
    public function email_check($email, $user_id) {
        $user = $this->UserModel->get_user_by_email($email);
    
        if ($user && $user->id != $user_id) {
            $this->form_validation->set_message('email_check', 'The {field} is already in use by another user.');
            return FALSE;
        }
        return TRUE;
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
            redirect('WebController/user_profile/' . $id);
            return;
        }

        // Fetch user details
        $user = $this->UserModel->get_user_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('WebController/user_profile/' . $id);
            return;
        }

        // Verify current password
        if (!password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('WebController/user_profile/' . $id);
            return;
        }
        if (password_verify($new_password, $user->password)) {
            $this->session->set_flashdata('error', 'New password must be different from the old password.');
            redirect('WebController/user_profile/' . $id);
            return;
        }
        

        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password
        if ($this->UserModel->update_password($id, $hashed_password)) {
            $this->session->set_flashdata('success', 'Password updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update password.');
        }

        // Redirect back to user profile page
        redirect('WebController/user_profile/' . $id);
    }
    // public function view_post() {
    //     // $data['latest_posts']=$this->UserModel->get_latest_post();
    //     $this->load->view('web/posts');
    // }
    public function view_post_by_id($id) {
        // Fetch the latest post by ID
        $data['latest_post'] = $this->UserModel->get_post_by_id($id);
    
        // Check if the latest post exists
        if (!empty($data['latest_post'])) {
            // Get the category of the latest post
            $post_category = $data['latest_post']->category;
    
            // Fetch related posts based on the category of the latest post
            $data['related_posts'] = $this->UserModel->get_related_posts($id, $post_category);
    
            // Load the view and pass both latest_post and related_posts data
            $this->load->view('web/posts', $data);
        } else {
            // If no post is found, show a 404 error
            show_404();
        }
    }
    
    
   
    
    public function view_page() {
        // $data['latest_posts']=$this->UserModel->get_latest_post();
        $this->load->view('web/pages');
    }
}
