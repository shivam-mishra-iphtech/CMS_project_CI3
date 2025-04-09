<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MediaFileController extends CI_Controller
{

    public $db; // 🔹 Declare db property to avoid dynamic property issue
    public $session;
    public $form_validation;
    public $UserModel;
    public $AdminModel;
    public $upload;
    public $pagination;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db = $this->load->database();
        $this->load->model('UserModel');
        $this->load->model('AdminModel');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation', 'upload']);
    }
    public function manage_media_files()
    {
        // Load pagination library
        $this->load->library('pagination');
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item text-dark active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = ['class' => 'page-link'];


        // Pagination config
        $config['base_url'] = site_url('MediaFileController/manage_media_files');
        $config['total_rows'] = $this->AdminModel->count_all_media_files(); // total number of files
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        // Get current page from URL
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // Fetch media files for current page
        $data['media_files'] = $this->AdminModel->get_media_files_paginated($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('admin/media_files', $data);
    }

    public function save_media_files()
{
    $this->form_validation->set_rules('user_id', 'User ID', 'required');
    $this->form_validation->set_rules('file_name', 'File Name', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => validation_errors()
        ]);
        return;
    }

    $upload_path = BASEPATH . '../public/mediaFiles/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $uploaded_files = [];
    $errors = [];

    if (!empty($_FILES['media_file']['name'][0])) {
        $files_count = count($_FILES['media_file']['name']);
        
        for ($i = 0; $i < $files_count; $i++) {
            if ($_FILES['media_file']['error'][$i] == 0) {
                $file_ext = pathinfo($_FILES['media_file']['name'][$i], PATHINFO_EXTENSION);
                $file_name = time() . '_' . uniqid() . '.' . $file_ext;

                $_FILES['file']['name'] = $_FILES['media_file']['name'][$i];
                $_FILES['file']['type'] = $_FILES['media_file']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['media_file']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['media_file']['error'][$i];
                $_FILES['file']['size'] = $_FILES['media_file']['size'][$i];

                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['max_size'] = 8048; // 8MB
                $config['file_name'] = $file_name;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $file_data = $this->upload->data();

                    $file_type = strtolower($file_ext);
                    if ($file_type == 'gif') {
                        $media_type = 'gif';
                    } elseif (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                        $media_type = 'image';
                    } elseif ($file_type == 'pdf') {
                        $media_type = 'pdf';
                    } else {
                        $media_type = 'other';
                    }

                    // $file_size = round($file_data['file_size'] / 1024, 2) . ' KB';

                    $file_info = [
                        'user_id'          => $this->input->post('user_id', TRUE),
                        'media_file_name'  => $this->input->post('file_name', TRUE) . ' (' . ($i + 1) . ')',
                        'original_name'    => $_FILES['media_file']['name'][$i],
                        'media_file'       => $file_name,
                        'media_file_type'  => $media_type,
                        'file_size'        => $_FILES['file']['size'],
                        'upload_date'      => date('Y-m-d H:i:s'),
                        'status'           => 1
                    ];

                    $uploaded_files[] = $file_info;
                } else {
                    $errors[] = 'File ' . $_FILES['media_file']['name'][$i] . ': ' . $this->upload->display_errors('', '');
                }
            }
        }
    }

    if (!empty($uploaded_files)) {
        $success_count = 0;
        foreach ($uploaded_files as $file) {
            $result = $this->AdminModel->add_media_file($file);
            if ($result) {
                $success_count++;
            }
        }

        $response = [
            'status' => true,
            'message' => $success_count . ' file(s) uploaded successfully.',
            'errors' => $errors
        ];
    } else {
        $response = [
            'status' => false,
            'message' => 'No valid files were uploaded.',
            'errors' => $errors
        ];
    }

    echo json_encode($response);
}



    public function edit_media_file()
    {
        $file_id = $this->input->post('file_id');

        $file_name = $this->input->post('file_name');

        if (!empty($file_id)) {
            $this->db->where('id', $file_id);
            $this->db->update('media_filess', ['media_file_name' => $file_name]);

            $this->session->set_flashdata('success', 'Media file updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to Update Media. Please try again.');
        }
        redirect('MediaFileController/manage_media_files');
    }
   


    public function delete_media_file()
    {   $id = $this->input->post('file_id');
        $existing_media = !empty($id) ? $this->AdminModel->get_media_file_id($id) : null;
        $upload_path = BASEPATH . '../public/mediaFiles/';
        if (!empty($existing_media->media_file) && file_exists($upload_path . $existing_media->media_file)) {
            unlink($upload_path . $existing_media->media_file);
        }
        if ($this->AdminModel->delete_media_file($id)) {
            $this->session->set_flashdata('success', 'Media file deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete Media. Please try again.');
        }
        redirect('MediaFileController/manage_media_files');
    }

}