<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $postalAddress;
    private string $professionalStatus;
    private DateTime $lastLogin;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->database();
    }

    

    // Database interactions
    public function registerUser($data)
    {
        return $this->db->insert('users', $data);
    }

    public function getUserByEmail($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function loadUserById($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->row_array();
        if ($user) {
            $this->setId($user['id']);
            $this->setFirstName($user['firstName']);
            $this->setLastName($user['lastName']);
            $this->setEmail($user['email']);
            $this->setPhone($user['phone']);
            $this->setPostalAddress($user['postalAddress']);
            $this->setProfessionalStatus($user['professionalStatus']);
            $this->setLastLogin($user['lastLogin']);
        }
        return $this;
    }

    public function updateProfile()
    {
        $data = array(
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'postalAddress' => $this->getPostalAddress(),
            'professionalStatus' => $this->getProfessionalStatus(),
            'lastLogin' => $this->getLastLogin()
        );

        $this->db->where('id', $this->getId());
        return $this->db->update('users', $data);
    }

    public function countAllUsers() {
        return $this->db->count_all('users');
    }

    public function getUser($id = null)
    {
        if ($id === null) 
            return $this->db->get('users')->result_array();
        
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    public function getUsers($limit, $start = 0) {
        if($start > 0){
            $start *= $limit ;
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('users');
 
        return $query->result();
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    public function deleteInactiveUsers($dateThreshold) { 
        
        $this->db->where('lastLogin <', $dateThreshold);
        $this->db->delete('users');

        // Return the number of affected rows
        return $this->db->affected_rows();
    }
    
    public function validateUser(array $data)
    {
        // Validation
        $this->form_validation->set_data($data);
        
        if (isset($data['firstName'])) {
            $this->form_validation->set_rules('firstName', 'First Name', 'required');
        }
        if (isset($data['lastName'])) {
            $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        }
        if (isset($data['email'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailCheck['.$id.']');
        }
        if (isset($data['phone'])) {
            $this->form_validation->set_rules('phone', 'Phone', 'required');
        }
        if (isset($data['postalAddress'])) {
            $this->form_validation->set_rules('postalAddress', 'Postal Address', 'required');
        }
        if (isset($data['professionalStatus'])) {
            $this->form_validation->set_rules('professionalStatus', 'Professional Status', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => false, 'message' => $this->form_validation->error_array()]));
            return false;
        }

        return $this->form_validation;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of postalAddress
     */ 
    public function getPostalAddress()
    {
        return $this->postalAddress;
    }

    /**
     * Set the value of postalAddress
     *
     * @return  self
     */ 
    public function setPostalAddress($postalAddress)
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    /**
     * Get the value of professionalStatus
     */ 
    public function getProfessionalStatus()
    {
        return $this->professionalStatus;
    }

    /**
     * Set the value of professionalStatus
     *
     * @return  self
     */ 
    public function setProfessionalStatus($professionalStatus)
    {
        $this->professionalStatus = $professionalStatus;

        return $this;
    }

    /**
     * Get the value of lastLogin
     */ 
    public function getLastLogin()
    {
        return $this->lastLogin->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of lastLogin
     *
     * @return  self
     */ 
    public function setLastLogin(string $lastLogin)
    {
        $lastLogin = new DateTime($lastLogin);

        $this->lastLogin = $lastLogin;

        return $this;
    }
}
