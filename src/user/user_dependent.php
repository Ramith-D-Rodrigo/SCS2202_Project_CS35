<?php
class UserDependent{
    private $ownerID;
    private $name;
    private $relationship;
    private $contactNum;

    public function __construct($name, $relationship, $contactNo){
        $this -> name = $name;
        $this -> relationship = $relationship;
        $this -> contactNum = $contactNo;
    }
    public function setOwner($owner){
        $this -> ownerID = $owner;
    }

    public function create_entry($database){
        $result = $database -> query(sprintf("INSERT INTO `user_dependent`
        (`ownerID`, 
        `name`, 
        `relationship`, 
        `contactNum`) 
        VALUES 
        ('%s','%s','%s','%s')", 
        $database -> real_escape_string($this->ownerID), 
        $database -> real_escape_string($this->name), 
        $database -> real_escape_string($this->relationship), 
        $database -> real_escape_string($this->contactNum)));

/*         if ($result === TRUE) {
            echo "New user dependent record created successfully<br>";
        }
        else{
            echo "Error\n";
        } */
        return $result;
    }

    public function delete_entry($database){
        $result = $database -> query(sprintf("DELETE FROM `user_dependent` 
        WHERE `ownerID` = '%s' 
        AND `name` = '%s' 
        AND `relationship` = '%s' 
        AND `contactNum` = '%s'", 
        $database -> real_escape_string($this->ownerID), 
        $database -> real_escape_string($this->name), 
        $database -> real_escape_string($this->relationship), 
        $database -> real_escape_string($this->contactNum)));

        return $result;
    }
}


?>