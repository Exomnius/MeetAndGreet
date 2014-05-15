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

    public function getEventCategorie($id) {
        $query = $this->db->select('*')->from('tbl_eventcategories')->where('catId', $id)->get();

        if ($query->num_rows() == 1)
            return $query->row_array();
        else
            return false;
    }

    public function getEventPeopleJoinedCount($id) {

        $query = $this->db->select('*')->from('tbl_eventusers')->where('eventId', $id)->get();
        $count = $query->num_rows();
        return $count;
    }

    public function joinEvent($eventId, $userId) {

        $query = $this->db->select('*')
                        ->from('tbl_eventusers')
                        ->where('eventId', $eventId)
                        ->where('userId', $userId)->get();
        $count = $query->num_rows();

        if ($count != 0)
            return -1;

        $this->db->insert('tbl_eventusers', array('userId' => $userId, 'eventId' => $eventId));
        if ($this->db->affected_rows())
            return 1;
        else
            return 0;
    }

    public function createEvent($userId, $eventName, $eventTime, $eventCategory, $eventDescription, $lat, $lng) {
        $this->db->insert('tbl_events', array('user' => $userId, 'eventName' => $eventName, 'description' => $eventDescription, 'catId' => $eventCategory, 'startTime' => $eventTime, 'latitude' => $lat, 'longitude' => $lng));


        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

}
