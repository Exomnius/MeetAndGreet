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

    public function updateLastLogin($lat = null, $long = null){
 
        if($this->session->userdata('id') && $lat !== null && $long !== null){
        	$this->load->model('user_model');
        	$this->user_model->updateLastLogin($this->session->userdata('id'), (double)$lat, (double)$long);
        }

        $data['lat'] = (double)$lat;
        $data['long'] = (double)$long;
    	print json_encode($data);


    }

    public function getFriends(){

        if(!$this->session->userdata('id'))
        	return;

        $this->load->model('user_model');

        $friends = $this->user_model->getFriends($this->session->userdata('id'));
        $data = array();

        foreach ($friends as $key => $value) {

        	// $data[$key]['user'] = $this->user_model->get_user($value['userId']);
        	$user = $this->user_model->get_user($value['userId']);

        	$last_login = date_create($user['last_login']);
			$now = new DateTime();
			$difference = $now->diff($last_login);

			if((int)$difference->format('%d') < 1){	
				$temp['user'] = $user;			
				$data[$key]['user'] = $user;
				$data[$key]['infoWindow'] = $this->load->view('templates/info_window_friend', $temp, true);
			}

        }

    	print json_encode($data);


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
        	if($this->session->userdata('id')){
        		$infoWindow['allowJoin'] = $this->event_model->allowUserToJoin($this->session->userdata('id'), $event->eventId);
        		
        	} else {
        		$infoWindow['allowJoin'] = false;
        	}
        	// var_dump($infoWindow['cat']);
        	// die();

        	$data[] = array(
        		'event' => $event,
        		'cat' => $infoWindow['cat'],
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

    	if(!$this->session->userdata('id'))
    		return;

        $this->load->model('event_model');

        

        if($this->session->userdata('id')){
        	$data = $this->event_model->joinEvent($eventId, $this->session->userdata('id'));
        } else {
        	$data = false;
        }


    	print json_encode($data);

    }


    public function getMessages(){

    	if(!$this->session->userdata('id')){
    		return;
    	}

    	$this->load->model('user_model');
    	$this->load->model('message_model');
        $results = $this->message_model->getMessages($this->session->userdata('id'));

        $data = array();
        if($results){
        	foreach ($results as $key => $result) {
        		$data[$key]['message'] = $result;
        		$data[$key]['user'] =  $this->user_model->get_user($result->senderId);
        	}
        }

    	print json_encode($data);

    }

    public function sendMessage(){
    	if(!$this->session->userdata('id')){
    		return;
    	}

    	$this->load->model('message_model');

    	$message = $this->input->post('message');
    	$receiverId = $this->input->post('userId');

    	if($message && $receiverId){
    		$this->message_model->sendMessage($this->session->userdata('id'), $receiverId, $message);
    	}
    }
}
