<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // connect to database
        $this->load->database();
        
        // load model
        $this->load->model('common_model');
        
        // load library
        $this->load->library('session');
        
        // config meta data
        $this->data["title"] = "Effect";
		$this->data['description'] = "Effect, HTML5 & CSS3 template";
        
        // breadcrumbs
        $this->position['item'][0]['title'] = "Home";
		$this->position['item'][0]['url'] = site_url();

        // active side menu
        $this->data["active_side_menu"] = "blog";

        // the number of item per page
        $this->limit = 3;
        $this->limit_recent_posts = 3;
        $this->limit_most_view = 3;
        
        $this->temp_img_dir = "images/temp";
		$this->out_img_dir = "images/blog/items";
    }
    
    public function index() {
        // breadcrumbs
        $this->position['item'][1]['title'] = "Blog";
        $this->position['item'][1]['url']= "";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // offset
        $offset = (int) $this->uri->segment(3, 0);
        
        // list items
        $this->common_model->set_table("blog_items");
        $this->db->select("blog_items.*, blog_categories.name as cat_name");
        $this->db->join("blog_categories", "blog_items.cat_id = blog_categories.id", "inner");
        $where = array(
            "blog_items.delete_flag" => 0,
            "blog_items.published" => 1
        );
        $this->data["items"] = $this->common_model->get_all($where, "published_date DESC", $this->limit, $offset);
        $this->data["count_items"] = $this->common_model->get_count($where);
        
        $path = "blog/index";
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_items"], $this->limit, 3);
        
        // recent posts
        $this->common_model->set_table("blog_items");
        $where = array(
            "blog_items.delete_flag" => 0,
            "blog_items.published" => 1
        );
        $this->data["recent_posts"] = $this->common_model->get_all($where, "published_date DESC", $this->limit_recent_posts);
        
        // most view
        $this->common_model->set_table("blog_items");
        $where = array(
            "blog_items.delete_flag" => 0,
            "blog_items.published" => 1
        );
        $this->data["most_view"] = $this->common_model->get_all($where, "hits DESC", $this->limit_most_view);
        
        // load view
        $this->load_view("list", $this->data);
    }
}