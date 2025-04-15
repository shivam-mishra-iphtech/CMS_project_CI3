<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('load_header_menu')) {
    function load_header_menu()
    {
        $CI =& get_instance();
        $CI->load->model('UserModel');

        $menus = $CI->UserModel->get_menu_with_submenus();

        $output = '';






        if (!empty($menus)) {
            foreach ($menus as $menu) {
                if ($menu->menu_position == 'header') {
                    $menu_url = '';

                    if ($menu->link_type == 'page') {
                        $menu_url = '<a class="nav-link px-3" href="' . site_url('WebController/view_page/' . $menu->url) . '">';
                    } elseif ($menu->link_type == 'post') {
                        $menu_url = '<a class="nav-link px-3" href="' . site_url('WebController/view_post_by_id/' . $menu->url) . '">';
                    } elseif ($menu->link_type == 'post_category') {
                        $menu_url = '<a class="nav-link px-3" href="' . site_url('WebController/view_all_post?category_id=' . $menu->url) . '">';
                    } elseif ($menu->link_type == 'custom') {
                        $url = (preg_match('#^https?://#', $menu->url)) ? $menu->url : 'https://' . $menu->url;
                        $menu_url = '<a class="nav-link px-3" href="' . html_escape($url) . '" target="_blank">';
                    } else {
                        $menu_url = '<span class="nav-link px-3">' . html_escape($menu->menu_name) . '</span>';
                    }

                    if (empty($menu->submenus)) {
                        // Single menu item
                        $output .= '<li class="nav-item">';
                        $output .= $menu_url;
                        $output .= html_escape($menu->menu_name);
                        $output .= '</a></li>';
                    } else {
                        // Menu with submenus
                        $output .= '<li class="nav-item dropdown">';
                        $output .= '<a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">';
                        $output .= html_escape($menu->menu_name);
                        $output .= '</a>';
                        $output .= '<ul class="dropdown-menu">';

                        foreach ($menu->submenus as $submenu) {
                            if (empty($submenu->submenus)) {
                                // Submenu item
                                $submenu_url = '';
                                if ($submenu->link_type == 'page') {
                                    $submenu_url = '<a class="dropdown-item" href="' . site_url('WebController/view_page/' . $submenu->url) . '">';
                                } elseif ($submenu->link_type == 'post') {
                                    $submenu_url = '<a class="dropdown-item" href="' . site_url('WebController/view_post_by_id/' . $submenu->url) . '">';
                                } elseif ($submenu->link_type == 'post_category') {
                                    $submenu_url = '<a class="dropdown-item" href="' . site_url('WebController/view_all_post?category_id=' . $submenu->url) . '">';
                                } elseif ($submenu->link_type == 'custom') {
                                    $url = (preg_match('#^https?://#', $submenu->url)) ? $submenu->url : 'https://' . $submenu->url;
                                    $submenu_url = '<a class="dropdown-item" target="_blank" href="' . html_escape($url) . '">';
                                } else {
                                    $submenu_url = '<span class="dropdown-item">' . html_escape($submenu->menu_name) . '</span>';
                                }

                                $output .= '<li>';
                                $output .= $submenu_url;
                                $output .= html_escape($submenu->menu_name);
                                $output .= '</a></li>';
                            } else {
                                // Submenu with nested submenus
                                $output .= '<li class="dropdown-submenu">';
                                $output .= '<a class="dropdown-item d-flex justify-content-between align-items-center" href="#">';
                                $output .= html_escape($submenu->menu_name);
                                $output .= '<i class="bi bi-chevron-right ms-2"></i></a>';
                                $output .= '<ul class="dropdown-menu">';

                                foreach ($submenu->submenus as $nested_submenu) {
                                    $output .= '<li>';
                                    if ($nested_submenu->link_type == 'custom') {
                                        $url = (preg_match('#^https?://#', $nested_submenu->url)) ? $nested_submenu->url : 'https://' . $nested_submenu->url;
                                        $output .= '<a class="dropdown-item" target="_blank" href="' . html_escape($url) . '">';
                                    } else {
                                        $output .= '<a class="dropdown-item" href="' . site_url($nested_submenu->url) . '">';
                                    }
                                    $output .= html_escape($nested_submenu->menu_name);
                                    $output .= '</a></li>';
                                }

                                $output .= '</ul></li>';
                            }
                        }

                        $output .= '</ul></li>';
                    }
                }
            }
        }

        return $output;


    }
    if (!function_exists('load_footer_menu')) {
        function load_footer_menu() {
            $CI =& get_instance();
            $CI->load->model('UserModel');
    
            // Get all footer menus
            $footer_menus = $CI->UserModel->get_menus_by_position('footer');
    
            // Organize by sections
            $organized_menus = [
                'quick_links' => [],
                'resources' => []
            ];
    
            foreach ($footer_menus as $menu) {
                if (strpos($menu->url, 'registration') !== false || 
                    strpos($menu->url, 'login') !== false ||
                    strpos($menu->url, 'profile') !== false) {
                    $organized_menus['quick_links'][] = $menu;
                } else {
                    $organized_menus['resources'][] = $menu;
                }
            }
    
            $output = '';
    
            // Quick Links Section
            $output .= '<div class="col-md-6 col-lg-2 col-xl-2 mx-auto mb-4">';
            $output .= '<h6 class="text-uppercase fw-bold mb-4">Quick Links</h6>';
    
            if (!empty($organized_menus['quick_links'])) {
                foreach ($organized_menus['quick_links'] as $menu) {
                    $output .= generate_footer_menu_link($menu);
                }
            } else {
                $user_id = $CI->session->userdata('user_id');
                $output .= '<p><a href="'.site_url('WebController/registration').'" class="text-reset footer-link">Register</a></p>';
                $output .= '<p><a href="'.site_url('WebController/login').'" class="text-reset footer-link">Login</a></p>';
                if ($user_id) {
                    $output .= '<p><a href="'.site_url('WebController/user_profile/'.$user_id).'" class="text-reset footer-link">Profile</a></p>';
                }
            }
            
            $output .= '</div>';
    
            // Resources Section
            $output .= '<div class="col-md-6 col-lg-2 col-xl-2 mx-auto mb-4">';
            $output .= '<h6 class="text-uppercase fw-bold mb-4">Resources</h6>';
    
            if (!empty($organized_menus['resources'])) {
                foreach ($organized_menus['resources'] as $menu) {
                    $output .= generate_footer_menu_link($menu);
                }
            } else {
                $output .= '<p><a href="#contact" class="text-reset footer-link">Contact</a></p>';
                $output .= '<p><a href="'.site_url('WebController/view_page').'" class="text-reset footer-link">About Us</a></p>';
                $output .= '<p><a href="#terms" class="text-reset footer-link">Terms & Conditions</a></p>';
                $output .= '<p><a href="#policy" class="text-reset footer-link">Privacy Policy</a></p>';
            }
    
            $output .= '</div>';
    
            return $output;
        }
    }
    
    if (!function_exists('generate_footer_menu_link')) {
        function generate_footer_menu_link($menu) {
            $link = '';
            
            if ($menu->link_type == 'page') {
                $link = '<a href="'.site_url('WebController/view_page/'.$menu->url).'" class="text-reset footer-link">'.htmlspecialchars($menu->menu_name).'</a>';
            } elseif ($menu->link_type == 'post') {
                $link = '<a href="'.site_url('WebController/view_post_by_id/'.$menu->url).'" class="text-reset footer-link">'.htmlspecialchars($menu->menu_name).'</a>';
            } elseif ($menu->link_type == 'post_category') {
                $link = '<a href="'.site_url('WebController/view_all_post?category_id='.$menu->url).'" class="text-reset footer-link">'.htmlspecialchars($menu->menu_name).'</a>';
            } elseif ($menu->link_type == 'custom') {
                $url = (preg_match('#^https?://#', $menu->url)) ? $menu->url : 'https://'.$menu->url;
                $link = '<a href="'.html_escape($url).'" class="text-reset footer-link" target="_blank">'.htmlspecialchars($menu->menu_name).'</a>';
            } else {
                $link = '<a href="'.site_url($menu->url).'" class="text-reset footer-link">'.htmlspecialchars($menu->menu_name).'</a>';
            }
    
            return '<p>'.$link.'</p>';
        }
    }

}