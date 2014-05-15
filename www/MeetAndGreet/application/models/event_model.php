<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */

/**
 * Model with all of the user functions.
 */
class Event_model extends CI_Model {

    public function getEvents() {
		return $this->db->get('tbl_events')->result();
	}

	public function getEventCategorie($id){
		$query = $this->db->select('*')->from('tbl_eventcategories')->where('catId', $id)->get();

        if ($query->num_rows() == 1)
            return $query->result()[0];
        else
            return false;
	}

	public function getEventPeopleJoinedCount($id){

		$query = $this->db->select('*')->from('tbl_eventsusers')->where('eventId', $id)->get();
		$count = $query->num_rows();
		return $count;
	}

	public function joinEvent($eventId, $userId) {

		$query = $this->db->select('*')
						->from('tbl_eventsusers')
						->where('eventId', $eventId)
						->where('userId', $userId)->get();
		$count = $query->num_rows();

		if($count != 0)
			return -1;

		$this->db->insert('tbl_eventsusers', array('userId' => $userId, 'eventId' => $eventId));
		if ($this->db->affected_rows())
            return 1;
        else
            return 0;

	}


}