<?php
class MenuModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_menu_items($parent_id = 0) {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }

    public function get_all_menu_items() {
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }

    public function add_menu_item($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('menu_items', $data);
    }

    public function update_menu_item($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('menu_items', $data);
    }

    public function delete_menu_item($id) {
        // First delete all children
        $this->db->where('parent_id', $id);
        $this->db->delete('menu_items');
        
        // Then delete the item itself
        $this->db->where('id', $id);
        return $this->db->delete('menu_items');
    }

    public function save_menu_order($items, $parent_id = 0) {
        $i = 1;
        foreach ($items as $item) {
            $data = array(
                'parent_id' => $parent_id,
                'sort_order' => $i
            );
            $this->db->where('id', $item->id);
            $this->db->update('menu_items', $data);
            
            if (isset($item->children)) {
                $this->save_menu_order($item->children, $item->id);
            }
            $i++;
        }
    }

    public function get_menu_item($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
}
?>