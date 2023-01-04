<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//validation related functions
if (!function_exists('validatEmptyString')) {

	function validatEmptyString($stringRef = '', $stringValue = '', $errorMsg = '') {
		$returnArr = array('statusFlag' => false, 'statusMsg' => '');
		if (empty($stringValue)) {
			$returnArr['statusFlag'] = true;
			if (!empty($errorMsg)) {
				$returnArr['statusMsg'] = $errorMsg;
			} else {
				$returnArr['statusMsg'] = "Please enter valid text for $stringRef";
			}
		}
		return $returnArr;
	}
}

if (!function_exists('getErrorString')) {

	function getErrorString($Error = '', $Description = '') {
		$errorMsg = '';
		if (!empty($Error)) {
			$errorMsg = "Error->" . $Error;
			$errorMsg .= "<br>Description->" . $Description;
		}
		return $errorMsg;
	}
}

//application status related functions
if (!function_exists('applyStatusList')) {

	function applyStatusList() {

		$STEP_0 = "In queue";
		$STEP_1 = "Initial screening in progress";
		$STEP_2 = "Rejected";
		$STEP_3 = "Initial screening successful";
		$STEP_4 = "Document screening in progress";
		$STEP_5 = "Rejected at Document round";
		$STEP_6 = "Document round screening successful";
		$STEP_9 = "Permanently blacklisted";

		$applyStatusList = array(
			0 => $STEP_0,
			1 => $STEP_1,
			2 => $STEP_2,
			3 => $STEP_3,
			4 => $STEP_4,
			5 => $STEP_5,
			6 => $STEP_6,
			9 => $STEP_9,
		);

		return $applyStatusList;
	}
}

if (!function_exists('applyStatusToString')) {

	function applyStatusToString($statusId = '') {

		$statusString = '';
		if ($statusId >= 0) {
			$applyStatusList = applyStatusList();
			if (isset($applyStatusList[$statusId]) && !empty($applyStatusList[$statusId])) {
				$statusString = $applyStatusList[$statusId];
			} else {
				echo "Status id -> $statusId not find.";
			}
		} else {
			echo "Status id -> $statusId cannot be null";
		}
		return $statusString;
	}
}

if (!function_exists('fieldStatusList')) {

	function fieldStatusList() {

		$STEP_0 = "In queue";
		$STEP_1 = "Screening in progress";
		$STEP_2 = "Level 1 Rejected";
		$STEP_3 = "Level 1 Success";
		$STEP_4 = "Level 2 screening in progress";
		$STEP_5 = "Level 2 Rejected";
		$STEP_6 = "Level 2 Success";
		$STEP_9 = "Permanently blacklisted";

		$fieldStatusList = array(
			0 => $STEP_0,
			1 => $STEP_1,
			2 => $STEP_2,
			3 => $STEP_3,
			4 => $STEP_4,
			5 => $STEP_5,
			6 => $STEP_6,
			9 => $STEP_9,
		);

		return $fieldStatusList;
	}
}

if (!function_exists('appStatusList')) {

	function appStatusList() {

		$STEP_0 = "In queue";
		$STEP_1 = "Screening in progress";
		$STEP_2 = "Level 1 Rejected";
		$STEP_3 = "Level 1 Success";
		$STEP_4 = "Level 2 screening in progress";
		$STEP_5 = "Level 2 Rejected";
		$STEP_6 = "Level 2 Success";
		$STEP_9 = "Permanently blacklisted";

		$fieldStatusList = array(
			0 => array('KEY' => 0, 'VALUE' => $STEP_0),
			1 => array('KEY' => 1, 'VALUE' => $STEP_1),
			2 => array('KEY' => 2, 'VALUE' => $STEP_2),
			3 => array('KEY' => 3, 'VALUE' => $STEP_3),
			4 => array('KEY' => 4, 'VALUE' => $STEP_4),
			5 => array('KEY' => 5, 'VALUE' => $STEP_5),
			6 => array('KEY' => 6, 'VALUE' => $STEP_6),
			9 => array('KEY' => 7, 'VALUE' => $STEP_9),
		);

		return $fieldStatusList;
	}
}

if (!function_exists('fieldStatusToString')) {

	function fieldStatusToString($statusId = '') {

		$statusString = '';
		if ($statusId >= 0) {
			$fieldStatusList = fieldStatusList();
			if (isset($fieldStatusList[$statusId]) && !empty($fieldStatusList[$statusId])) {
				$statusString = $fieldStatusList[$statusId];
			} else {
				echo "Status id -> $statusId not find.";
			}
		} else {
			echo "Status id -> $statusId cannot be null";
		}
		return $statusString;
	}
}

//user session related functions
if (!function_exists('verifySessionUser')) {

	function verifySessionUser() {
		$isLoggedIn = $_SESSION['is_logged_in'];
		if ($isLoggedIn == 1) {
			return true;
		} else {
			$users = $_SESSION['users'];
			if (isset($users) && !empty($users)) {
				redirect('/selectUserRole');
			} else {
				redirect('/');
			}
		}
		return false;
	}
}

if (!function_exists('verifyUserPermission')) {

	function verifyUserPermission($per_id) {
		$returnVal = false;
		$isLoggedIn = $_SESSION['is_logged_in'];
		if ($isLoggedIn == 1 && !empty($per_id)) {
			$permissions = $_SESSION['user_role_per'];
			if (!empty($permissions)) {
				foreach ($permissions as $key => $permission) {
					$ss_per_id = $permission['per_id'];
					if ($ss_per_id == $per_id) {
						$returnVal = true;
						break;
					}
				}
			}
		}
		return $returnVal;
	}
}

if (!function_exists('verifyUserPermissionError')) {

	function verifyUserPermissionError($per_id = '', $errorMsg = '') {
		$returnArr = array('statusFlag' => false, 'statusMsg' => '');
		if (!empty($errorMsg)) {
			$returnArr['statusMsg'] = $errorMsg;
		} else {
			$returnArr['statusMsg'] = "<br><h4>CODE: Un-authorized User</h4>Description: Insufficient permissions to access this request. Please contact to System Admin.";
		}
		$isLoggedIn = $_SESSION['is_logged_in'];
		if ($isLoggedIn == 1 && !empty($per_id)) {
			$permissions = $_SESSION['user_role_per'];
			if (!empty($permissions)) {
				foreach ($permissions as $key => $permission) {
					$ss_per_id = $permission['per_id'];
					if ($ss_per_id == $per_id) {
						$returnArr['statusFlag'] = true;
						$returnArr['statusMsg'] = '';
						break;
					}
				}
			}
		}

		return $returnArr;
	}
}