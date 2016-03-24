<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {
    
    public function __construct() {
        $this->set_force_ssl("ON");
        $this->set_auth(TRUE);
        
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

        // active side menu
        $this->data["active_side_menu"] = "cms";
    }
    
    public function index() {
        // breadcrumbs
        $this->position['item'][1]['title'] = "Dashboard";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // load view
        $this->load_view("top", $this->data);
    }
}