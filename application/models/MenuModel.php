<?php
class MenuModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_menu_items($menu_type) {
        $this->db->select('*');
        $this->db->from('menu_items');
        $this->db->where('menu_type', $menu_type);
        $this->db->order_by('parent_id ASC, sort_order ASC');
        return $this->db->get()->result();
    }

    public function get_available_pages() {
        return $this->db->get_where('pages', ['status' => 'published'])->result();
    }

    public function get_available_posts() {
        return $this->db->get_where('posts', ['status' => 'published'])->result();
    }

    public function save_menu_order($items) {
        foreach ($items as $order => $item) {
            $data = [
                'parent_id' => isset($item->parent_id) ? $item->parent_id : 0,
                'sort_order' => $order
            ];
            $this->db->where('id', $item->id);
            $this->db->update('menu_items', $data);
        }
    }

    public function add_menu_item($data) {
        $this->db->insert('menu_items', $data);
        return $this->db->insert_id();
    }

    public function delete_menu_item($id) {
        $this->db->where('id', $id);
        $this->db->delete('menu_items');
    }

    public function get_menu_item($id) {
        return $this->db->get_where('menu_items', ['id' => $id])->row();
    }
}
?>