<?php

class ApplicantApi extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->ERR_CODE = '';
		$this->ERR_DESCRIPTION = '';
		$this->SUC_CODE = '';
		$this->SUC_DESCRIPTION = '';
		$this->RES_LOGS = '';
		$this->RES_DATA = '';

		$this->load->helper('App_helper');

		$this->load->model('RestApi_model');
		$this->load->model('Applicant');
	}

	//Akash
	public function save_uploaded_documents() {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$data = file_get_contents('php://input');
			if ($data) {

				$data = json_decode($data);

				// echo "<pre>";print_r($data); echo "</pre>";die();
				//var_dump($data); exit;

				$Appln_ID = $data->document_data[0]->Appln_ID;
				$Doc1_Upload = $data->document_data[0]->Doc1_Upload;
				$Doc2_Upload = $data->document_data[0]->Doc2_Upload;
				$MSA_Uploaded = $data->document_data[0]->MSA_Uploaded;
				$Doc1_Level1 = $data->document_data[0]->Doc1_Level1;
				$Doc2_Level1 = $data->document_data[0]->Doc2_Level1;
				$Status_Level1 = $data->document_data[0]->Status_Level1;
				$Emp_ID_Level1 = $data->document_data[0]->Emp_ID_Level1;

				$Status_Level2 = $data->document_data[0]->Status_Level2;
				$Doc1_Level2 = $data->document_data[0]->Doc1_Level2;
				$Doc2_Level2 = $data->document_data[0]->Doc2_Level2;
				$MSA_Level2 = $data->document_data[0]->MSA_Level2;
				$Emp_ID_Level2 = $data->document_data[0]->Emp_ID_Level2;

				$Doc1_File_name = $data->document_data[0]->Doc1_File_name;
				$Doc1_File_path = $data->document_data[0]->Doc1_File_path;
				$Doc2_File_name = $data->document_data[0]->Doc2_File_name;
				$Doc2_File_path = $data->document_data[0]->Doc2_File_path;

				$save_array = array(
					'Appln_ID' => $Appln_ID,
					'Doc1_Upload ' => $Doc1_Upload,
					'Doc2_Upload' => $Doc2_Upload,
					'MSA_Uploaded' => $MSA_Uploaded,
					'Doc1_Level1' => $Doc1_Level1,
					'Doc2_Level1' => $Doc2_Level1,
					'Status_Level1' => $Status_Level1,
					'Emp_ID_Level1' => $Emp_ID_Level1,
					'DTTM_Level1' => date('Y-m-d H:i:s'),
					'Status_Level2' => $Status_Level2,
					'Doc1_Level2' => $Doc1_Level2,
					'Doc2_Level2' => $Doc2_Level2,
					'MSA_Level2' => $MSA_Level2,
					'Emp_ID_Level2' => $Emp_ID_Level2,
					'DTTM_Level2' => date('Y-m-d H:i:s'),
					'Appln_status' => 1,
				);

				$locResult = $this->RestApi_model->save_uploaded_documentData($save_array, $Appln_ID);

				$log_array = array(
					'datecreated' => date('Y-m-d H:i:s'),
					'Appln_ID' => $Appln_ID,
					'Doc1_File_name ' => $Doc1_File_name,
					'Doc1_File_path ' => $Doc1_File_path,
					'Doc2_File_name ' => $Doc2_File_name,
					'Doc2_File_path ' => $Doc2_File_path,
				);

				$logResult = $this->RestApi_model->save_uploaded_documentLog($log_array);

				if ($locResult == true) {
					$data = array('resp' => 1);
					echo json_encode($data);
					exit();
				} else {
					$data = array('resp' => 0);
					echo json_encode($data);
					exit();
				}
			} else {
				$this->ERR_CODE = 0;
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}
		} else {
			$this->ERR_CODE = 0;
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'resp' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function update_email_verification() {
		$data = file_get_contents('php://input');
		if ($data) {

			$data = json_decode($data);
			// echo "<pre>";print_r($data); echo "</pre>";
			$Appln_ID = $data->app_data->Appln_ID;
			if (!empty($Appln_ID)) {
				$data_array = array(
					'Status_Email' => 1,
				);
				$respounce = $this->RestApi_model->update_app_status($data_array, $Appln_ID);

				if ($respounce == true) {
					$data = array('resp' => 1);
					echo json_encode($data);
				} else {
					$data = array('resp' => 0, "msg" => "app id not updated");
					echo json_encode($data);
				}
			} else {
				$data = array('resp' => 0, "msg" => "app id missing");
				echo json_encode($data);
			}
		} else {
			$data = array('resp' => 0, "msg" => "Something went to wrong!");
			echo json_encode($data);
		}
	}

	public function verify_Website() {
		$data = file_get_contents('php://input');
		if ($data) {

			$data = json_decode($data);
			// echo "<pre>";print_r($data); echo "</pre>";
			$Appln_ID = $data->app_data->Appln_ID;
			if (!empty($Appln_ID)) {
				$data_array = array(
					'Status_website' => 1,
				);
				$respounce = $this->RestApi_model->update_app_status($data_array, $Appln_ID);

				if ($respounce == true) {
					$data = array('resp' => 1);
					echo json_encode($data);
				} else {
					$data = array('resp' => 0, "msg" => "app id not updated");
					echo json_encode($data);
				}
			} else {
				$data = array('resp' => 0, "msg" => "app id missing");
				echo json_encode($data);
			}
		} else {
			$data = array('resp' => 0, "msg" => "Something went to wrong!");
			echo json_encode($data);
		}
	}

	//Gopal

	public function addApplicantBlackList() {

		//verify the app user is valid
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArr = json_decode($jsonString, true);

			if (!empty($jsonArr)) {
				//echo "<br>Post Arr--><pre>"; print_r($jsonArry); echo "</pre>";exit();

				$isProcess = true;
				$validation_string = '';

				//verify the paramete data
				if (isset($jsonArr['email_status'])) {
					$retArr = validatEmptyString('Email status', $jsonArr['email_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['mobile_status'])) {
					$retArr = validatEmptyString('Contact status', $jsonArr['mobile_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['website_status'])) {
					$retArr = validatEmptyString('Org website status', $jsonArr['website_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['appln_ID'])) {
					$retArr = validatEmptyString('Org appln_ID', $jsonArr['appln_ID']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if ($isProcess) {
					$appln_id = $jsonArr['appln_ID'];
					//create org object from json String
					$applicant = $this->Applicant->getOrgApplnByApplnId($appln_id);
					$applicant->Appln_status = 9;
					$applicant->Status_Level1 = 2;

					//echo "<br>Applicant--><pre>";	print_r($applicant); echo "</pre>";exit();

					//verify the level data of applicatnt with employee.
					$isVerifiedLevel1 = $this->Applicant->addInBlackList($applicant);
					if ($isVerifiedLevel1) {

						$this->SUC_CODE = "SUCCESS";
						$this->SUC_DESCRIPTION = "Applicant added into black list.";

					} else {

						$this->ERR_CODE = "VERIFY-ERROR";
						$this->ERR_DESCRIPTION = "Applicant not added into black list.";
					}

					//echo "<br>Applicant Arr--><pre>";print_r($this->Applicant);echo "</pre>";
					//echo "<br>Applicant Json--><pre>";print_r($orgJson);echo "</pre>";

				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = $validation_string;
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function verifyApplicantLevel1Emp2() {

		//verify the app user is valid
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArr = json_decode($jsonString, true);

			if (!empty($jsonArr)) {
				//echo "<br>Post Arr--><pre>";	print_r($jsonArr);	echo "</pre>";exit();

				//$jsonArr['org_name'] = '';
				$isProcess = true;
				$validation_string = '';

				//verify the paramete data
				if (isset($jsonArr['status_level2'])) {
					$retArr = validatEmptyString('Level2 employe status', $jsonArr['status_level2']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['emp_level2_id'])) {
					$retArr = validatEmptyString('Level employee', $jsonArr['emp_level2_id']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if ($isProcess) {
					//create org object from json String
					$applicant = $this->Applicant->jsonToObject($jsonString);

					//echo "<br>Applicant--><pre>";	print_r($applicant); echo "</pre>";exit();

					//verify the level data of applicatnt with employee.
					$isVerifiedLevel2 = $this->Applicant->verifyFirstLevelSecondEmpApplicant($applicant);
					if ($isVerifiedLevel2) {

						$this->SUC_CODE = "SUCCESS";
						$this->SUC_DESCRIPTION = "Applicant application verifed at level 2.";

					} else {

						$this->ERR_CODE = "VERIFY-ERROR";
						$this->ERR_DESCRIPTION = "Applicant application verifed failed. Check File logs more details.";
					}

					//echo "<br>Applicant Arr--><pre>";print_r($this->Applicant);echo "</pre>";
					//echo "<br>Applicant Json--><pre>";print_r($orgJson);echo "</pre>";

				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = $validation_string;
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function verifyApplicantLevel1Emp1() {

		//verify the app user is valid
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArry = json_decode($jsonString, true);

			if (!empty($jsonArry)) {
				//echo "<br>Post Arr--><pre>"; print_r($jsonArry); echo "</pre>";exit();

				//$jsonArr['org_name'] = '';
				$isProcess = true;
				$validation_string = '';

				//verify the paramete data
				if (isset($jsonArr['email_status'])) {
					$retArr = validatEmptyString('Email status', $jsonArr['email_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['mobile_status'])) {
					$retArr = validatEmptyString('Contact status', $jsonArr['mobile_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['website_status'])) {
					$retArr = validatEmptyString('Org website status', $jsonArr['website_status']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['emp_level1_id'])) {
					$retArr = validatEmptyString('Level employee', $jsonArr['emp_level1_id']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if ($isProcess) {
					//create org object from json String
					$applicant = $this->Applicant->jsonToObject($jsonString);

					//echo "<br>Applicant--><pre>";	print_r($applicant); echo "</pre>";exit();

					//verify the level data of applicatnt with employee.
					$isVerifiedLevel1 = $this->Applicant->verifyFirstLevelFirstEmpApplicant($applicant);
					if ($isVerifiedLevel1) {

						$this->SUC_CODE = "SUCCESS";
						$this->SUC_DESCRIPTION = "Applicant application verifed at level 1 .";

					} else {

						$this->ERR_CODE = "VERIFY-ERROR";
						$this->ERR_DESCRIPTION = "Applicant application verifed failed. Check File logs more details.";
					}

					//echo "<br>Applicant Arr--><pre>";print_r($this->Applicant);echo "</pre>";
					//echo "<br>Applicant Json--><pre>";print_r($orgJson);echo "</pre>";

				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = $validation_string;
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function getOrgApplicant($appln_id = '') {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$isProcess = true;
			$retArr = validatEmptyString('First Name', $appln_id);
			if ($retArr['statusFlag']) {
				$isProcess = false;
				$validation_string = "<br>" . $retArr['statusMsg'];
			}

			if ($isProcess) {
				//Load the allo appln org list form database
				$orgApplicant = $this->Applicant->getOrgApplnByApplnId($appln_id);
				if (!empty($orgApplicant)) {
					$this->SUC_CODE = 'SUCCESS';
					$this->SUC_DESCRIPTION = 'Org applicant is retrived';
					$this->RES_DATA = $orgApplicant;
				} else {
					$this->ERR_CODE = "NO_RECORD";
					$this->ERR_DESCRIPTION = "Applicant not found.";
				}
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function assignOrgAppln() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArry = json_decode($jsonString, true);

			if (!empty($jsonArry)) {

				$emp_iD = $jsonArry['emp_id'];
				$appln_id = $jsonArry['appln_id'];

				//create org object from json String
				$orgApply = $this->Applicant->getOrgApplnByApplnId($appln_id);
				//verify the appln is aggigned or not
				if (isset($orgApply->Emp_ID_Level1) && !empty($orgApply->Emp_ID_Level1)) {
					$this->SUC_CODE = "SUCCESS";
					$this->SUC_DESCRIPTION = "The Org Appln is alredy assigned. Please choose another.";
				} else {

					//echo "<br>orgApply--><pre>";print_r($orgApply);echo "</pre>";exit();

					$statusList = appStatusList();

					$orgApply->Status_website = $statusList[0]['KEY'];
					$orgApply->Status_website = $statusList[0]['KEY'];
					$orgApply->Status_Email = $statusList[0]['KEY'];
					$orgApply->Status_mobile = $statusList[0]['KEY'];
					$orgApply->Emp_ID_Level1 = $emp_iD;
					$orgApply->DTTM_Level1 = date('Y-m-d H:i:s');
					$orgApply->Status_Level2 = NULL;
					$orgApply->Emp_ID_Level2 = NULL;
					$orgApply->DTTM_Level2 = NULL;

					//update status 1 of appln lev 1 as step_1
					$orgApply->Status_Level1 = $statusList[1]['KEY'];

					//add Appln Screen level2 data into table with all status step_0
					$isInserted = $this->Applicant->addApplnLevel1ToDatabase($orgApply);
					if ($isInserted) {
						//update status 1 of int appln as step_1
						$chageStatus = $this->Applicant->updateInitOrgApplnStatus($statusList[1]['KEY'], $orgApply->Appln_ID);
						if ($chageStatus) {
							//load the new object of org from databse
							$orgApply = $this->Applicant->getOrgApplnByApplnId($appln_id);

							//pass the new object to end user with sucess
							$orgJson = $this->Applicant->objectToJson();
							$this->SUC_CODE = "SUCCESS";
							$this->SUC_DESCRIPTION = "The Org Appln is assigned sucessfully.";
							$this->RES_DATA = $orgJson;

						} else {
							$this->ERR_CODE = "MYSQL-ERROR";
							$this->ERR_DESCRIPTION = "Org init appln status is not changed.";
						}

					} else {
						$this->ERR_CODE = "MYSQL-ERROR";
						$this->ERR_DESCRIPTION = "Org Leve1 data not inserted in database.";
					}

				}

				//echo "<br>orgApply--><pre>";	print_r($orgApply);	echo "</pre>";exit();

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function getOrgApplicationList() {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			//Load the allo appln org list form database
			$orgApplicationList = $this->Applicant->getAllAppln();
			if (!empty($orgApplicationList)) {
				$this->SUC_CODE = 'SUCCESS';
				$this->SUC_DESCRIPTION = 'Org application list ';
				$this->RES_DATA = $orgApplicationList;
			} else {
				$this->SUC_CODE = 'SUCCESS';
				$this->ERR_CODE = "NO_RECORD";
				$this->ERR_DESCRIPTION = "NO more records found.";
			}
		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function saveApplyOrg() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArry = json_decode($jsonString, true);

			if (!empty($jsonArry)) {
				//echo "<br>Post Arr--><pre>";print_r($jsonArry);echo "</pre>";exit();

				//$jsonArr['org_name'] = '';
				$isProcess = true;
				$validation_string = '';

				if (isset($jsonArr['first_name'])) {
					$retArr = validatEmptyString('First Name', $jsonArr['first_name']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['last_name'])) {
					$retArr = validatEmptyString('Last Name', $jsonArr['last_name']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['email_id'])) {
					$retArr = validatEmptyString('Email id', $jsonArr['email_id']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['mob_no'])) {
					$retArr = validatEmptyString('Contact No', $jsonArr['mob_no']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if (isset($jsonArr['org_name'])) {
					$retArr = validatEmptyString('Org Name', $jsonArr['org_name']);
					if ($retArr['statusFlag']) {
						$isProcess = false;
						$validation_string = "<br>" . $retArr['statusMsg'];
					}
				}

				if ($isProcess) {
					//create org object from json String
					$this->Applicant->jsonToObject($jsonString);

					//check duplicate entry of orgnization
					$isDuplicate = $this->Applicant->checkduplicateToDatabase();
					if ($isDuplicate) {

						//check org applicant is blacklisted
						$checkBlackListed = $this->Applicant->checkApplicantInBlackList();
						if ($checkBlackListed) {

							$this->ERR_CODE = "BLACKLIST-ENTRY";
							$this->ERR_DESCRIPTION = "For further assistance, Please call us on 9822403942.";
						} else {
							$this->ERR_CODE = "DUPLICATE-ENTRY";
							$this->ERR_DESCRIPTION = "Your application will be reviewed and we will revert back to you shortly.";
						}

					} else {
						//echo "<br>No duplicate found..";
						//adding the org data into duplicate
						$isInserted = $this->Applicant->addInitApplnToDatabase();
						//$isInserted = true;
						if ($isInserted) {
							$orgJson = $this->Applicant->objectToJson();
							$this->SUC_CODE = "SUCCESS";
							$this->SUC_DESCRIPTION = "Your application will be reviewed and we will revert back to you shortly.";
						} else {
							$this->ERR_CODE = "MYSQL-ERROR";
							$this->ERR_DESCRIPTION = "Org data not inserted in database.";
						}
					}

					//echo "<br>Applicant Arr--><pre>";print_r($this->Applicant);echo "</pre>";
					//echo "<br>Applicant Json--><pre>";print_r($orgJson);echo "</pre>";
				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = $validation_string;
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function validate_User_Info() {
		$returnFlag = false;
		if (isset($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && !empty($_SERVER['PHP_AUTH_PW'])) {

			$username = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];
			if (!empty($username) && !empty($password)) {
				$password = md5($password);
				$returnFlag = $this->RestApi_model->validate_User($username, $password);
			}
		}
		return $returnFlag;
	}

	//Akash
	public function get_Applicant_Docs($appln_id = '') {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$isProcess = true;
			$retArr = validatEmptyString('First Name', $appln_id);
			if ($retArr['statusFlag']) {
				$isProcess = false;
				$validation_string = "<br>" . $retArr['statusMsg'];
			}

			if ($isProcess) {
				//Load the allo appln org list form database
				$orgApplicant = $this->Applicant->get_Org_Doc_Details_ByApplnId($appln_id);
				if (!empty($orgApplicant)) {
					$this->SUC_CODE = 'SUCCESS';
					$this->SUC_DESCRIPTION = 'Org applicant is retrived';
					$this->RES_DATA = $orgApplicant;
				} else {
					$this->ERR_CODE = "NO_RECORD";
					$this->ERR_DESCRIPTION = "Applicant not found.";
				}
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);
	}

	public function saved_To_Api_Verify_Documents(){
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$data = file_get_contents('php://input');
			if ($data) {
				$data = json_decode($data);

				echo "<pre>";print_r($data); echo "</pre>";die();
				//var_dump($data); exit;

				$Appln_ID = $data->document_data[0]->Appln_ID;
				$Doc1_Upload = $data->document_data[0]->Doc1_Upload;
				$Doc2_Upload = $data->document_data[0]->Doc2_Upload;
				$MSA_Uploaded = $data->document_data[0]->MSA_Uploaded;
				$Doc1_Level1 = $data->document_data[0]->Doc1_Level1;
				$Doc2_Level1 = $data->document_data[0]->Doc2_Level1;
				$Status_Level1 = $data->document_data[0]->Status_Level1;
				$Emp_ID_Level1 = $data->document_data[0]->Emp_ID_Level1;

				$Status_Level2 = $data->document_data[0]->Status_Level2;
				$Doc1_Level2 = $data->document_data[0]->Doc1_Level2;
				$Doc2_Level2 = $data->document_data[0]->Doc2_Level2;
				$MSA_Level2 = $data->document_data[0]->MSA_Level2;
				$Emp_ID_Level2 = $data->document_data[0]->Emp_ID_Level2;

				$Doc1_File_name = $data->document_data[0]->Doc1_File_name;
				$Doc1_File_path = $data->document_data[0]->Doc1_File_path;
				$Doc2_File_name = $data->document_data[0]->Doc2_File_name;
				$Doc2_File_path = $data->document_data[0]->Doc2_File_path;

				$save_array = array(
					'Appln_ID' => $Appln_ID,
					'Doc1_Upload ' => $Doc1_Upload,
					'Doc2_Upload' => $Doc2_Upload,
					'MSA_Uploaded' => $MSA_Uploaded,
					'Doc1_Level1' => $Doc1_Level1,
					'Doc2_Level1' => $Doc2_Level1,
					'Status_Level1' => $Status_Level1,
					'Emp_ID_Level1' => $Emp_ID_Level1,
					'DTTM_Level1' => date('Y-m-d H:i:s'),
					'Status_Level2' => $Status_Level2,
					'Doc1_Level2' => $Doc1_Level2,
					'Doc2_Level2' => $Doc2_Level2,
					'MSA_Level2' => $MSA_Level2,
					'Emp_ID_Level2' => $Emp_ID_Level2,
					'DTTM_Level2' => date('Y-m-d H:i:s'),
					'Appln_status' => 1,
				);

				$locResult = $this->RestApi_model->save_uploaded_documentData($save_array, $Appln_ID);

				$log_array = array(
					'datecreated' => date('Y-m-d H:i:s'),
					'Appln_ID' => $Appln_ID,
					'Doc1_File_name ' => $Doc1_File_name,
					'Doc1_File_path ' => $Doc1_File_path,
					'Doc2_File_name ' => $Doc2_File_name,
					'Doc2_File_path ' => $Doc2_File_path,
				);

				$logResult = $this->RestApi_model->save_uploaded_documentLog($log_array);

				if ($locResult == true) {
					$data = array('resp' => 1);
					echo json_encode($data);
					exit();
				} else {
					$data = array('resp' => 0);
					echo json_encode($data);
					exit();
				}
			} else {
				$this->ERR_CODE = 0;
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}
		} else {
			$this->ERR_CODE = 0;
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
		}

		$jsonArr = array(
			'resp' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		//echo json_encode($jsonArr);	
	}

}
