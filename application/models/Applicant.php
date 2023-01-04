<?php

class Applicant extends CI_Model {

	//Init_Appln
	public $Org_Website_URL;
	public $Appln_Email_ID;
	public $Appln_Phone_Code;
	public $Appln_Mobile_No;
	public $Date;
	public $Appln_ID;
	public $F_Name;
	public $L_Name;
	public $Org_Name;
	public $IP_Address;
	public $Appln_status;
	public $Time;

	//Appln_Screen_Lvl_1
	public $Status_website;
	public $Status_Email;
	public $Status_mobile;
	public $Status_Level1;
	public $Emp_ID_Level1;
	public $DTTM_Level1;
	public $Status_Level2;
	public $Emp_ID_Level2;
	public $DTTM_Level2;

	//Appln_Screen_Lvl_2

	public $Doc1_Upload;
	public $Doc2_Upload;
	public $MSA_Uploaded;

	public $Doc1_Level1;
	public $Doc2_Level1;
	public $Status_Level3;
	public $Emp_ID_Level3;
	public $DTTM_Level3;

	public $Doc1_Level2;
	public $Doc2_Level2;
	public $MSA_Level2;
	public $Status_Level4;
	public $Emp_ID_Level4;
	public $DTTM_Level4;

	public function __construct() {
		parent::__construct();

	}

	public function addInBlackList($applicant) {
		$retunFlag = false;

		//Set the status of applicant is blacklist
		$applicant->Appln_status = 9;
		$applicant->Status_Level1 = 2;

		$this->db->trans_begin();
		//adding the blacklist data into system

		$blacklist_data = array(
			'Org_Website_URL' => $applicant->Org_Website_URL,
			'Appln_Email_ID' => $applicant->Appln_Email_ID,
			'Appln_Phone_Code' => $applicant->Appln_Phone_Code,
			'Appln_Mobile_No' => $applicant->Appln_Mobile_No,
			'IP_Address' => $applicant->IP_Address,
			'Appln_ID' => $applicant->Appln_ID,
			'Appln_Date' => $applicant->Date,
		);
		$this->db->insert('appln_blacklist', $blacklist_data);

		//update the status at init_appln
		$int_appln_data = array(
			'Appln_status' => $applicant->Appln_status,
		);

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('init_appln', $int_appln_data);

		//update the status at appln_screen_lvl_1
		$appln_lev1_data = array(
			'Status_Level1' => $applicant->Status_Level1,
			'Emp_ID_Level1' => $applicant->Emp_ID_Level1,
			'DTTM_Level1' => $applicant->DTTM_Level1,
		);

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('appln_screen_lvl_1', $appln_lev1_data);

		if ($this->db->trans_status() === FALSE) {
			$error = $this->db->error();
			print_r($error);
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$retunFlag = true;
		}
		return $retunFlag;
	}

	public function verifyFirstLevelSecondEmpApplicant($applicant) {
		$retunFlag = false;

		echo "<br>Applicant--><pre>";
		print_r($applicant);
		echo "</pre>";exit();

		$this->db->trans_begin();
		//check WEM status of applicant
		if ($applicant->Status_mobile == '3' && $applicant->Status_Email == '3' || $applicant->Status_website == '3') {
			$applicant->Appln_status = 3;
			$applicant->Status_Level2 = 6;
		}

		if ($applicant->Status_Email == '2' || $applicant->Status_website == '2' || $applicant->Status_mobile == '2') {
			$applicant->Appln_status = 2;
			$applicant->Status_Level2 = 5;
		}

		//check the status of applicant is blacklist
		if ($applicant->Status_mobile == '2' && $applicant->Status_Email == '2' && $applicant->Status_website == '2') {
			$applicant->Appln_status = 9;
			$applicant->Status_Level2 = 2;
		}

		//adding the blacklist data into system
		if ($applicant->Appln_status == 9) {
			$orgAppn = $this->getOrgApplnByApplnId($applicant->Appln_ID);
			$blacklist_data = array(
				'Org_Website_URL' => $orgAppn->Org_Website_URL,
				'Appln_Email_ID' => $orgAppn->Appln_Email_ID,
				'Appln_Mobile_No' => $orgAppn->Appln_Mobile_No,
				'IP_Address' => $orgAppn->IP_Address,
				'Appln_ID' => $orgAppn->Appln_ID,
				'Appln_Date' => $orgAppn->Date,
			);
			$this->db->insert('appln_blacklist', $blacklist_data);

		}

		//update the status at init_appln
		$int_appln_data = array(
			'Appln_status' => $applicant->Appln_status,
		);
		if (!empty($applicant->Org_Website_URL)) {
			$int_appln_data['Org_Website_URL'] = $applicant->Org_Website_URL;
		}
		if (!empty($applicant->Appln_Email_ID)) {
			$int_appln_data['Appln_Email_ID'] = $applicant->Appln_Email_ID;
		}
		if (!empty($applicant->Appln_Mobile_No)) {
			$int_appln_data['Appln_Mobile_No'] = $applicant->Appln_Mobile_No;
		}

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('init_appln', $int_appln_data);

		//update the status at appln_screen_lvl_1
		$appln_lev1_data = array(
			'Status_Level2' => $applicant->Status_Level2,
			'Emp_ID_Level2' => $applicant->Emp_ID_Level2,
			'DTTM_Level2' => $applicant->DTTM_Level2,
		);

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('appln_screen_lvl_1', $appln_lev1_data);

		if ($this->db->trans_status() === FALSE) {

			$error = $this->db->error();
			print_r($error);

			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$retunFlag = true;
		}
		return $retunFlag;
	}

