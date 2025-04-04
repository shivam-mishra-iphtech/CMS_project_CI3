<?php
if (!function_exists('build_menu_tree')) {
    function build_menu_tree($menu_items, $parent_id = 0) {
        $html = '';
        
        foreach ($menu_items as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $html .= '<li id="menuItem_' . $item->id . '">';
                $html .= '<div>' . $item->title;
                $html .= '<div class="pull-right">
                            <a href="' . site_url('menu/delete_item/' . $item->id) . '" class="btn btn-xs btn-danger">Delete</a>
                          </div>';
                $html .= '</div>';
                
                $html .= '<ol>';
                $html .= build_menu_tree($menu_items, $item->id);
                $html .= '</ol>';
                $html .= '</li>';
            }
        }
        
        return $html;
    }
}
?>