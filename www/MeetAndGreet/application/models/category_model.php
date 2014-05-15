<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */

/**
 * Model with all of the user functions.
 */
class Category_model extends CI_Model {

    public function getCategories() {
        return $this->db->get('tbl_eventCategories')->result_array();
    }

}
