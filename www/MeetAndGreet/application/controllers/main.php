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
        $header_data['title'] = 'Homepagina';
        $footer_data['active'] = 'home';
        $header_data['header'] = '';
        
        $footer_data['js'] = array(array('url' => 'http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places'),
                                    (array('url' => 'jquery.geocomplete.js')));
        
        $data =array('title' => 'Welcome!');

        $this->parser->show('pages/home_view', $data, $header_data, $footer_data);
    }
}
