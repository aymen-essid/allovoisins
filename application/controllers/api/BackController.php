<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BackController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    // Get single user
    public function getUser($id = null) {

        $users = $this->User_model->getUser($id);

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'data' => $users]));
    }

    // Get all users
    public function getUsers($page = null) {

        // Pagination configuration
        $config['base_url'] = base_url('users/page'); // URL for pagination links
        $config['total_rows'] = $this->User_model->countAllUsers(); // Total number of users
        $config['per_page'] = 10; // Number of users per page
        $config['uri_segment'] = 4; // Segment in the URL to get the page number
        $config['use_page_numbers'] = TRUE;

        // Initialize pagination
        $this->pagination->initialize($config);

        // Get current page number
        $page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;

        // Fetch users with limit
        $data['users'] = $this->User_model->getUsers($config['per_page'], $page);


        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'data' => $data]));
    }

    // Create a new user
    public function createUser() {
        $data = json_decode($this->input->raw_input_stream, true);

        // Validation
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');
        $this->form_validation->set_rules('professionalStatus', 'Professional Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => false, 'message' => $this->form_validation->error_array()]));
            return;
        }

        // Set User Data
        $this->User_model->setFirstName($data['firstName']);
        $this->User_model->setLastName($data['lastName']);
        $this->User_model->setEmail($data['email']);
        $this->User_model->setPhone($data['phone']);
        $this->User_model->setPostalAddress($data['postalAddress']);
        $this->User_model->setProfessionalStatus($data['professionalStatus']);
        $this->User_model->setCreatedAt(date('Y-m-d H:i:s'));

        // Save User
        $this->User_model->registerUser();

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'message' => 'User created successfully']));
    }

    // Update a user
    public function updateUser($id) {
        $data = json_decode($this->input->raw_input_stream, true);

        // Load User
        $this->User_model->loadUserById($id);

        // Set New Data
        $this->User_model->setFirstName($data['firstName']);
        $this->User_model->setLastName($data['lastName']);
        if (isset($data['email'])) {
            $this->User_model->setEmail($data['email']);
        }
        if (isset($data['phone'])) {
            $this->User_model->setPhone($data['phone']);
        }
        if (isset($data['postalAddress'])) {
            $this->User_model->setPostalAddress($data['postalAddress']);
        }
        if (isset($data['professionalStatus'])) {
            $this->User_model->setProfessionalStatus($data['professionalStatus']);
        }
        $this->User_model->setUpdatedAt(date('Y-m-d H:i:s'));

        // Update User
        $this->User_model->updateProfile();

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'message' => 'User updated successfully']));
    }

    // Delete a user
    public function deleteUser($id) {
        $this->User_model->deleteUser($id);

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => true, 'message' => 'User deleted successfully']));
    }

    // Custom validation callback to check email uniqueness excluding the current user
    public function emailCheck($email, $id) {
        $user = $this->User_model->getUserByEmail($email);
        if ($user && $user['id'] != $id) {
            $this->form_validation->set_message('emailCheck', 'The {field} field must contain a unique value.');
            return FALSE;
        }
        return TRUE;
    }
}