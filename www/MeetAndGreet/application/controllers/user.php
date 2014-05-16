<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author 11303078
 */
class user extends CI_Controller {

    public function index() {
        $footer_data['js'] = array(array('url' => 'http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places'),
            array('url' => 'assets/js/jquery.geocomplete.min.js'),
            array('url' => 'assets/js/moment-min.js'),
            array('url' => 'assets/js/bootstrap-datetimepicker.min.js'));
        $header_data['css'][] = array('url' => 'assets/css/bootstrap-datetimepicker.min.css');
    }

    public function friends() {
        if (!$this->session->userdata('logged_in')) {
            redirect('main');
        }
        $footer_data['js'] = array(array('url' => 'assets/js/moment-min.js'),
            array('url' => 'assets/js/bootstrap-datetimepicker.min.js'));
        $header_data['css'][] = array('url' => 'assets/css/bootstrap-datetimepicker.min.css');

        $data['username'] = $this->session->userdata('username');
        $this->load->model('user_model');
        $friends = $this->user_model->getFriends($this->session->userdata('id'));
        $data['friends'] = array();
        
        if ($friends){
            foreach ($friends as $user) {
                $data['friends'][] = array(
                    'friendname' => $user['username'],
                    'city' => $user['city'],
                    'level' => $this->user_model->getLevelByXp($user['exp']));
            }
        }

        $this->parser->show('pages/friendlist_view', $data, $header_data, $footer_data);
    }

}
