<?php
// application/helpers/menu_helper.php
if (!function_exists('render_menu')) {
    function render_menu($location) {
        $CI =& get_instance();
        $CI->load->model('menu_model');
        
        // Get menu by location
        $menu = $CI->db->get_where('menus', array('location' => $location))->row();
        
        if (!$menu) return '';
        
        // Get menu items
        $items = $CI->menu_model->get_menu_items($menu->id);
        
        return _render_menu_items($items);
    }
}

if (!function_exists('_render_menu_items')) {
    function _render_menu_items($items, $level = 0) {
        $output = '';
        
        if ($level == 0) {
            $output .= '<ul class="nav navbar-nav">';
        } else {
            $output .= '<ul class="dropdown-menu">';
        }
        
        foreach ($items as $item) {
            $has_children = !empty($item->children);
            $output .= '<li' . ($has_children ? ' class="dropdown"' : '') . '>';
            
            // Determine URL
            if ($item->custom_url) {
                $url = $item->custom_url;
            } elseif ($item->page_id) {
                $url = site_url('page/' . $CI->db->get_where('pages', array('id' => $item->page_id))->row();
            } else {
                $url = '#';
            }
            
            $output .= '<a href="' . $url . '"' . ($has_children ? ' class="dropdown-toggle" data-toggle="dropdown"' : '') . '>';
            $output .= $item->title;
            if ($has_children && $level == 0) {
                $output .= ' <span class="caret"></span>';
            }
            $output .= '</a>';
            
            if ($has_children) {
                $output .= _render_menu_items($item->children, $level + 1);
            }
            
            $output .= '</li>';
        }
        
        $output .= '</ul>';
        
        return $output;
    }
}
?>