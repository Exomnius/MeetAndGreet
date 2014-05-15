<?php

/**
 * @author Cornel Janssen   <janssen_cornel@hotmail.com>
 * @author Nick Thoelen     <nickthoelen@gmail.com>
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This class manages the user login.
 */
class Login extends CI_Controller {

    /**
     * Creates an instance of the class.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Redirects to the show_login() function.
     */
    public function index() {
        $this->show_login();
    }

    /**
     * Displays the login form.
     */
    public function show_login() {
        $header_data['title'] = 'Login';
        $header_data['active'] = 'login';

        $form_open = form_open('login/login_validation', array('id' => 'frmLogIn', 'class' => 'form-signin col-lg-4 col-lg-offset-4', 'role' => 'form', 'novalidate' => 'novalidate'));
        $validation_errors = validation_errors();
        $form_close = form_close();

        $username = set_value('username') ? set_value('username') : $this->input->cookie('username');

        $data = array('username' => $username
            , 'form_open' => $form_open
            , 'validation_errors' => $validation_errors
            , 'form_close' => $form_close);

        $data['forgot'] = site_url('login/forgotpw');

        $this->parser->show('pages/login_view', $data, $header_data);
    }

    /**
     * Validates the login information.
     */
    public function login_validation() {
        $this->CI = & get_instance();
        $this->CI->load->library('form_validation');

        if ($this->input->post('remember') == 'remember-me') {
            $this->input->set_cookie('username', $this->input->post('username'), 60 * 60 * 24 * 100);
        } else {
            $this->input->set_cookie('username', '', 0);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $this->form_validation->set_rules('username', 'Gebruikersnaam', 'trim|required|alpha_numeric|xss_clean');
        $this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required|md5|xss_clean|callback_validate_credentials');

        $this->form_validation->set_message('validate_credentials', 'Verkeerde gebruikersnaam en/of wachtwoord.');
        $this->form_validation->set_message('required', 'Gelieve het %s veld in te vullen.');
        $this->form_validation->set_message('alpha_numeric', 'Gelieve alleen alpha numerieke karakters te gebruiken.');

        if ($this->form_validation->run()) {
            //validation succesfull
            redirect('main', 'refresh');
        } else {
            //validation failed
            $this->show_login();
        }
    }

    /**
     * Checks if the username and password are correct.
     * 
     * @return boolean
     */
    public function validate_credentials() {
        $this->load->model('user_model');

        $user = $this->user_model->validate_credentials($this->input->post('username'), $this->input->post('password'));

        if ($user) {
            //create session
            $userData = array(
                'id' => $user->userId,
                'username' => $user->username,
                'logged_in' => true,
            );
            $this->session->set_userdata($userData);

            redirect('main');
        } else {
            return false;
        }
    }

    public function forgotpw() {
        $header_data['title'] = 'Login';
        $footer_data['active'] = 'login';

        $data['form_open'] = form_open('login/validate_pass_reset', array('id' => 'frmPassReset', 'class' => 'form-signin col-lg-4 col-lg-offset-4', 'role' => 'form', 'novalidate' => 'novalidate'));
        $data['validation_errors'] = validation_errors();
        $data['form_close'] = form_close();

        $data['loginlink'] = site_url('login');

        $this->parser->show('pages/pwrecovery_view', $data, $header_data, $footer_data);
    }

    /**
     * validates the data entered in the form created by the forgotpw() function.
     */
    public function validate_pass_reset() {
        $this->CI = & get_instance();
        $this->CI->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $this->form_validation->set_rules('username', 'Gebruikersnaam', 'trim|required|alpha_numeric|xss_clean');
        $this->form_validation->set_rules('email', 'E-mailadres', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('studnr', 'Studentennummer', 'trim|required|numeric|xss_clean');

        $this->form_validation->set_message('required', 'Gelieve het veld %s in te vullen.');
        $this->form_validation->set_message('alpha_numeric', 'Gelieve alleen alpha numerieke karakters te gebruiken voor het veld %s.');

        if ($this->form_validation->run()) {
            $this->checkuser();
        } else {
            //validation failed
            $this->forgotpw();
        }
    }

    /**
     * Checks if the user data exists, then either returns the user to the main page or sends the data on to the resetpassword function.
     */
    public function checkuser() {
        $this->load->model('user_model');

        $user = $this->user_model->get_user_reset_pw($this->input->post('email'), $this->input->post('username'), $this->input->post('studnr'));
        if ($user) {
            $this->resetpassword($user);
        } else {
            $error = 'Uw gegevens bestaan niet in de databank ';
            redirect('/index.php/login/forget?error=' . $error, 'refresh');
        }
    }

    /**
     * Handeless the mailing and generating of the new password for the user.
     * @param type $user
     */
    public function resetpassword($user) {
        $this->load->model('user_model');

        date_default_timezone_set('GMT');
        $this->load->helper('string');
        $password = random_string('alnum', 16);
        var_dump($user);
        echo $password;
        if ($this->user_model->reset_pwt($user->userid, $password)) {
            $this->load->library('email');
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "ssl://smtp.googlemail.com";
            $config['smtp_port'] = "465";
            $config['smtp_user'] = "corneljanssensmtp@gmail.com"; //also valid for Google Apps Accounts
            $config['smtp_pass'] = "hexion01";
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";

            $this->email->initialize($config);

            $this->email->from('hexion@pxl.com', 'Hexion');
            $this->email->to($user->email);
            $this->email->subject('Reset van uw wachtwoord');
            $this->email->message('Geachte ' . $user->username
                    . '<br/></br> U heeft een nieuw wachtwoord aangevraagd,<br/>'
                    . "Om dit wachtwoord te bevestigen gelieve in te loggen met het wachtwoord: $password<br/>
                     ,dit wachtwoord vervalt over 1 uur als u geen actie onderneemt.<br/>"
                    . anchor('login/', 'Login op hexion') . '<br/><br/>'
                    . 'Met vriendelijke groeten, <br/> Studentenvereniging Hexion');

            if (!$this->email->send()) {
                show_error('Er is een fout opgetreden bij het versturen van de email. Gelieve een systeemadministrator te contacteren of probeer het later opnieuw.</br></br><a href="'
                        . site_url('main') . '">terug naar de homepagina</a>');
            } else {
                redirect(site_url('main'));
            }
        } else {
            show_error('Er is een fout opgetreden bij het inlezen van de data. Gelieve een systeemadministrator te contacteren of probeer het later opnieuw.</br></br><a href="'
                    . site_url('main') . '">terug naar de homepagina</a>');
        }
    }

}
