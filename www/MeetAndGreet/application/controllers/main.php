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
        //FOR PAGE WITH HEADER AND FOOTER DATA

        $this->parser->show('pages/home_view', $data, $header_data, $footer_data);
        //$this->parser->show('pages/home_view', $data, $header_data, $footer_data);
        
        //
    }
}
