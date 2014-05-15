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

    public function createEvent($userId, $eventName, $eventTime, $eventCategory, $eventDescription) {
        $this->db->insert('tbl_events', array('user' => $userId, 'description' => $eventDescription, 'catId' => $eventCategory, 'startTime' => $eventTime));

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

}
