<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * COMMENT ABOUT THE CONTROLLER
 */
class Api extends CI_Controller {

    /**
     * COMMENT ABOUT THE FUNCTION
     */
    public function index() {
    }

    public function getMarkers(){

        $this->load->model('event_model');
        $events = $this->event_model->getEvents();
    	print json_encode($events);
    }
}