	public function verifyFirstLevelFirstEmpApplicant($applicant) {
		$retunFlag = false;

		$this->db->trans_begin();
		//check WEM status of applicant
		if ($applicant->Status_mobile == '3' && ($applicant->Status_Email == '3' || $applicant->Status_website == '3' || $applicant->Status_Email == '2' || $applicant->Status_website == '2')) {
			$applicant->Appln_status = 1;
			$applicant->Status_Level1 = 3;
		}

		//check the status of applicant is blacklist
		if ($applicant->Status_mobile == '2' && $applicant->Status_Email == '2' && $applicant->Status_website == '2') {
			$applicant->Appln_status = 9;
			$applicant->Status_Level1 = 2;
		}

		//adding the blacklist data into system
		if ($applicant->Appln_status == 9) {
			$orgAppn = $this->getOrgApplnByApplnId($applicant->Appln_ID);
			$blacklist_data = array(
				'Org_Website_URL' => $orgAppn->Org_Website_URL,
				'Appln_Email_ID' => $orgAppn->Appln_Email_ID,
				'Appln_Mobile_No' => $orgAppn->Appln_Mobile_No,
				'IP_Address' => $orgAppn->IP_Address,
				'Appln_ID' => $orgAppn->Appln_ID,
				'Appln_Date' => $orgAppn->Date,
			);
			$this->db->insert('appln_blacklist', $blacklist_data);

		}

		//update the status at init_appln
		$int_appln_data = array(
			'Appln_status' => $applicant->Appln_status,
		);
		if (!empty($applicant->Org_Website_URL)) {
			$int_appln_data['Org_Website_URL'] = $applicant->Org_Website_URL;
		}
		if (!empty($applicant->Appln_Email_ID)) {
			$int_appln_data['Appln_Email_ID'] = $applicant->Appln_Email_ID;
		}
		if (!empty($applicant->Appln_Mobile_No)) {
			$int_appln_data['Appln_Mobile_No'] = $applicant->Appln_Mobile_No;
		}

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('init_appln', $int_appln_data);

		//update the status at appln_screen_lvl_1
		$appln_lev1_data = array(
			'Status_mobile' => $applicant->Status_mobile,
			'Status_Email' => $applicant->Status_Email,
			'Status_website' => $applicant->Status_website,
			'Status_Level1' => $applicant->Status_Level1,
			'Emp_ID_Level1' => $applicant->Emp_ID_Level1,
			'DTTM_Level1' => $applicant->DTTM_Level1,
		);

		$this->db->where('Appln_ID', $applicant->Appln_ID);
		$this->db->update('appln_screen_lvl_1', $appln_lev1_data);

		if ($this->db->trans_status() === FALSE) {

			$error = $this->db->error();
			print_r($error);

			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$retunFlag = true;
		}
		return $retunFlag;
	}

