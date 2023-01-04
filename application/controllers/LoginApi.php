<?php
class LoginApi extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->ERR_CODE = '';
		$this->ERR_DESCRIPTION = '';
		$this->SUC_CODE = '';
		$this->SUC_DESCRIPTION = '';
		$this->RES_LOGS = '';
		$this->RES_DATA = '';

		$this->load->model('RestApi_model');
		$this->load->model('LoginApi_model');
	}

	public function getRolePermission() {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$roleid = $_GET["role_id"];
			$empid = $_GET["emp_id"];
			$orgid = $_GET["org_id"];

			$getPermissionByRole = "";
			if (!empty($roleid)) {

				$getPermissionByRole = $this->LoginApi_model->getPermissionByRoleId($roleid, $orgid);

				$this->SUC_CODE = "SUCCESS";
				$this->SUC_DESCRIPTION = "Sucessfully fetched permissions.";
				$this->RES_DATA = $getPermissionByRole;

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Provided params is a empty.";
			}

			$jsonArr = array(
				'ERR_CODE' => $this->ERR_CODE,
				'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
				'SUC_CODE' => $this->SUC_CODE,
				'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
				'RES_LOGS' => $this->RES_LOGS,
				'RES_DATA' => $this->RES_DATA,
			);

			//echo "<br>JsonArr--><pre>";print_r($jsonArr);	echo "</pre>";exit();
			echo json_encode($jsonArr);
		}
	}

	public function verifyUserLogin() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");

			//echo "<pre>Json Data --><br>"; print_r($jsonArry);echo"</pre>";exit();

			if (isset($jsonString) && !empty($jsonString)) {
				$jsonArry = json_decode($jsonString, true);
				if (isset($jsonArry['username']) && !empty($jsonArry['username'])) {
					$username = $jsonArry['username'];
					if (isset($jsonArry['password']) && !empty($jsonArry['password'])) {
						$password = $jsonArry['password'];
						$mdHashPassword = md5($password);

						$userLoginDetails = $this->LoginApi_model->verifyUserLogin($username, $mdHashPassword);
						if (!empty($userLoginDetails)) {

							foreach ($userLoginDetails as $key => $userData) {
								$userID = $userData['User_ID'];
								$orgID = $userData['Org_ID'];

								$userRoles = $this->LoginApi_model->getRolesByUser($userID, $orgID);
								$userLoginDetails[$key]['user_role'] = $userRoles;

							}

							$this->SUC_CODE = "SUCCESS";
							$this->SUC_DESCRIPTION = "User sucessfully logged In.";
							$this->RES_DATA = $userLoginDetails;

						} else {
							$this->ERR_CODE = "AUTH-ERROR";
							$this->ERR_DESCRIPTION = "Unauthorized access.";
						}

					} else {
						$this->ERR_CODE = "MISSING-PARAM";
						$this->ERR_DESCRIPTION = "Password is required.";
					}
				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = "User name is required.";
				}
			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Provided Json string is a empty.";
			}

			$jsonArr = array(
				'ERR_CODE' => $this->ERR_CODE,
				'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
				'SUC_CODE' => $this->SUC_CODE,
				'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
				'RES_LOGS' => $this->RES_LOGS,
				'RES_DATA' => $this->RES_DATA,
			);

			//echo "<br>JsonArr--><pre>";print_r($jsonArr);	echo "</pre>";exit();
			echo json_encode($jsonArr);
		}

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

		if ($returnFlag) {
			return $returnFlag;
		} else {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			exit();
		}
	}

}
