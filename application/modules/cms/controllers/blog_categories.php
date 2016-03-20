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
        
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // limit
        $this->data["limit"] = $this->input->post('limit');
        if ($this->data["limit"] == "") {
            $this->data["limit"] = 10;
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
            $where["delete_flag"] = 0;
        } else {
            if ($key) {
                $where["delete_flag"] = 1;
            }
        }
        
        // list categories
        $this->common_model->set_table("blog_categories");
        $categories = $this->common_model->like($where, array("name" => $like),"parent ASC");
        if ($categories) {
            $categories_tree = $this->_prepareList($categories, $categories[0]["parent"]);
        } else {
            $categories_tree = array();
        }
        $this->data["categories"] = array_slice($this->_array_flatten($categories_tree, 1, "list"), $offset, $this->data["limit"]);
        $this->data["count_categories"] = $this->common_model->get_count($where, array("name" => $like));
        
        // generate pagination
        $this->data["key"] = "-";
        $this->data["key_disp"] = "";
        if ($key) {
            $this->data["key"] = rawurlencode($key);
            $this->data["key_disp"] = $key;
        }
        $path = "cms/blog_categories/search/".$this->data["status"]."/".$this->data["key"];
        $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_categories"], $this->data["limit"], 6);

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
		$this->data["category_id"] = $this->security_clean($this->uri->segment(4, 0));
        
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        
        if ($this->data["category_id"]) {
            // check category exists or not
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
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
        $where["delete_flag"] = 0;
        if ($this->data["category_id"] && $this->data["category"]) {
            $where["id !="] = $this->data["category_id"];
        }
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
        $this->form_validation->set_rules("parent", "parent category", "trim|xss_clean");
        $this->form_validation->set_rules("published", "published", "trim|xss_clean|max_lenght[1]|integer");
        $this->form_validation->set_rules("description", "description", "trim|xss_clean");
        $this->form_validation->set_rules("image", "image", "trim|xss_clean");

        if ($this->form_validation->run()) {
            // prepare data
            $upd_data = array(
                "name" => $this->security_clean(set_value("title")),
                "description" => $this->security_clean(set_value("description")),
                "parent" => $this->security_clean(set_value("parent")),
                "published" => $this->security_clean(set_value("published")),
            );
            
            $alias =  $this->security_clean(set_value("alias"));
            if ($alias != "") {
                $upd_data["alias"] = title2alias($alias);
            } else {
                $upd_data["alias"] = title2alias($this->security_clean(set_value("title")));
            }
            
            $message = "";
            if ($this->data["category_id"]) {
                $this->common_model->update($upd_data, array("id" => $this->data["category_id"]));
                $message = "Update category successfully!";
            } else {
                $this->data["category_id"] = $this->common_model->insert($upd_data);
                $message = "Add new category successfully!";
            }
            
            $image_from_category = $this->input->post("image_from_category");
            if (!empty($_FILES['image']['name'])) {
                $image_from_category = $this->_upload("image");
            }
            $upd_data = array(
                "image" => $image_from_category
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            $this->session->set_flashdata("message", $message);
            redirect("cms/blog_categories/search");
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
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories published!");
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_categories/search");
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Category published!");
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
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories unpublished!");
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_categories/search");
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Category unpublished!");
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
            $count = 0;
            
            // move to trash child categories
            foreach ($cat_id as $cid) {
                $child_cat = $this->_listChildCategory($cid);
                if ($child_cat) {
                    $count += count($child_cat);
                    $child_cat = $this->_array_flatten($child_cat);
                    $child_cat = implode(",", array_column($child_cat, "id"));
                    $this->common_model->set_table("blog_categories");
                    $upd_data = array(
                        "delete_flag" => 1
                    );
                    $this->common_model->update($upd_data, array("id IN({$child_cat})" => NULL));
                }
            }
            
            // move to trash categories
            $count += count($cat_id);
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id IN({$cat_id})" => NULL));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$cat_id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} categories moved to trash");
        } else {
            $count = 0;
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));

            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_categories/search");
            }
            
            // move to trash the category
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"]));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }

            $count++;
            $upd_data = array(
                "delete_flag" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));
            
            // move to trash child categories
            $child_cat = $this->_listChildCategory($this->data["category_id"]);
            if ($child_cat) {
                $count += count($child_cat);
                $child_cat = $this->_array_flatten($child_cat);
                $child_cat = implode(",", array_column($child_cat, "id"));
                $this->common_model->set_table("blog_categories");
                $upd_data = array(
                    "delete_flag" => 1
                );
                $this->common_model->update($upd_data, array("id IN({$child_cat})" => NULL));
            }
            
            // flash message
            if ($count == 1 ) {
                $this->session->set_flashdata("message", "Category moved to trash!");
            } else {
                $this->session->set_flashdata("message", "There are {$count} categories moved to trash!");
            }
        }
        
        $jump_url = site_url("cms/blog_categories/search");
        header("Location: $jump_url");
    }
    
    public function restore() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        $this->position['item'][3]['title'] = "Restore";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group category id
        $cat_id = $this->input->post("cat_id");
        if ($cat_id) {
            $count = 0;
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_all(array("id IN({$cat_id})" => NULL, "delete_flag" => 1));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }
            
            foreach ($this->data["category"] as $category) {
                $this->data["parent"] = $this->common_model->get_row(array("id" => $category["parent"], "delete_flag" => 1));
                if ($this->data["parent"]) {
                    // flash message
                    $this->session->set_flashdata("error", "Some of the categories have not been restored because their parent category is in trash!");
                } else {
                    $count++;
                    $upd_data = array(
                        "delete_flag" => 0
                    );
                    $this->common_model->update($upd_data, array("id" => $category["id"]));

                    // flash message
                    $this->session->set_flashdata("message", "There are {$count} categories restored!");
                }
            }
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_categories/search");
            }
            
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"], "delete_flag" => 1));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }
            
            $this->data["parent"] = $this->common_model->get_row(array("id" => $this->data["category"]["parent"], "delete_flag" => 1));
            if ($this->data["parent"]) {
                // flash message
                $this->session->set_flashdata("error", "The category have not been restored because its parent category is in trash!");
            } else {
                $upd_data = array(
                    "delete_flag" => 0
                );
                $this->common_model->update($upd_data, array('id' => $this->data["category_id"]));

                // flash message
                $this->session->set_flashdata("message", "Category restored!");
            }
        }
        $jump_url = site_url("cms/blog_categories/search/trash");
        header("Location: $jump_url");
    }
    
    public function delete() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Categories";
        $this->position['item'][2]['url'] = site_url("cms/blog_categories");
        $this->position['item'][3]['title'] = "Delete";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group category id
        $cat_id = $this->input->post("cat_id");
        if ($cat_id) {
            $count = 0;
            $cat_id = implode(",", $cat_id);
            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_all(array("id IN({$cat_id})" => NULL, "delete_flag" => 1));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }
            
            foreach ($this->data["category"] as $category) {
                $this->data["category_child"] = $this->common_model->get_row(array("parent" => $category["id"], "delete_flag" => 1));
                if ($this->data["category_child"]) {
                    // flash message
                    $this->session->set_flashdata("error", "Some of the categories have not been deleted because they have child categories!");
                } else {
                    $count++;
                    $this->common_model->delete(array("id" => $category["id"]));

                    // flash message
                    $this->session->set_flashdata("message", "There are {$count} categories deleted!");
                }
            }
        } else {
            // blog category id
            $this->data["category_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["category_id"] || !is_numeric($this->data["category_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_categories/search");
            }

            $this->common_model->set_table("blog_categories");
            $this->data["category"] = $this->common_model->get_row(array("id" => $this->data["category_id"], "delete_flag" => 1));
            if (!$this->data["category"]) {
                $this->session->set_flashdata("error", "The category not exist!");
                redirect("cms/blog_categories/search");
            }
            
            $this->data["category_child"] = $this->common_model->get_all(array("parent" => $this->data["category_id"], "delete_flag" => 1));
            if ($this->data["category_child"]) {
                // flash message
                $this->session->set_flashdata("error", "The category have not been deleted because it has child categories!");
            } else {
                $this->common_model->delete(array('id' => $this->data["category_id"]));
            
                // flash message
                $this->session->set_flashdata("message", "Category deleted");
            }
        }
        $jump_url = site_url("cms/blog_categories/search/trash");
        header("Location: $jump_url");
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
            $this->session->set_flashdata($this->upload->display_errors());
            return FALSE;
        } else {
            $data = $this->upload->data();
            
            $this->ciframe_image_lib->convert_image_uploaded($data, 450, $file_dir, $this->data["category_id"]."_450", FALSE);
            $this->ciframe_image_lib->convert_image_uploaded($data, 200, $file_dir, $this->data["category_id"]."_200",  TRUE);

            return substr($data["file_ext"], strpos($data["file_ext"], ".") + 1);
        }
    }
    
    public function photo_del() {
        $id = $this->security_clean($this->uri->segment(4, 0));
        if (!$id) {
            $this->session->set_flashdata("error", "The category not exist!");
            redirect("cms/blog_categories/search");
        }
        
        $this->common_model->set_table("blog_categories");
        $category = $this->common_model->get_row(array("id" => $id));
        if (!$category) {
            $this->session->set_flashdata("error", "The category not exist!");
            redirect("cms/blog_categories/search");
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
        
        $this->session->set_flashdata("message", "Delete category image completely!");
        redirect("cms/blog_categories/edit/".$id);
    }
    
    private function _array_flatten($array, $depth = 1, $type = "") { 
        if (!is_array($array)) {
            return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) {
            $tree_space = '';
            if ($depth > 1) {
                if (isset($type) && $type == "list" ) {
                    for ($i = 1; $i < $depth; $i++) {
                        $tree_space .= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    $tree_space .= '<sup>|_</sup>';
                }
                if (isset($type) && $type == "form" ) {
                    for ($i = 1; $i < $depth; $i++) {
                        $tree_space .= "-&nbsp;-&nbsp;-&nbsp;";
                    }
                }
            }
            $value["name"] = $tree_space.'&nbsp;'.$value["name"];
            array_push($result, $value);
            if (!empty($value["children"])) {
                $result = array_merge($result, $this->_array_flatten($value["children"], $depth + 1, $type));
            }
        } 
        return $result; 
    } 
    
    private function _prepareList($items = array(), $pid = 0)
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