	public function getAllAppln() {
		$this->db->select('
			ia.Appln_ID as Appln_ID,
			ia.Org_Website_URL,
			ia.Appln_Email_ID,
			ia.Appln_Phone_Code,
			ia.Appln_Mobile_No,
			ia.Date,
			ia.F_Name,
			ia.L_Name,
			ia.Org_Name,
			ia.Time,
			ia.IP_Address,
			ia.Appln_status,
			lv1.Status_website,
			lv1.Status_Email,
			lv1.Status_mobile,
			lv1.Status_Level1 as Status_Level1,
			lv1.Emp_ID_Level1 as Emp_ID_Level1,
			lv1.DTTM_Level1 as DTTM_Level1,
			lv1.Status_Level2 as Status_Level2,
			lv1.Emp_ID_Level2 as Emp_ID_Level2,
			lv1.DTTM_Level2 as DTTM_Level2,
			lv2.Doc1_Upload,
			lv2.Doc2_Upload,
			lv2.MSA_Uploaded,
			lv2.Doc1_Level1,
			lv2.Doc2_Level1,
			lv2.Status_Level1 as Status_Level3,
			lv2.Emp_ID_Level1 as Emp_ID_Level3,
			lv2.DTTM_Level1 as DTTM_Level3,
			lv2.Doc1_Level2,
			lv2.Doc2_Level2,
			lv2.MSA_Level2,
			lv2.Status_Level2 as Status_Level4,
			lv2.Emp_ID_Level2 as Emp_ID_Level4,
			lv2.DTTM_Level2 as DTTM_Level4');
		$this->db->from('init_appln ia');
		$this->db->join('Appln_Screen_Lvl_1 lv1', 'lv1.Appln_ID = ia.Appln_ID', 'left');
		$this->db->join('Appln_Screen_Lvl_2 lv2', 'lv2.Appln_ID = ia.Appln_ID', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getOrgApplnByApplnId($Appln_ID = '') {
		$this->db->select('*, ia.Appln_ID as Appln_ID');
		$this->db->from('init_appln ia');
		$this->db->join('Appln_Screen_Lvl_1 lv1', 'lv1.Appln_ID = ia.Appln_ID', 'left');
		$this->db->where('ia.Appln_ID', $Appln_ID);
		$query = $this->db->get();
		return $query->row();
	}

	public function checkduplicateToDatabase() {
		$retunFlag = false;

		$query = $this->db->query("SELECT Appln_ID FROM init_appln WHERE Org_Website_URL = '$this->Org_Website_URL' AND  Appln_Email_ID='$this->Appln_Email_ID' AND  Appln_Phone_Code='$this->Appln_Phone_Code' AND  Appln_Mobile_No='$this->Appln_Mobile_No' AND Date = '$this->Date'");

		$row = $query->row_array();
		//echo $this->db->last_query();
		$error = $this->db->error();
		if (empty($error->message)) {
			if (isset($row['Appln_ID']) && !empty($row['Appln_ID'])) {
				$retunFlag = true;
			} else {
				$retunFlag = false;
			}
		}

		return $retunFlag;
	}

	public function checkApplicantInBlackList() {
		$retunFlag = false;

		$query = $this->db->query("SELECT Appln_ID FROM appln_blacklist WHERE Org_Website_URL = '$this->Org_Website_URL' AND  Appln_Email_ID='$this->Appln_Email_ID' AND  Appln_Phone_Code='$this->Appln_Phone_Code' AND  Appln_Mobile_No='$this->Appln_Mobile_No' AND IP_Address='$this->IP_Address'");

		$row = $query->row_array();
		//echo $this->db->last_query();
		$error = $this->db->error();
		if (empty($error->message)) {
			if (isset($row['Appln_ID']) && !empty($row['Appln_ID'])) {
				$retunFlag = true;
			} else {
				$retunFlag = false;
			}
		}

		return $retunFlag;
	}

	public function addInitApplnToDatabase() {
		$retunFlag = false;

		$int_appln_data = array(
			"Org_Website_URL" => $this->Org_Website_URL,
			"Appln_Email_ID" => $this->Appln_Email_ID,
			"Appln_Phone_Code" => $this->Appln_Phone_Code,
			"Appln_Mobile_No" => $this->Appln_Mobile_No,
			"Date" => $this->Date,
			"Appln_ID" => $this->Appln_ID,
			"F_Name" => $this->F_Name,
			"L_Name" => $this->L_Name,
			"Org_Name" => $this->Org_Name,
			"IP_Address" => $this->IP_Address,
			"Appln_status" => $this->Appln_status,
			"Time" => $this->Time,
		);

		$this->db->insert('init_appln', $int_appln_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			if ($this->db->affected_rows() > 0) {
				$retunFlag = true;
			}
		}

		return $retunFlag;
	}

	public function addApplnLevel1ToDatabase($orgApply = '') {
		$retunFlag = false;

		$appln_lev1_data = array(
			"Appln_ID" => $orgApply->Appln_ID,
			"Status_website" => $orgApply->Status_website,
			"Status_Email" => $orgApply->Status_Email,
			"Status_mobile" => $orgApply->Status_mobile,
			"Status_Level1" => $orgApply->Status_Level1,
			"Emp_ID_Level1" => $orgApply->Emp_ID_Level1,
			"DTTM_Level1" => $orgApply->DTTM_Level1,
			"Status_Level2" => $orgApply->Status_Level2,
			"Emp_ID_Level2" => $orgApply->Emp_ID_Level2,
			"DTTM_Level2" => $orgApply->DTTM_Level2,
		);

		$this->db->insert('appln_screen_lvl_1', $appln_lev1_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			if ($this->db->affected_rows() > 0) {
				$retunFlag = true;
			}
		}

		return $retunFlag;
	}

	public function updateInitOrgApplnStatus($Appln_status, $Appln_ID) {
		$retunFlag = false;
		$int_appln_data = array(
			'Appln_status' => $Appln_status,
		);
		$this->db->where('Appln_ID', $Appln_ID);
		$this->db->update('init_appln', $int_appln_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			$retunFlag = true;
		}
		return $retunFlag;
	}

	public function generateNewApplnId() {

		$this->db->select('Appln_ID');
		$query = $this->db->get('glb_cntr');
		$row = $query->row_array();
		if (isset($row['Appln_ID']) && !empty($row['Appln_ID'])) {

			$apply_ID = $row['Appln_ID'];
			$apply_ID++;

			$glb_cntr_data = array(
				'Appln_ID' => $apply_ID,
			);

			$this->db->update('glb_cntr', $glb_cntr_data);
		}
		return $apply_ID;
	}

	public function objectToJson() {
		return json_encode($this);
	}

	public function jsonToObject($datString = '') {

		if (!empty($datString)) {
			$objdata = json_decode($datString, true);
			if (isset($objdata['first_name'])) {
				$this->F_Name = $objdata['first_name'];
			}
			if (isset($objdata['last_name'])) {
				$this->L_Name = $objdata['last_name'];
			}
			if (isset($objdata['email_id'])) {
				$this->Appln_Email_ID = $objdata['email_id'];
			}
			if (isset($objdata['country_code'])) {
				$this->Appln_Phone_Code = $objdata['country_code'];
			}
			if (isset($objdata['mob_no'])) {
				$this->Appln_Mobile_No = $objdata['mob_no'];
			}
			if (isset($objdata['org_name'])) {
				$this->Org_Name = $objdata['org_name'];
			}
			if (isset($objdata['org_website'])) {
				$this->Org_Website_URL = $objdata['org_website'];
			}
			if (isset($objdata['ip_address'])) {
				$this->IP_Address = $objdata['ip_address'];
			}
			if (isset($objdata['email_status'])) {
				$this->Status_Email = $objdata['email_status'];
			}
			if (isset($objdata['mobile_status'])) {
				$this->Status_mobile = $objdata['mobile_status'];
			}
			if (isset($objdata['website_status'])) {
				$this->Status_website = $objdata['website_status'];
			}
			if (isset($objdata['emp_level1_id'])) {
				$this->Emp_ID_Level1 = $objdata['emp_level1_id'];
			}
			if (isset($objdata['emp_level2_id'])) {
				$this->Emp_ID_Level2 = $objdata['emp_level2_id'];
			}
			if (isset($objdata['appln_ID'])) {
				$this->Appln_ID = $objdata['appln_ID'];
			} else {
				$this->Appln_ID = $this->generateNewApplnId();
			}

			if (isset($objdata['status_level2'])) {
				$this->Status_Level2 = $objdata['status_level2'];
			} else {
				$this->Status_Level2 = 0;
			}

			$this->DTTM_Level1 = date('Y-m-d H:i:s');
			$this->DTTM_Level2 = date('Y-m-d H:i:s');
			$this->Date = date('Y-m-d');
			$this->Time = time();
			$this->Appln_status = 0;

			return $this;

		}
	}

	//Akash
	public function get_Org_Doc_Details_ByApplnId($Appln_ID){
		$this->db->select('*, ia.Appln_ID as Appln_ID');
		$this->db->from('init_appln ia');
		$this->db->join('appln_screen_lvl_2 lv2', 'lv2.Appln_ID = ia.Appln_ID', 'inner');
		$this->db->join('document_uploaded_log log', 'log.Appln_ID = ia.Appln_ID', 'inner');
		$this->db->where('ia.Appln_ID', $Appln_ID);
		$query = $this->db->get();
		return $query->row();
	}


}
