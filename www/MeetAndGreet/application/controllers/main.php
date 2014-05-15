<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * COMMENT ABOUT THE CONTROLLER
 */
class Main extends CI_Controller {

    /**
     * COMMENT ABOUT THE FUNCTION
     */
    public function index() {
        $footer_data['js'] = array(array('url' => 'http://maps.google.com/maps/api/js?sensor=true"'));
        
        $data =array('title' => 'Welcome!');

        $this->parser->show('pages/home_view', $data, $header_data, $footer_data);
    }
}
