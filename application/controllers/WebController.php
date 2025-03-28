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
        $this->load->view('web/index');
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
    
            // Handle Profile Image Upload
            // if (!empty($_FILES['profile_image']['name'])) {
            //     $upload_path = BASEPATH . '../public/userImage/';
            //     if (!is_dir($upload_path)) {
            //         mkdir($upload_path, 0777, true);
            //     }
    
            //     $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            //     $unique_filename = time() . '_' . uniqid() . '.' . $file_ext;
                
            //     $config['upload_path'] = $upload_path;
            //     $config['allowed_types'] = 'jpg|jpeg|png';
            //     $config['max_size'] = 2048;
            //     $config['file_name'] = $unique_filename;
    
            //     $this->load->library('upload', $config);
            //     $this->upload->initialize($config);
    
            //     if ($this->upload->do_upload('profile_image')) {
            //         $data['image'] = $unique_filename; // Save only the filename
            //     } else {
            //         $this->session->set_flashdata('error', $this->upload->display_errors());
            //         redirect('WebController/registration');
            //     }
            // }
    
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
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_image', 'logged_in']);
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('login');
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
            redirect('dashboard');  
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
}
