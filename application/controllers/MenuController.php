<?php
class MenuController extends CI_Controller {
    public $MenuModel;
    public $db; 
    public $session;
    public $form_validation;
    public $UserModel;
    public $AdminModel;
    public $upload;
    public $pagination;
    public function __construct() {
        parent::__construct();
        $this->load->model('MenuModel');
    }

    public function manage_menus($menu_type = 'main-menu') {
        $data['menu_type'] = $menu_type;
        $data['menu_items'] = $this->MenuModel->get_menu_items($menu_type);
        $data['pages'] = $this->MenuModel->get_available_pages();
        $data['posts'] = $this->MenuModel->get_available_posts();
        
        $this->load->view('admin/layouts/header');
        $this->load->view('admin/menu_management', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save_order() {
        $items = json_decode($this->input->post('items'));
        $this->MenuModel->save_menu_order($items);
        echo json_encode(['status' => 'success']);
    }

    public function add_item() {
        $data = [
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'object_id' => $this->input->post('object_id'),
            'url' => $this->input->post('url'),
            'menu_type' => $this->input->post('menu_type'),
            'parent_id' => 0,
            'sort_order' => 0,
            'newtab' => $this->input->post('newtab') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->MenuModel->add_menu_item($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_item($id) {
        $this->MenuModel->delete_menu_item($id);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
?>