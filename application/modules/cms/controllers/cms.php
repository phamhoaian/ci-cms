<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {
    
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
        $this->position['item'][0]['title'] = SITE_NAME;
		$this->position['item'][0]['url'] = site_url();

        // active side menu
        $this->data["active_side_menu"] = "cms";
    }
    
    public function index() {

        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // load view
        $this->load_view("top", $this->data);
    }
}