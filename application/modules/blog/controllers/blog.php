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
        $this->limit_tags = 10;
        
        $this->temp_img_dir = "images/temp";
		$this->out_img_dir = "images/blog/items";
		
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
        
        // list tags
        $this->common_model->set_table("blog_tags");
       $this->data["list_tags"] = $this->common_model->get_all(array("published" => 1), "id DESC", $this->limit_tags);
       foreach ($this->data["list_tags"] as &$tag) {
           $this->common_model->set_table("blog_tags_xref");
           $tag["count"] = $this->common_model->get_count(array("tagID" => $tag["id"]));
           if (!$tag["count"]) {
               unset($tag);
           }
       }
    }
    
    public function index($offset = 0) {
        // breadcrumbs
        $this->position['item'][1]['title'] = "Blog";
        $this->position['item'][1]['url']= "";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // list items
        $this->common_model->set_table("blog_items");
        $this->db->select("blog_items.*, blog_categories.alias as cat_alias");
        $this->db->join("blog_categories", "blog_items.cat_id = blog_categories.id", "inner");
        $where = array(
            "blog_items.delete_flag" => 0,
            "blog_items.published" => 1
        );
        $this->data["items"] = $this->common_model->get_all($where, "published_date DESC", $this->limit, $offset);
        $this->data["count_items"] = $this->common_model->get_count($where);
        
        $path = "blog";
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_items"], $this->limit, 2);
        
        // load view
        $this->load_view("list", $this->data);
    }
    
    public function category($alias = '', $offset = 0) {
        
        // category
        $this->common_model->set_table("blog_categories");
        $this->data["category"] = $this->common_model->get_all(array("alias" => $alias), 'id DESC', 1);
        if (!$this->data["category"]) {
            redirect(site_url("blog"));
        }
        
        // breadcrumbs
        $this->position['item'][1]['title'] = "Blog";
        $this->position['item'][1]['url']= site_url("blog");
        $this->position['item'][2]['title'] = $this->data["category"][0]["name"];
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // child categories id
        $child_cat = $this->_listChildCategory($this->data["category"][0]["id"]);
        $child_cat = $this->_array_flatten($child_cat);
        
        // merge categories
        $categories = array_merge($this->data["category"], $child_cat);
        $categories = implode(",", array_column($categories, "id"));
        
        // list items
        $this->common_model->set_table("blog_items");
        $this->db->select("blog_items.*, blog_categories.alias as cat_alias");
        $this->db->join("blog_categories", "blog_items.cat_id = blog_categories.id", "inner");
        $where = array(
            "blog_items.delete_flag" => 0,
            "blog_items.published" => 1,
            "blog_items.cat_id IN ({$categories})" => NULL
        );
        $this->data["items"] = $this->common_model->get_all($where, "published_date DESC", $this->limit, $offset);
        $this->data["count_items"] = $this->common_model->get_count($where);
        
        $path = "blog/".$alias;
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_items"], $this->limit, 3);
        
        // load view
        $this->load_view("list", $this->data);
    }
    
    public function tag($tag_id = '', $offset = 0) {
        
    }
    
    public function item($alias = '', $id = '') {
        
        // item
        $this->common_model->set_table("blog_items");
        $this->data["item"] = $this->common_model->get_row(array("id" => $id));
        if (!$this->data["item"]) {
            redirect(site_url("blog"));
        }
        
        // item's category
        $this->common_model->set_table("blog_categories");
        $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["item"]["cat_id"]));
        if (!$this->data["category"]) {
            redirect(site_url("blog"));
        }
        
        // breadcrumbs
        $this->position['item'][1]['title'] = "Blog";
        $this->position['item'][1]['url']= site_url("blog");
        $this->position['item'][2]['title'] = $this->data["category"]["name"];
        $this->position['item'][2]['url']= site_url("blog/".$this->data["category"]["alias"]);
        $this->position['item'][3]['title'] = $this->data["item"]["title"];
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        
        // load view
        $this->load_view("detail", $this->data);
    }
    
    private function _listChildCategory($cat_id = 0) {
        $result = array();
        $this->common_model->set_table("blog_categories");
        $child = $this->common_model->get_all(array("delete_flag" => 0, "parent" => $cat_id));
        if ($child) {
            foreach ($child as $item) {
                if ($val = $this->_listChildCategory($item["id"])) {
                    $item["children"] = $val;
                }
                $result[] = $item;
            }
        }
    
        return $result;
    }
}