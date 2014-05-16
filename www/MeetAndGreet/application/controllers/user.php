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

        //form vars
        $form_open = form_open('user/validate_friend', array('id' => 'frmAddFriend', 'class' => 'form-horizontal', 'role' => 'form'));
        $validation_errors = validation_errors();
        $form_close = form_close();

        $data = array('form_open' => $form_open, 'validation_errors' => $validation_errors, 'form_close' => $form_close, 'username' => $this->session->userdata('username'), 'friends' => array());

        $this->load->model('user_model');
        $friends = $this->user_model->getFriends($this->session->userdata('id'));

        if ($friends) {
            foreach ($friends as $user) {
                $level = $this->user_model->getLevelByXp($user['exp']);
                $data['friends'][] = array(
                    'friendname' => $user['username'],
                    'city' => $user['city'],
                    'level' => $level['level']);
            }
        }

        $this->parser->show('pages/friendlist_view', $data, $header_data, $footer_data);
    }

    public function validate_friend() {
        $this->load->model('user_model');
        $friend = $this->user_model->getUserByName($this->input->post('searchName'));

        if ($friend) {
            $result = $this->user_model->checkIfFriend($this->session->userdata('id'), $friend['userId']);

            if (!$result) {
                $result = $this->user_model->addFriend($this->session->userdata('id'), $friend['userId']);

                if ($result) {
                    $this->session->set_userdata('message', array('title' => 'Success', 'message' => $friend['username'] . ' has been added to your friendslist!'));
                } else {
                    $this->session->set_userdata('message', array('title' => 'Error', 'message' => 'Error while adding ' . $friend['username'] . ' to your friendslist!'));
                }
            } else {
                $this->session->set_userdata('message', array('title' => 'Error', 'message' => 'User ' . $friend['username'] . ' is already in your friendslist!'));
            }
        } else {
            $this->session->set_userdata('message', array('title' => 'Not Found', 'message' => 'A user with the name ' . $this->input->post('searchName') . ' has not been found!'));
        }

        redirect('user/friends');
    }

}
