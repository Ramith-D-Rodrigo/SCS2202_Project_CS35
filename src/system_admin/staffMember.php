<?php

interface StaffMember {

    public function login($username, $password);
    public function register($database);
    public function setDetails($fName='', $lName='', $email='', $contactNo='', $dob='', $gender='', $uid='', $username='', $password='', $brID = '');
    
}
?>