<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all menu items with optional parent_id filter
    
    
    public function get_menu_with_submenus() {
        // Get all parent menus
        $this->db->where('parent_id', 0);
        $this->db->order_by('sort_order', 'ASC');
        $menus = $this->db->get('menu_items')->result();
        
        // Get submenus for each menu
        foreach ($menus as $menu) {
            $this->db->where('parent_id', $menu->id);
            $this->db->order_by('sort_order', 'ASC');
            $menu->submenus = $this->db->get('menu_items')->result();
        }
        
        return $menus;
    }
    
    public function get_submenus($parent_id) {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('menu_items')->result();
    }
    
    public function get_active_pages() {
        $this->db->where('status', '1');
        $this->db->order_by('page_title', 'ASC');
        return $this->db->get('pages')->result();
    }
    
    public function get_active_posts() {
        $this->db->where('status', '1');
        $this->db->order_by('post_title', 'ASC');
        return $this->db->get('posts')->result();
    }
    
    public function get_active_categories() {
        $this->db->where('status', '1');
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get('post_category')->result();
    }
    
    public function create_menu($data) {
        $this->db->insert('menu_items', $data);
        return $this->db->insert_id();
    }
    
    public function update_menu($data) {
        $this->db->where('id', $data['id']);
        return $this->db->update('menu_items', $data);
    }
    
    public function delete_menu($id) {
        $this->db->where('id', $id);
        return $this->db->delete('menu_items');
    }
    
    public function delete_submenus($parent_id) {
        $this->db->where('parent_id', $parent_id);
        return $this->db->delete('menu_items');
    }

}