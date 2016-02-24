<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends MY_Controller {

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

        // the number of item per page
        $this->limit = 10;
	}

	public function index() {
		// breadcrumbs
        $this->position['item'][2]['title'] = "Search";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // active side menu
        $this->data["active_sub_menu"] = "blog_items";

		// load view
        $this->load_view("blog/search", $this->data);
	}

	public function edit() {
		// blog id
		$this->data["blog_id"] = $this->security_clean($this->uri->segment(4, ""));

		// breadcrumbs
        $this->position['item'][2]['title'] = "Edit";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // active side menu
        $this->data["active_sub_menu"] = "blog_edit";
        
        // load view
        $this->load_view("blog/edit", $this->data);
	}
}