<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_categories extends MY_Controller {

	public function __construct() {
		parent::__construct();

		// connect to database
        $this->load->database();
        
        // load model
        $this->load->model('common_model');
        
        // config meta data
        $this->data["title"] = "Administrator";
		$this->data['description'] = "Administrator - Effect, HTML5 & CSS3 template";
        
        // breadcrumbs
        $this->position['item'][0]['title'] = "Home";
		$this->position['item'][0]['url'] = site_url("cms");
		$this->position['item'][1]['title'] = "Blog";
		$this->position['item'][1]['url'] = site_url("cms/blog");

        // active side menu
        $this->data["active_side_menu"] = "blog";
        $this->data["active_sub_menu"] = "blog_categories";

        // the number of item per page
        $this->limit = 10;
	}

	public function index() {
		// breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

		// load view
        $this->load_view("blog/categories", $this->data);
	}

	public function edit() {
		// blog category id
		$this->data["category_id"] = $this->security_clean($this->uri->segment(4, ""));
        if (isset($this->data["category"]) && !is_numeric($this->data["category_id"])) {
            define('RETURN_URL', site_url("cms/blog/categories"));
            $this->message("Illegal operation has occurred", $this->data);
        }
        
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog/categories");
        
        // check category exists or not
        $this->common_model->set_table("blog_categories");
        $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
        if ($this->data["category"]) {
            $this->position['item'][3]['title'] = "Edit";
        } else {
            $this->position['item'][3]['title'] = "New";
        }
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // load view
        $this->load_view("blog/category", $this->data);
	}
}