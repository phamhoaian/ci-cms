<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_categories extends MY_Controller {

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
        $this->data["active_sub_menu"] = "blog_categories";

        $this->out_img_dir = "images/blog/categories";

        // the number of item per page
        $this->limit = 10;
	}
    
    public function index() {
        $jump_url = site_url("cms/blog_categories/search");
        header("Location: $jump_url");
    }

	public function search() {
        // load css and js 
        $this->set_css("green.css");
        $this->set_js("icheck.min.js");
        
        // offset
        $offset = (int) $this->uri->segment(4, 0);
        
        // limit
        $this->data["limit"] = $this->input->post('limit');
        if ($this->data["limit"] == "") {
            $this->data["limit"] = 10;
        }
        if ($this->data["limit"] == 0) {
            $this->data["limit"] = NULL;
        }
        
		// breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // list categories
        $this->common_model->set_table("blog_categories");
        $categories = $this->common_model->get_all(array("delete_flag" => 0), "parent ASC");
        $categories_tree = $this->_prepareList($categories, $categories[0]["parent"]);
        $this->data["categories"] = array_slice($this->_array_flatten($categories_tree), $offset, $this->data["limit"]);
        $this->data["count_categories"] = $this->common_model->get_count(array("delete_flag" => 0));
        
        // generate pagination
        $path = "cms/blog_categories/search/";
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_categories"], $this->data["limit"], 4);

		// load view
        $this->load_view("blog/categories", $this->data);
	}

	public function edit() {
        // load css and js
        $this->set_css("switchery.min.css");
        $this->set_css("select2.min.css");
        $this->set_js("switchery.min.js");
        $this->set_js("select2.full.js");

		// blog category id
		$this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
        
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        
        if ($this->data["category_id"]) {
            // check category exists or not
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }
            $this->data["image_from_category"] = $this->data["category"]["image"];

            // breadcrumbs
            $this->position['item'][3]['title'] = "Edit";
            $this->data["page_title"] = "Edit Category";
        } else {
            // breadcrumbs
            $this->position['item'][3]['title'] = "New";
            $this->data["page_title"] = "Add New Category";
            $this->data["image_from_category"] = "";

            $this->data["category"] = array(
                "name" => "",
                "alias" => "",
                "description" => "",
                "parent" => "",
                "published" => "1",
                "image" => ""
            );
        }
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // list categories
        $this->data["list_categories"] = "";
        $this->common_model->set_table("blog_categories");
        $where = array();
        if ($this->data["category_id"] && $this->data["category"]) {
            $where["id !="] = $this->data["category_id"];
        }
        $this->data["list_categories"] = $this->common_model->get_all($where, "id ASC");

        // form validation
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div style="clear:both;"></div><div class="alert alert-danger">', '</div>');

        $this->form_validation->set_rules("title", "title", "required|trim|xss_clean");
        $this->form_validation->set_rules("alias", "title alias", "required|trim|xss_clean");
        $this->form_validation->set_rules("parent", "parent category", "trim|xss_clean");
        $this->form_validation->set_rules("published", "published", "trim|xss_clean|max_lenght[1]|integer");
        $this->form_validation->set_rules("description", "description", "trim|xss_clean");
        $this->form_validation->set_rules("image", "image", "trim|xss_clean");

        if ($this->form_validation->run()) {
            // prepare data
            $upd_data = array(
                "name" => $this->security_clean(set_value("title")),
                "alias" => $this->security_clean(set_value("alias")),
                "description" => $this->security_clean(set_value("description")),
                "parent" => $this->security_clean(set_value("parent")),
                "published" => $this->security_clean(set_value("published")),
            );
            
            $message = "";
            if ($this->data["category_id"]) {
                $this->common_model->update($upd_data, array("id" => $this->data["category_id"]));
                $message = "Update category successfully!";
            } else {
                $this->data["category_id"] = $this->common_model->insert($upd_data);
                $message = "Add new category successfully!";
            }

            $image_from_category = $this->input->post("image_from_category");
            if (!$image_from_category) {
                $image_from_category = $this->_upload("image");
            }
            $upd_data = array(
                "image" => $image_from_category
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            define('RETURN_URL', site_url("cms/blog_categories"));
            $this->message($message);
            return FALSE;
        } else {
            // load view
            $this->load_view("blog/category", $this->data);
        }
	}
    
    public function publish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        $this->position['item'][3]['title'] = "Publish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group category id
        $cat_id = $this->input->post("cat_id");
        if ($cat_id) {
            $count = count($cat_id);
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id IN({$cat_id})" => NULL));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories published");
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Category published");
        }
        $jump_url = site_url("cms/blog_categories/search");
        header("Location: $jump_url");
    }
    
    public function unpublish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        $this->position['item'][3]['title'] = "Unpublish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group category id
        $cat_id = $this->input->post("cat_id");
        if ($cat_id) {
            $count = count($cat_id);
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id IN({$cat_id})" => NULL));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories unpublished");
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Category unpublished");
        }
        
        $jump_url = site_url("cms/blog_categories/search");
        header("Location: $jump_url");
    }
    
    public function trash() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        $this->position['item'][3]['title'] = "Trash";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group category id
        $cat_id = $this->input->post("cat_id");
        if ($cat_id) {
            $count = count($cat_id);
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id IN({$cat_id})" => NULL));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories trashed");
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                define('RETURN_URL', site_url("cms/blog_categories"));
                $this->message("Illegal operation has occurred", $this->data);
            }

            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Category trashed");
        }
        
        $jump_url = site_url("cms/blog_categories/search");
        header("Location: $jump_url");
    }

    private function _upload($filename) {
        // load library
        $this->load->library('upload');
        $this->load->library('CIframe_image_lib');

        $file_dir = FCPATH.$this->out_img_dir."/";

        // config
        $config = array();
        $config['upload_path'] = "$file_dir";
        $config['allowed_types'] = "gif|jpg|jpeg|png";
        $config['overwrite'] = TRUE;
        $this->upload->initialize($config);

        if (!$this->upload->do_upload("$filename")) {
            echo $this->upload->display_errors();
            return FALSE;
        } else {
            $data = $this->upload->data();
            
            $this->ciframe_image_lib->convert_image_uploaded($data, 450, $file_dir, $this->data["category_id"]."_450", FALSE);
            $this->ciframe_image_lib->convert_image_uploaded($data, 200, $file_dir, $this->data["category_id"]."_200",  TRUE);

            return substr($data["file_ext"], strpos($data["file_ext"], ".") + 1);
        }
    }
    
    public function photo_del() {
        $id = $this->security_clean($this->uri->segment(5, 0));
        if (!$id) {
            define('RETURN_URL', site_url("cms/blog_categories"));
            $this->message("An error occured");
            return FALSE;
        }
        
        $this->common_model->set_table("blog_categories");
        $category = $this->common_model->get_row(array("id" => $id));
        if (!$category) {
            define('RETURN_URL', site_url("cms/blog_categories"));
            $this->message("An error occured");
            return FALSE;
        }
        
        $file_dir = FCPATH.$this->out_img_dir."/";
        $file200 = $file_dir.$id."_200.".$category["image"];
		$file450 = $file_dir.$id."_450.".$category["image"];
        
        if (file_exists($file200) && file_exists($file450)) {
            unlink($file200);
            unlink($file450);
        }
        $upd_data = array(
            "image" => ''
        );
        $this->common_model->update($upd_data, array("id" => $id));
        
        define('RETURN_URL', site_url("cms/blog_categories/edit/".$id));
        $this->message("Delete completely");
        return FALSE;
    }
    
    private function _array_flatten($array, $depth = 1) { 
        if (!is_array($array)) {
            return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) {
            $tree_space = '';
            if ($depth > 1) {
                for ($i = 1; $i < $depth; $i++) {
                    $tree_space .= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
                $tree_space .= '<sup>|_</sup>';
            }
            $value["name"] = $tree_space.'&nbsp;'.$value["name"];
            array_push($result, $value);
            if (!empty($value["children"])) {
                $result = array_merge($result, $this->_array_flatten($value["children"], $depth + 1));
            }
        } 
        return $result; 
    } 
    
    private function _prepareList(array $items, $pid = 0)
    {
        $output = array();

        # loop through the items
        foreach ($items as $item) {

            # Whether the parent_id of the item matches the current $pid
            if ((int) $item['parent'] == $pid) {

                # Call the function recursively, use the item's id as the parent's id
                # The function returns the list of children or an empty array()
                if ($children = $this->_prepareList($items, $item['id'])) {

                    # Store all children of the current item
                    $item['children'] = $children;
                }

                # Fill the output
                $output[] = $item;
            }
        }

        return $output;
    }
}