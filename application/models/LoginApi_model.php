<?php

class LoginApi_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->User = 'user';
		$this->Organization = 'org';
		$this->Employee = 'org_emp';
		$this->Emp_Role = 'emp_role_map';
		$this->Org_Role = 'org_role';
		$this->Func_Role = 'func_role_map';
		$this->Functionality = 'functionality';
	}

	public function verifyUserLogin($username, $password) {
		$this->db->select('ur.Org_ID, ur.User_ID, og.Org_Name, emp.Emp_ID, emp.Emp_Name');
		$this->db->from($this->User . ' ur');
		$this->db->join($this->Organization . ' og', 'og.Org_ID = ur.Org_ID', 'left');
		$this->db->join($this->Employee . ' emp', 'emp.Emp_ID = ur.User_ID', 'left');
		$this->db->where('ur.username', $username);
		$this->db->where('ur.password_hash', $password);
		$this->db->where('emp.Emp_Status', 1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}

	public function getRolesByUser($Emp_ID, $Org_ID) {
		$this->db->select('or.Role_ID, or.Role_Descr');
		$this->db->from($this->Emp_Role . ' er');
		$this->db->join($this->Org_Role . ' or', 'or.Role_ID = er.Role_ID', 'left');
		$this->db->where('er.Emp_ID', $Emp_ID);
		$this->db->where('er.Org_ID', $Org_ID);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}

	public function getPermissionByRoleId($roleid, $Org_ID) {
		$this->db->select('fr.Func_ID, fn.Func_Descr');
		$this->db->from($this->Func_Role . ' fr');
		$this->db->join($this->Functionality . ' fn', 'fn.Func_ID = fr.Func_ID', 'left');
		$this->db->where('fr.Role_ID', $roleid);
		$this->db->where('fn.Func_status', 1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}

}
