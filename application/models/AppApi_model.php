<?php

class Appapi_model extends CI_Model {

	public function __construct() {
      parent::__construct();
  	}


	public function getAllCountry($searchText)
    {
        $this->db->select('*');
        $this->db->from('country');
        if($searchText !=""){
            $this->db->like("country_name", $searchText);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getStateByCountrId($countryId, $searchText)
    {   
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id', $countryId);
        if($searchText !=""){
            $this->db->like("name", $searchText);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getCityByStateId($stateId, $searchText)
    {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->where('state_id', $stateId);
        if($searchText !=""){
            $this->db->like("name", $searchText);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCacheData()
    {
        $this->db->select('*');
        $this->db->from('quickbook_auth');
        $query = $this->db->get();
        return $query->result_array();
    }

}
