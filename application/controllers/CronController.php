<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CronController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function deleteInactiveUsers(){
        // Calculate the date 36 months ago from today
        $dateThreshold = date('Y-m-d H:i:s', strtotime("-36 months"));
        $this->User_model->deleteInactiveUsers($dateThreshold);
    }
}