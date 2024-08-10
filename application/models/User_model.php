<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $postalAddress;
    private $professionalStatus;
    private $lastLogin;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPostalAddress()
    {
        return $this->postalAddress;
    }
    public function setPostalAddress($postalAddress)
    {
        $this->postalAddress = $postalAddress;
    }

    public function getProfessionalStatus()
    {
        return $this->professionalStatus;
    }
    public function setProfessionalStatus($professionalStatus)
    {
        $this->professionalStatus = $professionalStatus;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    // Database interactions
    public function registerUser()
    {
        $data = array(
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'postalAddress' => $this->getPostalAddress(),
            'professionalStatus' => $this->getProfessionalStatus()
        );

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
        if ($id === null) {
            return $this->db->get('users')->result_array();
        } else {
            return $this->db->get_where('users', ['id' => $id])->row_array();
        }
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
}
