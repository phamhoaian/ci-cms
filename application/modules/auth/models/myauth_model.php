<?php
class Myauth_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}




	function get_pref_list()
	{
		#$this->db->order_by('id desc');
		$query = $this->db->get("pref");
		return $query->result();
	}


	function get_worktype_list()
	{
		#$this->db->order_by('id desc');
		$query = $this->db->get("work_type");
		return $query->result();
	}





	function get_one_user_temp($username,$key)
	{
		$this->db->where('username', $username);
		$this->db->where('activation_key', $key);
		$query = $this->db->get("user_temp",1);
		if ($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	function get_one_user_temp_by_key($key)
	{
		$this->db->where('activation_key', $key);
		$query = $this->db->get("user_temp",1);
		if ($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	





	function get_one_user_id_by_username($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get("users",1);
		$row = $query->row();
		if($row){
			return $row->id;
		}else{
			return FALSE;
		}
	}






	function get_one_user_id_by_email($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get("users",1);
		$row = $query->row();
		if($row){
			return $row->id;
		}else{
			return FALSE;
		}
	}






	function get_one_user_profile_forgot_password($id,$year,$month,$day)
	{
		$this->db->where('user_id', $id);
		$this->db->where('birth_year', $year);
		$this->db->where('birth_month', $month);
		$this->db->where('birth_day', $day);
		$query = $this->db->get("user_profile",1);
		$row = $query->row();
		if($row){
			return $row->user_id;
		}else{
			return FALSE;
		}
	}











}
?>
