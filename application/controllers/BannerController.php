<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BannerController extends CI_Controller
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
    public function manage_banners()
    {
        $data['banners'] = $this->AdminModel->get_banner();
        $this->load->view('admin/banners', $data);
    }
    public function save_banner()
{
    $this->form_validation->set_rules('user_id', 'User ID', 'required');
    $this->form_validation->set_rules('banner_type', 'Banner Type', 'required|trim');
    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('desc', 'Description', 'trim');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('BannerController/manage_banners');
        return;
    }

    $banner_id = $this->input->post('id');

    // Fetch existing banner (for image delete during update)
    $existing_banner = !empty($banner_id) ? $this->AdminModel->get_banner_by_id($banner_id) : null;

    // File upload config
    $upload_path = BASEPATH . '../public/WebBannersImage/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = time() . '_' . uniqid() . '.' . $file_ext;

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 5048;
        $config['file_name'] = $image;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('BannerController/manage_banners');
            return;
        }

        // Delete old image if updating
        if (!empty($existing_banner->image) && file_exists($upload_path . $existing_banner->image)) {
            unlink($upload_path . $existing_banner->image);
        }
    }

    $data = [
        'user_id'     => $this->input->post('user_id', TRUE),
        'banner_type' => $this->input->post('banner_type', TRUE),
        'title'       => $this->input->post('title', TRUE),
        'desc'        => $this->input->post('desc', TRUE),
    ];

    if (!empty($image)) {
        $data['image'] = $image;
    }

    if (!empty($banner_id)) {
        // Update banner
        $result = $this->AdminModel->update_banner($banner_id, $data);
        $message = $result ? 'Banner updated successfully.' : 'Error updating banner.';
    } else {
        // Insert banner
        $result = $this->AdminModel->add_banner($data);
        $message = $result ? 'New banner added successfully.' : 'Error adding new banner.';
    }

    $this->session->set_flashdata($result ? 'success' : 'error', $message);
    redirect('BannerController/manage_banners');
}

public function update_banner_status()
    {
        $post_id = $this->input->post('banner_id');

        $status = $this->input->post('status');

        if (!empty($post_id)) {
            $this->db->where('id', $post_id);
            $this->db->update('banner', ['status' => $status]);

            echo json_encode(["status" => "success", "message" => "Banner status updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Banner ID!"]);
        }
    }
    public function delete_banner($id)
    {
        $existing_banner = !empty($id) ? $this->AdminModel->get_banner_by_id($id) : null;
        $upload_path = BASEPATH . '../public/WebBannersImage/';
        if (!empty($existing_banner->image) && file_exists($upload_path . $existing_banner->image)) {
            unlink($upload_path . $existing_banner->image);
        }
        if ($this->AdminModel->delete_banner($id)) {
            $this->session->set_flashdata('success', 'Banner deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete Banner. Please try again.');
        }
        redirect('BannerController/manage_banners');
    }

}