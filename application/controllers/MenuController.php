<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuController extends CI_Controller {

    
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
        $this->load->model('Menu_models');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation', 'upload']);
    }

    public function menu_management() {
        $data['menus'] = $this->Menu_model->get_main_menus();
        $data['pages'] = $this->Menu_model->get_all_pages();
        $this->load->view('menu_form', $data);
    }

    public function save() {
        $main_menu_data = array(
            'menu_position' => $this->input->post('menu_position'),
            'name' => $this->input->post('name'),
            'slug' => $this->input->post('slug'),
            'custom_link' => $this->input->post('custom_link'),
            'parent_id' => null
        );

        $main_menu_id = $this->Menu_model->insert_menu($main_menu_data);

        $sub_menus = $this->input->post('sub_menu');

        if (!empty($sub_menus)) {
            foreach ($sub_menus as $submenu) {
                if (!empty($submenu['name'])) {
                    $sub_menu_data = array(
                        'menu_position' => $this->input->post('menu_position'),
                        'name' => $submenu['name'],
                        'slug' => $submenu['slug'],
                        'custom_link' => $submenu['custom_link'],
                        'parent_id' => $main_menu_id
                    );
                    $this->Menu_model->insert_menu($sub_menu_data);
                }
            }
        }

        $this->session->set_flashdata('success', 'Menu saved successfully.');
        redirect('menu');
    }
}
