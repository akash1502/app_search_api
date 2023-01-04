<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'Login/app_login';

$route['rest/api/refCountryCodes'] = 'RestApi/refcountryCodeList';

$route['rest/api/verifyUserLogin'] = 'LoginApi/verifyUserLogin';
$route['rest/api/getRolePermission'] = 'LoginApi/getRolePermission';

$route['rest/api/saveApplyOrg'] = 'ApplicantApi/saveApplyOrg';
$route['rest/api/getOrgApplList'] = 'ApplicantApi/getOrgApplicationList';
$route['rest/api/assignOrgAppln'] = 'ApplicantApi/assignOrgAppln';
$route['rest/api/getOrgApplicant/(:num)'] = 'ApplicantApi/getOrgApplicant/$1';
$route['rest/api/verifyApplicantLevel1Emp1'] = 'ApplicantApi/verifyApplicantLevel1Emp1';
$route['rest/api/verifyApplicantLevel1Emp2'] = 'ApplicantApi/verifyApplicantLevel1Emp2';
$route['rest/api/addApplicantBlackList'] = 'ApplicantApi/addApplicantBlackList';

//Akash

$route['rest/api/save_uploaded_documents'] = 'ApplicantApi/save_uploaded_documents';
$route['rest/api/update_email_verification'] = 'ApplicantApi/update_email_verification';
$route['rest/api/verify_Website'] = 'ApplicantApi/verify_Website';
$route['rest/api/getApplicantDocs/(:num)'] = 'ApplicantApi/get_Applicant_Docs/$1';

$route['rest/api/savedToApiVerifyDocuments'] = 'ApplicantApi/saved_To_Api_Verify_Documents';

//NO longer needs below apis created for test pocs
$route['rest/api/countryList'] = 'RestApi/countryList';
$route['rest/api/stateList'] = 'RestApi/stateList';
$route['rest/api/cityList'] = 'RestApi/cityList';
$route['rest/api/stateListByCountry'] = 'RestApi/stateListByCountry';
$route['rest/api/cityListByState'] = 'RestApi/cityListByState';
$route['rest/api/locationList'] = 'RestApi/locationList';
$route['rest/api/departmentList'] = 'RestApi/departmentList';
