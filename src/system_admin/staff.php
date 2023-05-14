<?php

require_once("../../src/receptionist/receptionist.php");
require_once("../../src/manager/manager.php");

class Staff{

    public function getStaffMember($staffRole){
        if($staffRole ==='receptionist'){
            return new Receptionist();
        }else if($staffRole === 'manager'){
            return new Manager();
        }
    }

}
?>