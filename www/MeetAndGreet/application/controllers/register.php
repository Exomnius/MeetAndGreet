<?php

/**
 * @author Cornel Janssen <janssen_cornel@hotmail.com>
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This class manages the register functions for the CMS.
 */
class Register extends CI_Controller {

    /**
     * Creates an instance of the class.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * redirects to the show() function.
     */
    function index() {
        $this->show();
    }

    /**
     * Displays the register form.
     */
    function show() {
        // Style sheets + Javascript files
        $header_data['css'][] = array('url' => base_url('assets/css/bootstrap-datetimepicker.min.css'));
        $footer_data['js'] = array(array('url' => base_url('assets/js/moment-min.js')),
            array('url' => base_url('assets/js/bootstrap-datetimepicker.min.js')),
            array('url' => base_url('assets/js/bootstrap-datetimepicker.nl.js')),
            array('url' => base_url('assets/js/bootstrap-tooltip.js')),
            array('url' => base_url('assets/js/bootstrap-popover.js')));

        $header_data['title'] = 'Registreer';
        $header_data['active'] = 'register';

        $username = set_value('username');
        $firstname = set_value('firstname');
        $lastname = set_value('lastname');
        $dob = set_value('dob') ? set_value('dob') : date("d-m-Y");
        $gender = '';
        $address = set_value('address');
        $city = set_value('city');
        $email = set_value('email');
        
        if (set_value('radgender') == 1)
            $gender = '<input type="radio" name="radGender" value="0"> Man <input type="radio" name="radGender" value="1"checked> Vrouw';
        else
            $gender = '<input type="radio" name="radGender" value="0" checked> Man <input type="radio" name="radGender" value="1"> Vrouw';

        $form_open = form_open('register/validate_info', array('id' => 'frmRegister', 'class' => 'form-horizontal col-lg-6 col-lg-offset-3', 'role' => 'form'));
        $validation_errors = validation_errors();
        $form_close = form_close();

        $cancel = site_url('main');

        $data = array('username' => $username
            , 'firstname' => $firstname
            , 'lastname' => $lastname
            , 'dob' => $dob
            , 'gender' => $gender
            , 'address' => $address
            , 'city' => $city
            , 'email' => $email
            , 'form_open' => $form_open
            , 'validation_errors' => $validation_errors
            , 'form_close' => $form_close
            , 'cancel' => $cancel);

        $this->parser->show('pages/register_view', $data, $header_data, $footer_data);
    }

    /**
     * Validates the entered data from the register form.
     */
    public function validate_info() {
        $this->CI = & get_instance();
        $this->CI->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $this->form_validation->set_rules('username', 'Gebruikersnaam', 'trim|required|alpha_numeric|xss_clean|min_length[6]|is_unique[tbl_users.username]|is_unique[tbl_users.username]');
        $this->form_validation->set_rules('firstname', 'Voornaam', 'trim|required|alpha|xss_clean');
        $this->form_validation->set_rules('lastname', 'Achternaam', 'trim|required|alpha|xss_clean');
        $this->form_validation->set_rules('dob', 'Geboortedatum', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'Adres', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'Stad', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'E-mailadres', 'trim|required|xss_clean|valid_email|is_unique[tbl_users.email]|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('passwordCheck', 'Herhaal wachtwoord', 'trim|required|xss_clean|matches[password]');

        $this->form_validation->set_message('validate_credentials', 'Verkeerde gebruikersnaam en/of wachtwoord.');
        $this->form_validation->set_message('required', 'Gelieve het veld %s in te vullen.');
        $this->form_validation->set_message('alpha_numeric', 'Gelieve alleen alpha numerieke karakters te gebruiken voor het veld %s.');
        $this->form_validation->set_message('is_unique', 'Het waarde van het veld %s is al geregistreerd.');
        $this->form_validation->set_message('matches', 'Beide wachtwoorden komen niet overeen.');
        $this->form_validation->set_message('min_length', 'Het veld %s moet minstens 8 karakters lang zijn.');

        if ($this->form_validation->run()) {
            //validation succeeded
            $this->add_user();
        } else {
            //validation failed
            $this->show();
        }
    }

    /**
     * Adds the user to the database as an inactive user.
     * 
     * @return boolean
     */
    function add_user() {
        $this->load->model('user_model');

        $result = $this->user_model->register_user(
                $this->input->post('username')
                , $this->input->post('firstname')
                , $this->input->post('lastname')
                , $this->input->post('email')
                , $this->input->post('password')
                , $this->input->post('address')
                , $this->input->post('city')
                , date('Y-m-d', strtotime($this->input->post('dob')))
                , $this->input->post('gender'));
        if ($result) {
            redirect('main');
        } else {
            show_error('Fout in het uitvoeren van de registratie. probeer het later opnieuw.<br/>
                        <a href="' . site_url() . '" >Terug naar de homepagina</a>');
        }
    }

}
