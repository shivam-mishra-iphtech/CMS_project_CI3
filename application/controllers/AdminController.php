<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{

    public $db; // 🔹 Declare db property to avoid dynamic property issue
    public $session;
    public $form_validation;
    public $UserModel;
    public $AdminModel;
    public $upload;
    public $pagination;
    public $Menu_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db = $this->load->database();
        $this->load->model('UserModel');
        $this->load->model('AdminModel');
        $this->load->model('Menu_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation', 'upload']);
    }

    public function dashboard()
{
    // Check if the user is logged in
    if (!$this->session->userdata('user_id')) {
        redirect('WebController/login');
        return;
    }

    // Allow only user_role 1 or 2 to access the admin panel
    $user_role = $this->session->userdata('user_role');
    if ($user_role != 1 && $user_role != 2) {
        redirect('WebController/index');
        return;
    }

    // Pagination setup
    $this->load->library('pagination');
    $config['base_url'] = site_url('AdminController/dashboard');
    $config['total_rows'] = $this->AdminModel->get_users_count();
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $data['users'] = $this->AdminModel->get_users_paginated($config['per_page'], $page);
    $data['pagination_links'] = $this->pagination->create_links();

    // Load dashboard view
    $this->load->view('admin/dashboard', $data);
}


    public function user_list()
    {  
        if ($this->session->userdata('user_role') != 2) {
            redirect('WebController/index');
            return;
        }

        if (!$this->session->userdata('user_id')) {
            redirect('WebController/login');
            return;
        }
        $data['users'] = $this->AdminModel->get_all_users();
        $this->load->view('admin/user_list', $data);
    }
    public function add_user()
    {
        $this->load->view('admin/add_user');
    }
    public function add_new_user()
    {
        if ($this->session->userdata('user_role') != 2) {
            $this->session->set_flashdata('error', 'You can not add user ! Please Contact to admin.');
            redirect('AdminController/dashboard');
            return;
        }
        $this->form_validation->set_rules('user_role', 'User Role');
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
                'role'=>$this->input->post('user_role', TRUE)??0,
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
    public function user_profile($id)
    {
        $data['user'] = $this->AdminModel->get_user_by_id($id);

        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect('AdminController/dashboard');
            return;
        }

        // Fetch user image
        $image = $this->AdminModel->get_user_image($id);
        $data['user_image'] = $image;

        // Debugging
        // echo "<pre>";
        // print_r($data['user_image']);
        // die;

        $this->load->view('admin/user_profile', $data);
    }



    public function edit_user($id)
    {
        $data['user'] = $this->AdminModel->get_user_by_id($id);

        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect('dashboard');
        }

        $this->load->view('admin/edit_user', $data);
    }
    
    
    public function update_user()
{
    $user_id = $this->input->post('user_id', TRUE);
    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');

    if ($this->form_validation->run() == FALSE) {
        // Reload view with existing user data on validation failure
        $data['user'] = $this->UserModel->get_user_by_id($user_id);
        $this->load->view('admin/edit_user', $data);
        return;
    }

    // Prepare data for update
    $data = [
        'name' => $this->input->post('name', TRUE),
        'email' => $this->input->post('email', TRUE),
        'role' => $this->input->post('user_role', TRUE)
    ];

    $Image_data = [];

    // Handle image upload if provided
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
            $Image_data = ['image' => $unique_filename];
        } else {
            // Upload failed
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('AdminController/edit_user/' . $user_id);
            return;
        }
    }

    // If image uploaded, update image
    if (!empty($Image_data)) {
        if (!$this->AdminModel->update_user_image($user_id, $Image_data)) {
            $this->session->set_flashdata('error', 'Image upload failed.');
            redirect('AdminController/user_profile/' . $user_id);
            return;
        }
    }

    // Update user info
    if ($this->AdminModel->update_user($user_id, $data)) {
        $this->session->set_flashdata('success', 'User updated successfully.');
        redirect('AdminController/user_profile/' . $user_id);
    } else {
        $this->session->set_flashdata('error', 'Failed to update user.');
        redirect('AdminController/edit_user/' . $user_id);
    }
}




    // Callback function to check unique email for update
    public function email_check($email, $user_id)
    {
        $user = $this->AdminModel->get_user_by_email($email);

        if ($user && $user->id != $user_id) {
            $this->form_validation->set_message('email_check', 'The {field} is already in use by another user.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete_user($user_id)
    {
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
    public function change_password()
    {

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

    public function add_post()
    {
        $data['categories'] = $this->AdminModel->get_post_category();
        $this->load->view('admin/add_post', $data);
    }
    public function add_new_post()
    {
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/add_post');
            return;
        }
        $title= $this->input->post('title');
        $slug = $this->AdminModel->generate_slug($title);

        $upload_path = BASEPATH . '../public/postImages/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $thumbnail_image = null;
        $featured_image = null;

        // Handle Thumbnail Upload
        if (!empty($_FILES['thumbnail_image']['name'])) {
            $file_ext1 = pathinfo($_FILES['thumbnail_image']['name'], PATHINFO_EXTENSION);
            $thumbnail_image = time() . '_' . uniqid() . '.' . $file_ext1;

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $thumbnail_image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('thumbnail_image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('AdminController/add_post');
                return;
            }
        }

        // Handle Featured Image Upload
        if (!empty($_FILES['Featured_image']['name'])) {
            $file_ext2 = pathinfo($_FILES['Featured_image']['name'], PATHINFO_EXTENSION);
            $featured_image = time() . '_' . uniqid() . '.' . $file_ext2;

            $config['file_name'] = $featured_image;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('Featured_image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('AdminController/add_post');
                return;
            }
        }

        // Prepare Data for Insertion
        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'post_title' => $this->input->post('title', TRUE),
            'short_desc' => json_encode($this->input->post('short_description', TRUE)),
            'content' => json_encode($this->input->post('content', TRUE)),
            'category' => $this->input->post('category', TRUE),
            'slug'=> $slug,
            'thumbnail' => $thumbnail_image,
            'featured_image' => $featured_image,
        ];

        // Insert into Database
        if ($this->AdminModel->add_new_post($data)) {
            $this->session->set_flashdata('success', 'New post added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error in adding new post.');
        }

        redirect('AdminController/add_post');
    }
    public function posts_list()
    {
        // echo "test";die;
        $data['posts'] = $this->AdminModel->get_all_posts();
        $this->load->view('admin/post_list', $data);
    }
    public function view_post($id)
    {
        $data['post'] = $this->AdminModel->get_post_by_id($id);
        $this->load->view('admin/view_post', $data);
    }
    public function edit_post($id)
    {
        $data['post'] = $this->AdminModel->get_post_by_id($id);
        $this->load->view('admin/edit_post', $data);
    }
    public function update_post()
    {
        $post_id = $this->input->post('post_id', TRUE);
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/edit_post/' . $post_id);
            return;
        }

        $existing_post = $this->AdminModel->get_post_by_id($post_id);

        if (!$existing_post) {
            $this->session->set_flashdata('error', 'Post not found.');
            redirect('AdminController/posts_list');
            return;
        }

        $upload_path = BASEPATH . '../public/postImages/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $thumbnail_image = $existing_post->thumbnail;
        $featured_image = $existing_post->featured_image;

        if (!empty($_FILES['thumbnail_image']['name'])) {
            $file_ext1 = pathinfo($_FILES['thumbnail_image']['name'], PATHINFO_EXTENSION);
            $thumbnail_image = time() . '_' . uniqid() . '.' . $file_ext1;

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $thumbnail_image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('thumbnail_image')) {
                if (!empty($existing_post->thumbnail) && file_exists($upload_path . $existing_post->thumbnail)) {
                    unlink($upload_path . $existing_post->thumbnail);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('AdminController/edit_post/' . $post_id);
                return;
            }
        }

        if (!empty($_FILES['featured_image']['name'])) {
            $file_ext2 = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $featured_image = time() . '_' . uniqid() . '.' . $file_ext2;
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $featured_image;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('featured_image')) {
                // Delete old featured image if new one is uploaded
                if (!empty($existing_post->featured_image) && file_exists($upload_path . $existing_post->featured_image)) {
                    unlink($upload_path . $existing_post->featured_image);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('AdminController/edit_post/' . $post_id);
                return;
            }
        }

        // Prepare Data for Update
        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'post_title' => $this->input->post('title', TRUE),
            'short_desc' => json_encode($this->input->post('short_description', TRUE)),
            'content' => json_encode($this->input->post('content', TRUE)),
            'category' => $this->input->post('category', TRUE),
            'thumbnail' => $thumbnail_image,
            'featured_image' => $featured_image,
        ];

        if ($this->AdminModel->update_post($post_id, $data)) {
            $this->session->set_flashdata('success', 'Post updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error updating post.');
        }

        redirect('AdminController/edit_post/' . $post_id);
    }
    public function delete_post($post_id)
    {
        $existing_post = $this->AdminModel->get_post_by_id($post_id);
        if (!$existing_post) {
            $this->session->set_flashdata('error', 'Post not found.');
            redirect('AdminController/posts_list');
            return;
        }
        $upload_path = BASEPATH . '../public/postImages/';
        if (!empty($existing_post->featured_image) && file_exists($upload_path . $existing_post->featured_image)) {
            unlink($upload_path . $existing_post->featured_image);
        }
        if (!empty($existing_post->thumbnail) && file_exists($upload_path . $existing_post->thumbnail)) {
            unlink($upload_path . $existing_post->thumbnail);
        }
        if ($this->AdminModel->delete_post($post_id)) {
            $this->session->set_flashdata('success', 'Post deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete post. Please try again.');
        }
        redirect('AdminController/posts_list');

    }
    public function update_post_status()
    {
        $post_id = $this->input->post('post_id');
        $status = $this->input->post('status');

        if (!empty($post_id)) {
            $this->db->where('id', $post_id);
            $this->db->update('posts', ['status' => $status]);

            echo json_encode(["status" => "success", "message" => "Post status updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid post ID!"]);
        }
    }

    
    public function page_category()
    {
        $data['pages']=$this->AdminModel->get_all_page();
        $data['menus'] = $this->AdminModel->get_page_category();

        if(!empty($data['menus'])){
            foreach($data['menus'] as $menu){
                $this->db->where('id', $menu->page_link);
                $query = $this->db->get('pages');
                $page= $query->row();

                if($page){
                    $menu->page_title = $page->page_title;
                    $menu->page_id= $page->id;
                }
                else{
                    $menu->page_title= 'Unknown';
                    $menu->page_id='Unknown';
                }
            }
        }
       
        $this->load->view('admin/page_category', $data);
        
    }
    public function add_page_category()
    // menu_type
    //menu_name
    // page_id
    {
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('page_id', 'Page ID', 'required');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        $this->form_validation->set_rules('menu_type', 'Menu Name', 'required|trim');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/page_category');
            return;
        }

        $category_id = $this->input->post('id'); // Hidden input for editing

        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'menu_name' => $this->input->post('menu_name', TRUE),
            'menu_type' => $this->input->post('menu_type', TRUE),
            'page_link' => $this->input->post('page_id', TRUE),


        ];

        if (!empty($category_id)) {
            // Update category
            if ($this->AdminModel->update_page_category($category_id, $data)) {
                $this->session->set_flashdata('success', 'Menu updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error updating Menu.');
            }
        } else {
            // Insert new category
            if ($this->AdminModel->add_page_category($data)) {
                $this->session->set_flashdata('success', 'New Menu added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error in adding new menu.');
            }
        }

        redirect('AdminController/page_category');
    }
    public function add_sub_menus()
    // menu_type
    //menu_name
    // page_id
    {
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('page_id', 'Page ID', 'required');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        $this->form_validation->set_rules('menu_type', 'Menu Name', 'required|trim');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/page_category');
            return;
        }

        $category_id = $this->input->post('id'); // Hidden input for editing

        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'menu_name' => $this->input->post('menu_name', TRUE),
            'menu_type' => $this->input->post('menu_type', TRUE),
            'page_link' => $this->input->post('page_id', TRUE),


        ];

        if (!empty($category_id)) {
            // Update category
            if ($this->AdminModel->update_page_category($category_id, $data)) {
                $this->session->set_flashdata('success', 'Category updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error updating category.');
            }
        } else {
            // Insert new category
            if ($this->AdminModel->add_page_category($data)) {
                $this->session->set_flashdata('success', 'New page category added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error in adding new category.');
            }
        }

        redirect('AdminController/page_category');
    }

    public function delete_page_category($id)
    {
        if ($this->AdminModel->delete_page_category($id)) {
            $this->session->set_flashdata('success', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category. Please try again.');
        }
        redirect('AdminController/page_category');
    }
    public function add_page()

    {   
        $this->load->view('admin/add_page' );

    }
    public function add_new_page()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }
        $title= $this->input->post('title');
        $slug = $this->AdminModel->generate_slug($title);

        $upload_path = BASEPATH . '../public/pageImages/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $image_1 = null;
        $image_2 = null;

        // Handle Thumbnail Upload
        if (!empty($_FILES['image_1']['name'])) {
            $file_ext1 = pathinfo($_FILES['image_1']['name'], PATHINFO_EXTENSION);
            $image_1 = time() . '_' . uniqid() . '.' . $file_ext1;

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $image_1;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image_1')) {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        if (!empty($_FILES['image_2']['name'])) {
            $file_ext1 = pathinfo($_FILES['image_2']['name'], PATHINFO_EXTENSION);
            $image_2 = time() . '_' . uniqid() . '.' . $file_ext1;

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5048;
            $config['file_name'] = $image_2;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image_2')) {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        // Prepare Data for Insertion
        $data = [
            'user_id'        => $this->input->post('user_id', TRUE),
            'page_title'     => $this->input->post('title', TRUE),
            'page_content'   => json_encode($this->input->post('content', TRUE)),
            'short_desc'     => json_encode($this->input->post('short_description', TRUE)),
            'page_category'  => $this->input->post('category', TRUE),
            'slug'           => $slug,
            'image_1'        => $image_1,
            'image_2'        => $image_2,
        ];

        // Insert into Database
        if ($this->AdminModel->add_new_page($data)) {
            echo json_encode(['status' => 'success', 'message' => 'New page added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error in adding new page.']);
        }
    }
    public function page_list()
    {
        $data['pages'] = $this->AdminModel->get_all_page();

        // if (!empty($data['pages'])) {
        //     foreach ($data['pages'] as &$page) {
        //         if (!empty($page->page_category)) {
        //             $this->db->where('id', $page->page_category);
        //             $query = $this->db->get('main_menu'); // Assuming 'categories' is the correct table name
        //             $category = $query->row(); // Fetch single row
                    
        //             if ($category) {
        //                 $page->category_name = $category->menu_name; // Assuming 'name' is the category column
        //             } else {
        //                 $page->category_name = 'Unknown';
        //             }
        //         }
        //     }
        // }

        $this->load->view('admin/page_list', $data);
    }

    public function update_page_status()
    {
        $post_id = $this->input->post('post_id');

        $status = $this->input->post('status');

        if (!empty($post_id)) {
            $this->db->where('id', $post_id);
            $this->db->update('pages', ['status' => $status]);

            echo json_encode(["status" => "success", "message" => "Page status updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid page ID!"]);
        }
    }
    public function edit_page($id){
       
        $data['page']=$this->AdminModel->get_page_by_id($id);
        $this->load->view('admin/edit_page',$data);
    }
    public function update_page()
    {
        $page_id = $this->input->post('page_id', TRUE);

        // Validation Rules
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
       

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => trim(validation_errors())]);
            return;
        }

        // Check if page exists
        $existing_page = $this->AdminModel->get_page_by_id($page_id);
        if (!$existing_page) {
            echo json_encode(['status' => 'error', 'message' => 'Page not found!']);
            return;
        }

        // Define upload path
        $upload_path = BASEPATH . '../public/pageImages/';

        // Create directory if not exists
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $image_1 = $existing_page->image_1;
        $image_2 = $existing_page->image_2;

        // Load Upload Library
        $this->load->library('upload');

        // Handle Image 1 Upload
        if (!empty($_FILES['image_1']['name'])) {
            $file_ext1 = pathinfo($_FILES['image_1']['name'], PATHINFO_EXTENSION);
            $image_1 = time() . '_' . uniqid() . '.' . $file_ext1;

            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 5048,
                'file_name'     => $image_1
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image_1')) {
                if (!empty($existing_page->image_1) && file_exists($upload_path . $existing_page->image_1)) {
                    unlink($upload_path . $existing_page->image_1);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        
        if (!empty($_FILES['image_2']['name'])) {
            $file_ext2 = pathinfo($_FILES['image_2']['name'], PATHINFO_EXTENSION);
            $image_2 = time() . '_' . uniqid() . '.' . $file_ext2;

            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 5048,
                'file_name'     => $image_2
            ];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image_2')) {
                if (!empty($existing_page->image_2) && file_exists($upload_path . $existing_page->image_2)) {
                    unlink($upload_path . $existing_page->image_2);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        // Prepare Data for Update
        $data = [
            'user_id'       => $this->input->post('user_id', TRUE),
            'page_title'    => $this->input->post('title', TRUE),
            'page_content'  => json_encode($this->input->post('content', TRUE)),
            'short_desc'    => json_encode($this->input->post('short_description', TRUE)),
            'page_category' => $this->input->post('category', TRUE),
            'image_1'       => $image_1,
            'image_2'       => $image_2,
        ];

        // Update Page
        if ($this->AdminModel->update_page($page_id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Page updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Page update failed!']);
        }
    }

    public function delete_page()
    {
        $page_id = $this->input->post('page_id');
        if (!$page_id) {
            echo json_encode(["status" => "error", "message" => "Invalid request"]);
            exit;
        }
        $existing_page = $this->AdminModel->get_page_by_id($page_id);
        if (!$existing_page) {
            echo json_encode(["status" => "error", "message" => "Page not found"]);
            exit;
        }
        $upload_path = BASEPATH . '../public/pageImages/';

        if (!empty($existing_page->image_2) && file_exists($upload_path . $existing_page->image_2)) {
            unlink($upload_path . $existing_page->image_2);
        }
        if (!empty($existing_page->image_1) && file_exists($upload_path . $existing_page->image_1)) {
            unlink($upload_path . $existing_page->image_1);
        }
        if ($this->AdminModel->delete_page($page_id)) {
            echo json_encode(["status" => "success", "message" => "Page deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete page."]);
        }
        exit;
    }
    public function view_page($id){
        // $data['categories'] = $this->AdminModel->get_page_category();
        $data['page']=$this->AdminModel->get_page_by_id($id);
        $this->load->view('admin/view_page',$data);
    }
    public function social_meadia() 
    {
        $data['media_icons'] = $this->AdminModel->get_media_icons();
        $data['social_media'] = $this->AdminModel->get_social_media();
    
        if (!empty($data['social_media'])) {
            foreach ($data['social_media'] as $social_media) {
                if (!empty($social_media->social_media_id)) {
                    $this->db->where('id', $social_media->social_media_id);
                    $query = $this->db->get('social_media_icons'); // Fetch corresponding media icon
    
                    $media_icons = $query->row(); // Fetch single row
    
                    if ($media_icons) {
                        $social_media->media_name  = $media_icons->media_name;
                        $social_media->icon_color  = $media_icons->icon_color;
                        $social_media->icon_class  = $media_icons->icon_class;
                        $social_media->media_icon_id  = $media_icons->id;
                    } else {
                        $social_media->media_name  = 'Unknown';
                        $social_media->icon_color  = 'Unknown';
                        $social_media->icon_class  = 'Unknown';
                    }
                }
            }
        }
    
        $this->load->view('admin/social_media', $data);
    }
    
    // INSERT INTO `social_media`(`id`, `user_id`, `social_media_name`, `media_link`, `media_icon`, `icon_color`, `status`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
    public function save_social_media()
    {
        // Validate form inputs
        $this->form_validation->set_rules('user_id', 'User ID', 'required|integer');
        $this->form_validation->set_rules('media_icon_id', 'Media Platform', 'required|integer');
        $this->form_validation->set_rules('media_link', 'Media Link', 'required|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/social_meadia');
            return;
        }

        // Get media icon details from database
        $media_icon = $this->AdminModel->get_media_icon_by_id($this->input->post('media_icon_id', TRUE));
        
        if (!$media_icon) {
            $this->session->set_flashdata('error', 'Invalid media platform selected');
            redirect('AdminController/social_meadia');
            return;
        }

        // Prepare data for insertion/update
        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'social_media_id' => $this->input->post('media_icon_id', TRUE),
            'media_link' => $this->input->post('media_link', TRUE),
            // Add additional fields if needed
        ];

        $social_media_id = $this->input->post('id', TRUE);

        try {
            if (!empty($social_media_id)) {
                // Update existing record
                $this->AdminModel->update_social_media($social_media_id, $data);
                $this->session->set_flashdata('success', 'Social media updated successfully.');
            } else {
                // Create new record
                $this->AdminModel->add_social_media($data);
                $this->session->set_flashdata('success', 'Social media added successfully.');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
        }

        redirect('AdminController/social_meadia');
    }
    public function delete_social_media($id){
       if($this->AdminModel->delete_social_media($id)){
          $this->session->set_flashdata('success', 'Social media deleted successfully.');
       }else{
         $this->session->set_flashdata('error', 'deleted error!.');
       }
       redirect('AdminController/social_meadia');
    }
   
    //-------------- post category controller function ------------


    public function post_category()
    {
        $data['post_categories'] = $this->AdminModel->get_post_category();
        $this->load->view('admin/post_category', $data);
        
    }
    public function add_post_category()
    {
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('title', 'Category Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/post_category');
            return;
        }

        $category_id = $this->input->post('id'); 

        $data = [
            'user_id' => $this->input->post('user_id', TRUE),
            'category_name' => $this->input->post('title', TRUE),
        ];

        if (!empty($category_id)) {
            // Update category
            if ($this->AdminModel->update_post_category($category_id, $data)) {
                $this->session->set_flashdata('success', 'Category updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error updating category.');
            }
        } else {
            // Insert new category
            if ($this->AdminModel->add_post_category($data)) {
                $this->session->set_flashdata('success', 'New post category added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error in adding new category.');
            }
        }

        redirect('AdminController/post_category');
    }

    public function delete_post_category($id)
    {
        if ($this->AdminModel->delete_post_category($id)) {
            $this->session->set_flashdata('success', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category. Please try again.');
        }
        redirect('AdminController/post_category');
    }

    public function users_post_comments() {
        $data['comments'] = $this->AdminModel->get_uset_post_comments();
    
        if (!empty($data['comments'])) {
            foreach ($data['comments'] as $comment) {
                $userImage = $this->AdminModel->get_user_image_by_id($comment->user_id);
                if ($userImage) {
                    $comment->userImage = $userImage->image; // assuming 'image' is the field name
                     // assuming 'name' is the field name
                } else {
                    $comment->userImage = 'default.jpg';      // fallback image
                        // fallback name
                }
            }
        }
    
        $this->load->view('admin/user_comments', $data);
    }
    public function update_comment_status()
    {
        $post_id = $this->input->post('post_id');
        $status = $this->input->post('status');

        if (!empty($post_id)) {
            $this->db->where('id', $post_id);
            $this->db->update('user_coments', ['status' => $status]);

            echo json_encode(["status" => "success", "message" => "Comment status updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid comment ID!"]);
        }
    }



   
    public function menu_management() {
        $data = [
            'menus' => $this->Menu_model->get_menu_with_submenus(),
            'pages' => $this->Menu_model->get_active_pages(),
            'posts' => $this->Menu_model->get_active_posts(),
            'categories' => $this->Menu_model->get_active_categories()
        ];

        // echo"<pre>";
        // print_r($data['categories']);die;
        
        $this->load->view('admin/manage_menu', $data);
    }
    
    public function get_menu_submenus() {
        $menu_id = $this->input->post('menu_id');
        $submenus = $this->Menu_model->get_submenus($menu_id);
        echo json_encode(['success' => true, 'submenus' => $submenus]);
    }
    
    public function save_menu() {
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
        $this->form_validation->set_rules('menu_position', 'Menu Position', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            return;
        }
    
        $menu_id = $this->input->post('id');
        $has_submenu = $this->input->post('has_submenu') ? 1 : 0;
        
        // Prepare main menu data
        $menu_data = [
            'user_id' => $this->session->userdata('user_id'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_position' => $this->input->post('menu_position'),
            'parent_id' => 0,
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        if (!$has_submenu) {
            // Handle main menu link
            $link_type = $this->input->post('main_link_type');
            $menu_data['link_type'] = $link_type;
            
            switch ($link_type) {
                case 'page':
                    $page_slug = $this->input->post('main_page_select');
                    $menu_data['url'] = $page_slug;
                    $menu_data['object_id'] = $page_slug;
                    break;
                    
                case 'post':
                    $post_slug = $this->input->post('main_post_select');
                    $menu_data['url'] = $post_slug;
                    $menu_data['object_id'] = $post_slug;
                    break;
                    
                case 'post_category':
                    $category_id = $this->input->post('main_category_select');
                    $menu_data['url'] = $category_id;
                    $menu_data['object_id'] = $category_id;
                    break;
                    
                case 'custom':
                    $menu_data['url'] = $this->input->post('main_custom_url');
                    $menu_data['object_id'] = null;
                    break;
            }
        } else {
            // For menu with submenus, set the main menu as a parent with no link
            $menu_data['link_type'] = 'parent';
            $menu_data['url'] = '#';
            $menu_data['object_id'] = null;
        }
    
        // Save or update the main menu
        if ($menu_id) {
            // Update existing menu
            $menu_data['id'] = $menu_id;
            $this->Menu_model->update_menu($menu_data);
        } else {
            // Create new menu
            $menu_id = $this->Menu_model->create_menu($menu_data);
        }
    
        // Handle submenus if exists
        if ($has_submenu) {
            $submenu_names = $this->input->post('submenu_names');
            $submenu_link_types = $this->input->post('submenu_link_types');
            $submenu_page_selects = $this->input->post('submenu_page_selects');
            $submenu_post_selects = $this->input->post('submenu_post_selects');
            $submenu_category_selects = $this->input->post('submenu_category_selects');
            $submenu_custom_urls = $this->input->post('submenu_custom_urls');
            
            // First, remove existing submenus if editing
            if ($menu_id) {
                $this->Menu_model->delete_submenus($menu_id);
            }
            
            // Add new submenus
            if (!empty($submenu_names)) {
                foreach ($submenu_names as $index => $name) {
                    $submenu_data = [
                        'parent_id' => $menu_id,
                        'menu_name' => $name,
                        'menu_position' => $menu_data['menu_position'],
                        'link_type' => $submenu_link_types[$index],
                        'sort_order' => $index + 1,
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    switch ($submenu_link_types[$index]) {
                        case 'page':
                            $submenu_data['url'] = $submenu_page_selects[$index];
                            $submenu_data['object_id'] = $submenu_page_selects[$index];
                            break;
                            
                        case 'post':
                            $submenu_data['url'] = $submenu_post_selects[$index];
                            $submenu_data['object_id'] = $submenu_post_selects[$index];
                            break;
                            
                        case 'post_category':
                            $submenu_data['url'] = $submenu_category_selects[$index];
                            $submenu_data['object_id'] = $submenu_category_selects[$index];
                            break;
                            
                        case 'custom':
                            $submenu_data['url'] = $submenu_custom_urls[$index];
                            $submenu_data['object_id'] = null;
                            break;
                    }
                    
                    $this->Menu_model->create_menu($submenu_data);
                }
            }
        }
    
        echo json_encode(['success' => true, 'message' => 'Menu saved successfully']);
    }
    
    public function delete_menu() {
        $id = $this->input->post('id');
        
        // First delete all submenus if any
        $this->Menu_model->delete_submenus($id);
        
        // Then delete the main menu
        $result = $this->Menu_model->delete_menu($id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Menu deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete menu']);
        }
    }
   
    




    














}
