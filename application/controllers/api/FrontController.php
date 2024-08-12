<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    // Show registration form and handle form submission
    public function registerUser() {
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');
        $this->form_validation->set_rules('professionalStatus', 'Professional Status', 'required');

        if ($this->form_validation->run() == TRUE) {
            
            $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'postalAddress' => $this->input->post('postalAddress'),
                'professionalStatus' => $this->input->post('professionalStatus'),
                'lastLogin' => date('Y-m-d H:i:s')
            );

            $this->User_model->registerUser($data);
        }

        $this->load->view('user_register');
    }

    // Show update form and handle form submission
    public function updateProfile($id) {
        $user = $this->User_model->loadUserById($id);


        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');
        $this->form_validation->set_rules('professionalStatus', 'Professional Status', 'required');
        
        if ($this->form_validation->run() == TRUE) {
            
            $user->setFirstName($this->input->post('firstName'));
            $user->setLastName($this->input->post('lastName'));
            $user->setEmail($this->input->post('email'));
            $user->setPhone($this->input->post('phone'));
            $user->setPostalAddress($this->input->post('postalAddress'));
            $user->setProfessionalStatus($this->input->post('professionalStatus'));

            $this->User_model->updateProfile($id, $user);
        }

        $data['user'] = $user;
        $this->load->view('user_profile', $data);
    }

}