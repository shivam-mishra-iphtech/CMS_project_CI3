<?php 
class FooterLoader
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('AdminModel');

        // Load social media icons and store in a global variable
        $this->CI->footer_data['social_media'] = $this->get_social_icons();
    }

    private function get_social_icons()
    {
        $social_media_list = $this->CI->AdminModel->get_social_media();

        if (!empty($social_media_list)) {
            foreach ($social_media_list as $media) {
                if (!empty($media->social_media_id)) {
                    $this->CI->db->where('id', $media->social_media_id);
                    $query = $this->CI->db->get('social_media_icons');
                    $icon_data = $query->row();

                    if ($icon_data) {
                        $media->media_name = $icon_data->media_name;
                        $media->icon_color = $icon_data->icon_color;
                        $media->icon_class = $icon_data->icon_class;
                        $media->media_icon_id = $icon_data->id;
                    } else {
                        $media->media_name = 'Unknown';
                        $media->icon_color = 'Unknown';
                        $media->icon_class = 'Unknown';
                    }
                }
            }
        }

        return $social_media_list;
    }
}
