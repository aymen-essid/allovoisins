<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'UserModel');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    // User Registration
    public function registerPost() {
        $data = json_decode($this->input->raw_input_stream, true);

        // Validation
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => false, 'message' => $this->form_validation->error_array()]));
            return;
        }

        // Set User Data
        $this->UserModel->setFirstName($data['firstName']);
        $this->UserModel->setLastName($data['lastName']);
        $this->UserModel->setEmail($data['email']);
        $this->UserModel->setPhone($data['phone']);
        $this->UserModel->setPostalAddress($data['postalAddress']);
        $this->UserModel->setProfessionalStatus($data['professionalStatus']);
        $this->UserModel->setCreatedAt(date('Y-m-d H:i:s'));

        // Save User
        $this->UserModel->registerUser();

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'message' => 'User registered successfully']));
    }

    // Profile Modification
    public function profilePut($id) {
        $data = json_decode($this->input->raw_input_stream, true);

        // Validation
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        if (isset($data['email'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailCheck['.$id.']');
        }
        if (isset($data['phone'])) {
            $this->form_validation->set_rules('phone', 'Phone', 'required');
        }
        if (isset($data['postalAddress'])) {
            $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => false, 'message' => $this->form_validation->error_array()]));
            return;
        }

        // Load User
        $this->UserModel->loadUserById($id);

        // Set New Data
        $this->UserModel->setFirstName($data['firstName']);
        $this->UserModel->setLastName($data['lastName']);
        if (isset($data['email'])) {
            $this->UserModel->setEmail($data['email']);
        }
        if (isset($data['phone'])) {
            $this->UserModel->setPhone($data['phone']);
        }
        if (isset($data['postalAddress'])) {
            $this->UserModel->setPostalAddress($data['postalAddress']);
        }
        if (isset($data['professionalStatus'])) {
            $this->UserModel->setProfessionalStatus($data['professionalStatus']);
        }
        $this->UserModel->setUpdatedAt(date('Y-m-d H:i:s'));

        // Update User
        $this->UserModel->updateProfile();

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'message' => 'Profile updated successfully']));
    }

    // Custom validation callback to check email uniqueness excluding the current user
    public function emailCheck($email, $id) {
        $user = $this->UserModel->getUserByEmail($email);
        if ($user && $user['id'] != $id) {
            $this->form_validation->set_message('emailCheck', 'The {field} field must contain a unique value.');
            return FALSE;
        }
        return TRUE;
    }
}