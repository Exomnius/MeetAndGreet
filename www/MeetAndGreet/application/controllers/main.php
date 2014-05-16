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
        $footer_data['js'] = array(array('url' => 'http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places'),
            array('url' => 'assets/js/jquery.geocomplete.min.js'),
            array('url' => 'assets/js/moment-min.js'),
            array('url' => 'assets/js/bootstrap-datetimepicker.min.js'));
        $header_data['css'][] = array('url' => 'assets/css/bootstrap-datetimepicker.min.css');

        //vars in form
        /* $eventName = set_value('eventName');
          $eventTime = set_valur('eventTime');
          $eventCategory = set_value('eventCategory');
          //$eventImage = set_value('username');
          $eventDescription = set_value('eventDescription');
          $eventLocation = set_value('eventLocation'); */

        $bar_progress = '';
        if ($this->session->userdata('id')) {
            //gamification
            $this->load->model('user_model');
            $xp = $this->user_model->getXp($this->session->userdata('id'))['exp'];
            $level = $this->user_model->getLevelByXp($xp);
            $nextlevel = $this->user_model->getLevel($level['level'] + 1);

            $percentage = (int) ($xp / $nextlevel['expRequired'] * 100);



            $level_progress = 'Level ' . $level['level'] . '. ' . $level['title'];

            $bar_progress = '
        <div class="progress pull-right text-center" style="width: 100%;margin-bottom: 15px; height: 35px;">
          <span style="position: absolute; width: 200px; margin-left: -100px; padding-top: 7px;">' . $percentage . '% ' . $level_progress . '</span>
          <div class="progress-bar" style="color: black; height: 100%; width: ' . $percentage . '%;" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="' . $nextlevel['expRequired'] . '" style="width: ' . $percentage . '%;">
          </div>
        </div>';
        }

        // $bar_progress = '
        // <div class="progress pull-right text-center" style="width: 100%;margin-bottom: 15px; height: 35px;">
        //   <span style="position: absolute; padding-top: 7px;">' . $percentage . '%</span>
        //   <div class="progress-bar" style="color: black; height: 100%; width: '.$percentage.'%;" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="' . $nextlevel['expRequired'] . '" style="width: ' . $percentage . '%;">
        //   </div>
        // </div>';
        //add button
        $createButton = '';
        if ($this->session->userdata('id')) {
            $createButton = '<a class="btn btn-primary pull-right" class="triggerModal" data-toggle="modal" data-target="#createModal">Create Event</a>';
        }

        //form vars
        $form_open = form_open('main/validate_event', array('id' => 'frmCreateEvent', 'class' => 'form-horizontal', 'role' => 'form'));
        //$validation_errors = validation_errors();
        $form_close = form_close();

        $data = array('title' => 'Welcome!'
            //, 'eventName' => $eventName
            //, 'eventTime' => $eventTime
            //, 'eventCategory' => $eventCategory
            //, 'eventImage' => $eventImage
            //, 'eventDescription' => $eventDescription
            //, 'eventLocation' => $eventLocation
            , 'bar_progress' => $bar_progress
            , 'createEvent' => $createButton
            , 'form_open' => $form_open
            //, 'validation_errors' => $validation_errors
            , 'form_close' => $form_close
            , 'categories' => array()
            , 'start' => date('Y-m-d H:i:s A'));

        //load categories
        $this->load->model('category_model');
        $categories = $this->category_model->getCategories();

        //var_dump($categories);

        if ($categories) {
            foreach ($categories as $category) {
                array_push($data['categories'], array('id' => $category['catId'], 'name' => $category['categorie']));
            }
        }

        $this->parser->show('pages/home_view', $data, $header_data, $footer_data);
    }

    public function validate_event() {
        /* $this->CI = & get_instance();
          $this->CI->load->library('form_validation');

          $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

          $this->form_validation->set_rules('userName', 'Username', 'trim|required|alpha_numeric|xss_clean|min_length[6]');
          $this->form_validation->set_rules('eventName', 'Event Name', 'trim|required|alpha_numeric|xss_clean|min_length[6]');
          $this->form_validation->set_rules('eventDescription', 'Event Time', 'trim|required|alpha_numeric|xss_clean');
          $this->form_validation->set_rules('eventLocation', 'Event Time', 'trim|required|alpha_numeric|xss_clean');

          $this->form_validation->set_message('required', 'Please fill in the %s field.');
          $this->form_validation->set_message('alpha_numeric', 'Please use only alpha numeric characters for the field %s.');
          $this->form_validation->set_message('min_length', 'The field %s needs to have a minimum of 6 characters.');

          if ($this->form_validation->run()) {
          //validation succeeded
          $this->add_event();
          } else {
          //validation failed
          $this->show();
          } */

        //extra validation if needed

        $this->create_event();
    }

    public function create_event() {
        $this->load->model('event_model');

        $result = $this->event_model->createEvent(
                $this->session->userdata('id')
                , $this->input->post('eventName')
                , $this->input->post('eventTime')
                , $this->input->post('eventCategory')
                , $this->input->post('eventDescription')
                , $this->input->post('lat')
                , $this->input->post('lng')
        );

        if ($result) {
            redirect('main');
        } else {
            show_error('Er is een fout opgetreden bij het toevoegen van het evenement. Gelieve een systeemadministrator te contacteren of probeer het later opnieuw.</br></br><a href="'
                    . site_url('main') . '">terug naar de homepage</a>');
        }
    }

}
