<?php
class MenuController extends CI_Controller {
    public $db; // 🔹 Declare db property to avoid dynamic property issue
    public $session;
    public $form_validation;
    public $UserModel;
    public $AdminModel;
    public $upload;
    public $pagination;
    public function __construct() {
        parent::__construct();
        $this->load->model('MenuModel');
        $this->load->model('AdminModel');
        $this->load->library('form_validation');
    }

    public function manage_menus() {
        $data['menu_items'] = $this->MenuModel->get_all_menu_items();
        $data['posts'] = $this->AdminModel->get_all_posts();  
        $data['pages'] = $this->AdminModel->get_all_page();
        $this->load->view('admin/menu_management', $data);
    }

    public function save_menu_structure() {
        $menu_structure = json_decode($this->input->post('menu_structure'));
        $this->MenuModel->save_menu_order($menu_structure);
        
        $this->session->set_flashdata('success', 'Menu structure saved successfully');
        redirect('menu/manage_menus');
    }

    public function add_menu_item() {
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('menu/manage_menus');
        } else {
            $menu_type = $this->input->post('menu_type');
            $object_id = null;
            $url = null;
            $title = $this->input->post('title');
            
            switch($menu_type) {
                case 'page':
                    $object_id = $this->input->post('page_id');
                    $page = $this->AdminModel->get_page_by_id($object_id);
                    $title = $page->page_title;
                    $url = 'page/'.$page->slug;
                    break;
                case 'post':
                    $object_id = $this->input->post('post_id');
                    $post = $this->AdminModel->get_post_by_id($object_id);
                    $title = $post->post_title;
                    $url = 'post/'.$post->slug;
                    break;
                case 'custom':
                    $url = $this->input->post('url');
                    break;
            }
            
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'menu_name' => $this->input->post('menu_name'),
                'title' => $title,
                'menu_type' => $menu_type,
                'object_id' => $object_id,
                'url' => $url,
                'parent_id' => $this->input->post('parent_id'),
                'menu_position'=>$this->input->post('menu_position'),
                'newtab' => $this->input->post('newtab') ? 1 : 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->MenuModel->add_menu_item($data)) {
                $this->session->set_flashdata('success', 'Menu item added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add menu item');
            }
            
            redirect('MenuController/manage_menus');
        }
    }

    public function delete_item($id) {
        if ($this->MenuModel->delete_menu_item($id)) {
            $this->session->set_flashdata('success', 'Menu item deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete menu item');
        }
        redirect('MenuController/manage_menus');
    }
}
?>