<?php

/**
 * @author Cornel Janssen   <janssen_cornel@hotmail.com>
 * @author Nick Thoelen     <nickthoelen@gmail.com>
 * based on codeigniter parser class
 * Creates an instance of the MY_Parser class.
 */
class MY_Parser extends CI_Parser {
    
    /**
     * Creates an instance of the MY_Parser class.
     */
    function __construct() {
        $this->CI = & get_instance();
        $this->header = "";
    }

    /**
     * generates the header variables, css links and navigation bar.
     * 
     * @param type $header_data
     * @return type
     */
    private function generate_header($header_data) {
        if (empty($header_data['css']) || !is_array($header_data['css']))
            $header_data['css'] = array(
                0 => array('url' => base_url('assets/css/bootstrap.min.css')),
                1 => array('url' => base_url('assets/css/custom-style.css'))
            );
        else
            array_push($header_data['css'], array('url' => base_url('assets/css/bootstrap.min.css')), array('url' => base_url('assets/css/custom-style.css')));

        //specific data in header
        $header_data['js'] = base_url('assets/js/jquery-2.0.3.min.js');
        
        //header links
        $header_data['main'] = site_url('main');
        
        //favicon link
        $header_data['favicon'] = base_url('favicon.ico');
        
        
        $CI = &get_instance();
        $CI->load->model('user_model');

        //check if message has bene passed
        if ($CI->session->userdata('message')) {
            $title = $CI->session->userdata('message')['title'];
            $message = $CI->session->userdata('message')['message'];

            $message_modal = '<div id="message_modal" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' . $title . '</h4></div><div class="modal-body"><p>' . $message . '</p></div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">Bevestig</button></div></div></div></div>';
            $CI->session->unset_userdata('message');
        } else
            $message_modal = '';

        $header_data['message_modal'] = $message_modal;

        //dynamic login link
        if (!$CI->session->userdata('logged_in')) {
            $header_data['profile'] = site_url('register');
            $header_data['login'] = site_url('login');
            $header_data['profilet'] = 'Register';
            $header_data['logint'] = 'Log in';
        } else {
            $is_admin = $CI->user_model->check_admin($CI->user_model->get_user($CI->session->userdata('id'))['user_group']);

            $header_data['profile'] = site_url('user/show/' . $CI->session->userdata('username'));
            $header_data['login'] = site_url('user/logout');
            $header_data['profilet'] = 'Profiel';
            $header_data['logint'] = 'Logout';
            if ($is_admin)
                $header_data['cms'] = '<a href="' . site_url('cms') . '">Beheer</a>';
        }

        return $this->CI->parser->parse('templates/header_view', $header_data, true);
    }

    /**
     * Generates the footer variables and javascript.
     * 
     * @param type $footer_data
     * @return type
     */
    private function generate_footer($footer_data) {
        if (empty($footer_data['js']) || !is_array($footer_data['js']))
            $footer_data['js'] = array(
                0 => array('url' => base_url('assets/js/bootstrap.min.js'))
            );
        else
            array_push($footer_data['js'], array('url' => base_url('assets/js/bootstrap.min.js')));

        $footer_data['date'] = date('Y');

        return $this->CI->parser->parse('templates/footer_view', $footer_data, true);
    }

    /**
     * Displays the header, page-dependant and footer view.
     * 
     * @param type $view
     * @param type $data
     * @param type $header_data
     * @param type $footer_data
     */
    function show($view, $data = null, $header_data = null, $footer_data = null) {
        ob_start();
        echo $this->generate_header($header_data);
        echo $this->CI->parser->parse($view, $data, true);
        echo $this->generate_footer($footer_data);
        ob_flush();
    }
}

?>
