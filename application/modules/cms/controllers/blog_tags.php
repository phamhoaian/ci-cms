<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_tags extends MY_Controller {
    
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
       $this->data["active_sub_menu"] = "blog_tags";
       
       // the number of item per page
       $this->limit = 10;
   }
   
   public function index() {
       $jump_url = site_url("cms/blog_tags/search");
       header("Location: $jump_url");
   }
   
   public function search() {
       // load css and js
       $this->set_css("green.css");
       $this->set_js("icheck.min.js");
       
       // breadcrumbs
       $this->position['item'][2]['title'] = "Tags";
       $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
       
       // limit
       $this->data["limit"] = $this->input->post('limit');
       if ($this->data["limit"] == "") {
           $this->data["limit"] = $this->limit;
       }
       if ($this->data["limit"] == 0) {
           $this->data["limit"] = NULL;
       }
       
       // keyword
       $key = $this->security_clean($this->uri->segment(4));
       if ($this->input->post('search')) {
           $key = $this->security_clean($this->input->post('search'));
       }
       if ($key === "-") {
           $key = "";
       }
       $key = trim($key);
       $like = key2like($key);
       
       // offset
       $offset = (int) $this->uri->segment(5, 0);
       
       // list tags
       $this->common_model->set_table("blog_tags");
       $this->data["tags"] = $this->common_model->like(null, array("name" => $like), "id DESC", $this->data["limit"], $offset);
       $this->data["count_tags"] = $this->common_model->get_count(null, array("name" => $like));
       foreach ($this->data["tags"] as &$tag) {
           $this->common_model->set_table("blog_tags_xref");
           $tag["count"] = $this->common_model->get_count(array("tagID" => $tag["id"]));
       }
       
       // generate pagination
       $this->data["key"] = "-";
       $this->data["key_disp"] = "";
       if ($key) {
           $this->data["key"] = rawurlencode($key);
           $this->data["key_disp"] = $key;
       }
       $path = "cms/blog_tags/search/".$this->data["key"];
       $this->data["pagination"] = $this->generate_pagination($path, $this->data["count_tags"], $this->data["limit"], 6);
       
       // load view
       $this->load_view("blog/tags", $this->data);
   }
   
   public function edit() {
       // load css and js
       $this->set_css("switchery.min.css");
       $this->set_js("switchery.min.js");
       
       // tag id
       $this->data["tag_id"] = $this->security_clean($this->uri->segment(4, 0));
       
       // breadcrumbs
       $this->position['item'][2]['title'] = "Tags";
       $this->position['item'][2]['url'] = site_url("cms/blog_tags");
       
       if ($this->data["tag_id"]) {
           // check tag exists or not
           $this->common_model->set_table("blog_tags");
           $this->data["tag"] = $this->common_model->get_row(array("id" => $this->data["tag_id"]));
           if (!$this->data["tag"]) {
               $this->session->set_flashdata("error", "The tag not exist!");
               redirect("cms/blog_tags/search");
           }
       
           // breadcrumbs
           $this->position['item'][3]['title'] = "Edit";
           $this->data["page_title"] = "Edit Tag";
       } else {
           // breadcrumbs
           $this->position['item'][3]['title'] = "New";
           $this->data["page_title"] = "Add New Tag";
       
           $this->data["tag"] = array(
               "name" => "",
               "published" => 1
           );
       }
       $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
       
       // form validation
       $this->load->helper('form');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div style="clear:both;"></div><div class="alert alert-danger">', '</div>');
       
       $this->form_validation->set_rules("name", "name", "required|trim|xss_clean");
       $this->form_validation->set_rules("published", "published", "trim|xss_clean|max_lenght[1]|interger");
       
       if ($this->form_validation->run()) {
           // prepare data
           $upd_data = array(
               "name" => $this->security_clean(set_value("name")),
               "published" => $this->security_clean(set_value("published"))
           );
           
           $this->common_model->set_table("blog_tags");
           if ($this->data["tag_id"]) {
               $this->common_model->update($upd_data, array("id" => $this->data["tag_id"]));
               $message = "Update tag successfully!";
           } else {
               $this->data["tag_id"] = $this->common_model->insert($upd_data);
               $message = "Add new tag successfully!";
           }
           
           $this->session->set_flashdata("message", $message);
           redirect("cms/blog_tags/search");
       }
       
       // load view
       $this->load_view("blog/tag", $this->data);
   }
   
public function publish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Tags";
        $this->position['item'][2]['url'] = site_url("cms/blog_tags");
        $this->position['item'][3]['title'] = "Publish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);

        // group tag id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} tag published!");
        } else {
            // tag id
            $this->data["tag_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
            
            if (!$this->data["tag_id"] || !is_numeric($this->data["tag_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_tags/search");
            }

            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_row(array("id" => $this->data["tag_id"]));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }

            $upd_data = array(
                "published" => 1
            );
            $this->common_model->update($upd_data, array('id' => $this->data["tag_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Tag published!");
        }
        $jump_url = site_url("cms/blog_tags/search");
        header("Location: $jump_url");
    }
    
    public function unpublish() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Tags";
        $this->position['item'][2]['url'] = site_url("cms/blog_tags");
        $this->position['item'][3]['title'] = "Unpublish";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
        
        // group tag id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_row(array("id IN({$id})" => NULL));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array("id IN({$id})" => NULL));
            
            // flash message
            $this->session->set_flashdata("message", "There are {$count} tags unpublished!");
        } else {
            // tag id
            $this->data["tag_id"] = (int) $this->security_clean($this->uri->segment(4, ""));            

            if (!$this->data["tag_id"] || !is_numeric($this->data["tag_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_tags/search");
            }

            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_row(array("id" => $this->data["tag_id"]));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }

            $upd_data = array(
                "published" => 0
            );
            $this->common_model->update($upd_data, array('id' => $this->data["tag_id"]));
            
            // flash message
            $this->session->set_flashdata("message", "Tag unpublished!");
        }
        
        $jump_url = site_url("cms/blog_tags/search");
        header("Location: $jump_url");
    }
    
    public function delete() {
        // breadcrumbs
        $this->position['item'][2]['title'] = "Tags";
        $this->position['item'][2]['url'] = site_url("cms/blog_tags");
        $this->position['item'][3]['title'] = "Delete";
        $this->data['position'] = $this->load->view("pc/parts/position", $this->position, TRUE);
    
        // group tag id
        $id = $this->input->post("id");
        if ($id) {
            $count = count($id);
            $id = implode(",", $id);
            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_all(array("id IN({$id})" => NULL));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }
    
            $this->common_model->delete(array("id IN({$id})" => NULL));
    
            // flash message
            $this->session->set_flashdata("message", "There are {$count} tags deleted!");
        } else {
            // tag id
            $this->data["tag_id"] = (int) $this->security_clean($this->uri->segment(4, ""));
    
            if (!$this->data["tag_id"] || !is_numeric($this->data["tag_id"])) {
                $this->session->set_flashdata("error", "Illegal operation has occurred!");
                redirect("cms/blog_tags/search");
            }
    
            $this->common_model->set_table("blog_tags");
            $this->data["tag"] = $this->common_model->get_row(array("id" => $this->data["tag_id"]));
            if (!$this->data["tag"]) {
                $this->session->set_flashdata("error", "The tag not exist!");
                redirect("cms/blog_tags/search");
            }
    
            $this->common_model->delete(array('id' => $this->data["tag_id"]));
    
            // flash message
            $this->session->set_flashdata("message", "Tag deleted!");
        }
        $jump_url = site_url("cms/blog_tags/search");
        header("Location: $jump_url");
    }
}