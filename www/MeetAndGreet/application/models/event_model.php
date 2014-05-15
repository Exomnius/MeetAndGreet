<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */

/**
 * Model with all of the user functions.
 */
class Event_model extends CI_Model {


	public function getEvents(){
		return $this->db->get('tbl_events')->result();
	}

}