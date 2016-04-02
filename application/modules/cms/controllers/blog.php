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
        
        $this->temp_img_dir = "images/temp";
		$this->out_img_dir = "images/blog/items";
	}

	public function index() {
		$jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
	}
    
    public function search() {
    	// load css and js
    	$this->set_css("green.css");
    	$this->set_js("icheck.min.js");
    	
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // active side menu
        $this->data["active_sub_menu"] = "blog_items";
        
        // limit
        $this->data["limit"] = $this->input->post('limit');
        if ($this->data["limit"] == "") {
        	$this->data["limit"] = $this->limit;
        }
        if ($this->data["limit"] == 0) {
        	$this->data["limit"] = NULL;
        }
        
        // keyword
        $key = $this->security_clean($this->uri->segment(5));
        if ($this->input->post('search')) {
        	$key = $this->security_clean($this->input->post('search'));
        }
        if ($key === "-") {
        	$key = "";
        }
        $key = trim($key);
        $like = key2like($key);
        
        // offset
        $offset = (int) $this->uri->segment(6, 0);
        
        // status
        $this->data["status"] = $this->security_clean($this->uri->segment(4));
        if (!$this->data["status"]) {
            $this->data["status"] = $this->input->post('status');
        }
        if (!$this->data["status"]) {
            $this->data["status"] = "active";
        }
        $where = array();
        if ($this->data["status"] == "active") {
        	$where["blog_items.delete_flag"] = 0;
        } else {
        	$where["blog_items.delete_flag"] = 1;
        }
        
        // list items
        $this->common_model->set_table("blog_items");
        $this->db->select("blog_items.*, blog_categories.name as cat_name");
        $this->db->join("blog_categories", "blog_items.cat_id = blog_categories.id", "inner");
        $this->data["items"] = $this->common_model->like($where, array("title" => $like), "published_date DESC, created DESC", $this->data["limit"], $offset);
        $this->data["count_items"] = $this->common_model->get_count($where, array("title" => $like));
        
        // generate pagination
        $this->data["key"] = "-";
        $this->data["key_disp"] = "";
        if ($key) {
        	$this->data["key"] = rawurlencode($key);
        	$this->data["key_disp"] = $key;
        }
        $path = "cms/blog/search/".$this->data["status"]."/".$this->data["key"];
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_items"], $this->data["limit"], 6);

		// load view
        $this->load_view("blog/items", $this->data);
    }

	public function edit() {
        // load css and js
        $this->set_css("switchery.min.css");
        $this->set_css("select2.min.css");
        $this->set_css("bootstrap-datetimepicker.min.css");
        $this->set_css("dropzone.css");
        $this->set_js("switchery.min.js");
        $this->set_js("select2.full.js");
        $this->set_js("jquery.tagsinput.min.js");
        $this->set_js("moment.min.js");
        $this->set_js("bootstrap-datetimepicker.min.js");
        $this->set_js("tinymce.min.js");
        
		// blog item id
		$this->data["item_id"] = $this->security_clean($this->uri->segment(4, 0));

		// breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        
        // active side menu
        $this->data["active_sub_menu"] = "blog_items";

        if ($this->data["item_id"]) {
            // check item exists or not
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }
            $this->data["item"]["created"] = date('d-m-Y H:i:s', strtotime($this->data["item"]["created"]));
            $this->data["item"]["published_date"] = date('d-m-Y H:i:s', strtotime($this->data["item"]["published_date"]));
            $this->data["item"]["content"] = $this->data["item"]["introtext"];
            if ($this->data["item"]["fulltext"] != "") {
                $this->data["item"]["content"] = $this->data["item"]["introtext"] . '<hr id="readmore" />' . $this->data["item"]["fulltext"];
            }
            
            // breadcrumbs
            $this->position['item'][3]['title'] = "Edit";
            $this->data["page_title"] = "Edit Item";
        } else {
            // breadcrumbs
            $this->position['item'][3]['title'] = "New";
            $this->data["page_title"] = "Add New Item";
            
            $this->data["item"] = array(
                "cat_id" => "",
                "title" => "",
                "alias" => "",
                "introtext" => "",
                "fulltext" => "",
                "content" => "",
                "created" => date('d-m-Y H:i:s', time()),
                "created_by" => "",
                "modified" => "",
                "image" => "",
                "hits" => "",
                "metadesc" => "",
                "metadata" => "",
                "metakey" => "",
                "published" => 1,
                "published_date" => date('d-m-Y H:i:s', time()),
                "featured" => ""
            );
        }
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // list categories
        $this->data["list_categories"] = "";
        $this->common_model->set_table("blog_categories");
        $where = array();
        $where["delete_flag"] = 0;
        $categories = $this->common_model->get_all($where, "parent ASC");
        if ($categories) {
            $categories_tree = $this->_prepareList($categories, $categories[0]["parent"]);
        } else {
            $categories_tree = array();
        }
        $this->data["list_categories"] = array_slice($this->_array_flatten($categories_tree, 1, "form"), 0);
        
        // form validation
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div style="clear:both;"></div><div class="alert alert-danger">', '</div>');
        
        $this->form_validation->set_rules("title", "title", "required|trim|xss_clean");
        $this->form_validation->set_rules("alias", "title alias", "trim|xss_clean");
        $this->form_validation->set_rules("category", "category", "required|trim|xss_clean");
        $this->form_validation->set_rules("tags", "tags", "trim|xss_clean");
        $this->form_validation->set_rules("featured", "featured", "trim|xss_clean|max_lenght[1]|integer");
        $this->form_validation->set_rules("published", "published", "trim|xss_clean|max_lenght[1]|integer");
        $this->form_validation->set_rules("content", "content", "trim|xss_clean");
        $this->form_validation->set_rules("image", "image", "trim|xss_clean");
        $this->form_validation->set_rules("author", "author", "trim|xss_clean");
        $this->form_validation->set_rules("created", "creation date", "trim|xss_clean");
        $this->form_validation->set_rules("published_date", "published_date", "trim|xss_clean");
        $this->form_validation->set_rules("metadesc", "metadesc", "trim|xss_clean");
        $this->form_validation->set_rules("metakey", "metakey", "trim|xss_clean");
        
        if ($this->form_validation->run()) {
            
            
            // prepare data
            $upd_data = array(
                "title" => $this->security_clean(set_value("title")),
                "cat_id" => $this->security_clean(set_value("category")),
                "featured" => $this->security_clean(set_value("featured")),
                "published" => $this->security_clean(set_value("published")),
                "created_by" => $this->security_clean(set_value("author")),
                "created" => date('Y-m-d H:i:s', strtotime($this->security_clean(set_value("created")))),
                "published_date" => date('Y-m-d H:i:s', strtotime($this->security_clean(set_value("published_date")))),
                "metadesc" => $this->security_clean(set_value("metadesc")),
                "metakey" => $this->security_clean(set_value("metakey"))
            );
            
            // content
            $content = $this->security_clean(set_value("content"));
            $content = str_replace(array("\r", "\n"), "", $content);
            $introtext = $this->_getIntroText($content, 'readmore');
            $fulltext = $this->_getFullText($content, 'readmore');
            $upd_data["introtext"] = htmlspecialchars_decode($introtext);
            $upd_data["fulltext"] = htmlspecialchars_decode($fulltext);
            
            // generate title to alias
            $alias =  $this->security_clean(set_value("alias"));
            if ($alias != "") {
                $upd_data["alias"] = title2alias($alias);
            } else {
                $upd_data["alias"] = title2alias($this->security_clean(set_value("title")));
            }
            
            $message = "";
            $this->common_model->set_table("blog_items");
            if ($this->data["item_id"]) {
                $upd_data["modified"] = date('Y-m-d H:i:s', time());
                $this->common_model->update($upd_data, array("id" => $this->data["item_id"]));
                $message = "Update item successfully!";
            } else {
                $this->data["item_id"] = $this->common_model->insert($upd_data);
                $message = "Add new item successfully!";
            }
            
            // upload image
            $image = $this->input->post("item_image");
            if (!empty($_FILES['image']['name'])) {
                $image = $this->_upload("image");
            }
            $upd_data = array(
                "image" => $image
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            $this->session->set_flashdata("message", $message);
            redirect("cms/blog/search");
        }
        
        // load view
        $this->load_view("blog/item", $this->data);
	}
    
    public function featured() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Featured";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group items id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "featured" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} items changed!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "featured" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item changed!");
        }
        $jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
    }
    
    public function unfeatured() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Item";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Unfeatured";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "featured" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} items changed!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "featured" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item changed!");
        }
        
        $jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
    }
    
    public function publish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Publish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} item published!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item published!");
        }
        $jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
    }
    
    public function unpublish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Unpublish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} items unpublished!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item unpublished!");
        }
        
        $jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
    }
    
    public function trash() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Item";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Trash";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} items moved to trash");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item move to trash!");
        }
        
        $jump_url = site_url("cms/blog/search");
        header("Location: $jump_url");
    }
    
    public function restore() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Restore";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_all(array("id IN({$id})" => NULL, "delete_flag" => 1));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }
            
            $upd_data = array(
                "delete_flag" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} items restored!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }

            $upd_data = array(
                "delete_flag" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item restored!");
        }
        $jump_url = site_url("cms/blog/search/trash");
        header("Location: $jump_url");
    }
    
    public function delete() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Items";
        $this->position['item'][2]['url'] = site_url("cms/blog");
        $this->position['item'][3]['title'] = "Delete";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group item id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_all(array("id IN({$id})" => NULL, "delete_flag" => 1));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }
            
            $this->common_model->delete(array("id IN({$id})" => NULL));

            // flash message
            $this->session->set_flashdata("message", "There are {$count} items deleted!");
        } else {
            // blog item id
            $this->data["item_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["item_id"] || !is_numeric($this->data["item_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog/search");
            }

            $this->common_model->set_table("blog_items");
            $this->data["item"] = $this->common_model->get_row(array("id" => $this->data["item_id"]));
            if (!$this->data["item"]) {
                $this->session->set_flashdata("error", "The item not exist!");
                redirect("cms/blog/search");
            }
            
            $this->common_model->delete(array('id' => $this->data["item_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Item deleted!");
        }
        $jump_url = site_url("cms/blog/search/trash");
        header("Location: $jump_url");
    }
    
    public function photo_del() {
        $id = $this->security_clean($this->uri->segment(4, 0));
        if (!$id) {
            $this->session->set_flashdata("error", "The item not exist!");
            redirect("cms/blog/search");
        }
        
        $this->common_model->set_table("blog_items");
        $item = $this->common_model->get_row(array("id" => $id));
        if (!$item) {
            $this->session->set_flashdata("error", "The item not exist!");
            redirect("cms/blog/search");
        }
        
        $file_dir = FCPATH.$this->out_img_dir."/";
        $file100 = $file_dir.$id."_100.".$item["image"];
		$file300 = $file_dir.$id."_300.".$item["image"];
        
        if (file_exists($file100) && file_exists($file300)) {
            unlink($file100);
            unlink($file300);
        }
        $upd_data = array(
            "image" => ''
        );
        $this->common_model->update($upd_data, array("id" => $id));
        
        $this->session->set_flashdata("message", "Delete item image completely!");
        redirect("cms/blog/edit/".$id);
    }
    
    private function _upload($filename = '') {
        
        $this->load->library('upload');
		$this->load->library('CIframe_image_lib');
		
		$file_dir = FCPATH.$this->out_img_dir."/";
		
		// config
        $config = array();
        $config['upload_path'] = "$file_dir";
        $config['allowed_types'] = "gif|jpg|jpeg|png";
        $config['overwrite'] = TRUE;
        $config["max_size"] = "5000";
        $this->upload->initialize($config);

        if (!$this->upload->do_upload("$filename")) {
            $this->session->set_flashdata("error", $this->upload->display_errors());
            return FALSE;
        } else {
            $data = $this->upload->data();
            
            $this->ciframe_image_lib->convert_image_uploaded($data, 300, $file_dir, $this->data["item_id"]."_300", FALSE);
            $this->ciframe_image_lib->convert_image_uploaded($data, 100, $file_dir, $this->data["item_id"]."_100",  TRUE);

            return substr($data["file_ext"], strpos($data["file_ext"], ".") + 1);
        }
    }
}