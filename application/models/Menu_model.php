<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all menu items with optional parent_id filter
    public function get_menu_items($parent_id = null) {
        $this->db->select('*');
        $this->db->from('menu_items');
        $this->db->where('is_active', 1);
        
        if ($parent_id !== null) {
            $this->db->where('parent_id', $parent_id);
        } else {
            $this->db->where('parent_id', 0);
        }
        
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get menu item by ID
    public function get_menu_item($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }

    // Save menu item
    public function save_menu($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('menu_items', $data);
            return $data['id'];
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('menu_items', $data);
            return $this->db->insert_id();
        }
    }

    // Delete menu item
    public function delete_menu($id) {
        // First check if this menu has submenus
        $this->db->where('parent_id', $id);
        $has_children = $this->db->count_all_results('menu_items') > 0;
        
        if ($has_children) {
            return ['success' => false, 'message' => 'Cannot delete menu with sub-items'];
        }
        
        $this->db->where('id', $id);
        $this->db->delete('menu_items');
        return ['success' => true, 'message' => 'Menu deleted successfully'];
    }

    // Get all active pages for menu linking
    public function get_active_pages() {
        $this->db->select('id, page_title as title, slug');
        $this->db->where('status', 1);
        $query = $this->db->get('pages');
        return $query->result();
    }

    // Get all active posts for menu linking
    public function get_active_posts() {
        $this->db->select('id, post_title as title, slug');
        $this->db->where('status', 1);
        $query = $this->db->get('posts');
        return $query->result();
    }

    // Get all active post categories for menu linking
    public function get_active_categories() {
        $this->db->select('id, category_name as title');
        $this->db->where('status', 1);
        $query = $this->db->get('post_category');
        return $query->result();
    }

    // Reorder menu items
    public function reorder_menu($items) {
        foreach ($items as $position => $item) {
            $this->db->where('id', $item);
            $this->db->update('menu_items', ['sort_order' => $position]);
        }
        return true;
    }
    public function insert_menu($data)
{
    $this->db->insert('menu_items
    ', $data);
    return $this->db->insert_id();
}

public function update_menu($id, $data)
{
    $this->db->where('id', $id)->update('menus', $data);
}

public function insert_submenu($data)
{
    $this->db->insert('submenus', $data);
}

public function delete_submenus($menu_id)
{
    $this->db->where('id', $menu_id)->delete('menu_items');
}

}