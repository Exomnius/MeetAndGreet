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
        $this->load->model('user_model');
        
        $events = $this->event_model->getEvents();
        $data = array();

        foreach ($events as $key => $event) {
        	
        	$infoWindow['user'] = $this->user_model->get_user($event->user);
        	$infoWindow['cat'] = $this->event_model->getEventCategorie($event->catId);
        	$infoWindow['catIcon'] = $this->getCategorieIcon($event->catId);
        	$infoWindow['event'] = $event;
        	$infoWindow['joinedCount'] = $this->event_model->getEventPeopleJoinedCount($event->eventId);        	

        	// var_dump($infoWindow['cat']);
        	// die();

        	$data[] = array(
        		'event' => $event,
        		'infoWindow' => $this->load->view('templates/info_window', $infoWindow, true)
        	);
        }

    	print json_encode($data);
    }

    private function getCategorieIcon($catId){
    	if($catId == 1)
    		return 'fa fa-beer';
    	if($catId == 2)
    		return 'fa fa-glass';
    }


    public function joinEvent($eventId) {

        $this->load->model('event_model');

        $userId = 2; // todo remove this

        if($this->session->userdata('id')){
        	$data = $this->event_model->joinEvent($eventId, $userId);
        } else {
        	$data = false;
        }


    	print json_encode($data);

    }
}
