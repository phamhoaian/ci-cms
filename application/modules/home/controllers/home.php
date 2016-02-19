<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // connect to database
        $this->load->database();
        
        // load model
        $this->load->model('common_model');
        
        // config meta data
        $this->data["title"] = "Effect";
		$this->data['description'] = "Effect, HTML5 & CSS3 template";
        
        // breadcrumbs
        $this->position['item'][0]['title'] = SITE_NAME;
		$this->position['item'][0]['url'] = site_url();
    }
    
    public function index() {
        
        // load view
        $this->load_view("home", $this->data);
    }
}