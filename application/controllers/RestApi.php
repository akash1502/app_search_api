<?php
class RestApi extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('RestApi_model');
	}

	public function refcountryCodeList() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$searchText = $this->input->get('searchText');

			$countryResult = $this->RestApi_model->getRefCountryList();
			$data = array();
			foreach ($countryResult as $key => $value) {
				$countryarr = array();
				$c_code = $value['Cntry_Phone_Code'];
				$c_name = $value['Cntry_Name'];
				$c_name = substr($c_name, 0, 3);

				$countryarr['id'] = $c_code;
				$countryarr['text'] = $c_name . '-' . $c_code;
				$data[] = $countryarr;
			}
			echo json_encode($data);
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

	public function countryList() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {
			$searchText = $this->input->get('searchText');

			$countryResult = $this->RestApi_model->getCountryList($searchText);
			$data = array();
			foreach ($countryResult as $key => $value) {
				$countryarr = array();
				$countryarr['id'] = $value['id'];
				$countryarr['text'] = $value['country_name'];
				$data[] = $countryarr;
			}
			echo json_encode($data);
		}
	}

	public function stateList() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$searchText = $this->input->get('searchText');
			$stateResult = $this->RestApi_model->getStateList($searchText);
			$data = array();
			foreach ($stateResult as $key => $value) {
				$countryarr = array();
				$countryarr['id'] = $value['id'];
				$countryarr['text'] = $value['name'];
				$data[] = $countryarr;
			}

			echo json_encode($data);
		}
	}

	public function cityList() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$searchText = $this->input->get('searchText');
			$cityResult = $this->RestApi_model->getCityList($searchText);
			$data = array();
			foreach ($cityResult as $key => $value) {
				$countryarr = array();
				$countryarr['id'] = $value['id'];
				$countryarr['text'] = $value['name'];
				$data[] = $countryarr;
			}

			echo json_encode($data);
		}
	}

	public function stateListByCountry() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$searchText = $this->input->get('searchText');
			$countryId = $this->input->get('ctid');

			$stateResult = $this->RestApi_model->getStateByCountrId($countryId, $searchText);
			$data = array();
			foreach ($stateResult as $key => $value) {
				$countryarr = array();
				$countryarr['id'] = $value['id'];
				$countryarr['text'] = $value['name'];
				$data[] = $countryarr;
			}

			echo json_encode($data);
		}
	}

	public function cityListByState() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$searchText = $this->input->get('searchText');
			$stateId = $this->input->get('stid');

			$cityResult = $this->RestApi_model->getCityByStateId($stateId, $searchText);
			$data = array();
			foreach ($cityResult as $key => $value) {
				$countryarr = array();
				$countryarr['id'] = $value['id'];
				$countryarr['text'] = $value['name'];
				$data[] = $countryarr;
			}

			echo json_encode($data);
		}
	}

	public function departmentList() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$searchText = $this->input->get('searchText');
			$locResult = $this->RestApi_model->getDepartmentList($searchText);
			foreach ($locResult as $key => $value) {
				$dataResult[] = array("id" => $value['dept_id'], "text" => $value['dept_name']);
			}
			echo json_encode($dataResult);
		}
	}

	public function locationList() {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$dataResult = array();
			$searchText = $this->input->get('searchText');
			$locResult = $this->RestApi_model->getLocationList($searchText);
			foreach ($locResult as $key => $value) {
				$dataResult[] = array("id" => $value['loc_id'], "text" => $value['loc_name']);
			}
			echo json_encode($dataResult);
		}
	}

	function startsWith($string, $startString) {
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}

}
