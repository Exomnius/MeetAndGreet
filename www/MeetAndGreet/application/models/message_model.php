<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */

/**
 * Model with all of the user functions.
 */
class Message_model extends CI_Model {

    public function getMessages($userId) {
        
        $result = $this->db->select('*')->from('tbl_messages')->where('receiverId', $userId)->get();

        if($result->num_rows() == 0) {
        	return false;
        } else {
        	return $result->result();
        }
        
    }

    public function sendMessage($senderId, $receiverId, $message){
        $this->db->insert('tbl_messages', array('receiverId' => $receiverId, 'senderId' => $senderId, 'message' => $message));

    }

}
