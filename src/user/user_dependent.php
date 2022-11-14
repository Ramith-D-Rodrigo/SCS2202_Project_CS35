<?php
class UserDependent{
    private $ownerID;
    private $name;
    private $relationship;
    private $contactNo;

    public function __construct($name, $relationship, $contactNo){
        $this -> name = $name;
        $this -> relationship = $relationship;
        $this -> contactNo = $contactNo;
    }
    public function setOwner($owner){
        $this -> ownerID = $owner;
    }

    public function create_entry($database){
        $result = $database -> query(sprintf("INSERT INTO `user_dependent`
        (`owner_id`, 
        `name`, 
        `relationship`, 
        `contact_num`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s')", 
        $database -> real_escape_string($this->ownerID), 
        $database -> real_escape_string($this->name), 
        $database -> real_escape_string($this->relationship), 
        $database -> real_escape_string($this->contactNo)));

/*         if ($result === TRUE) {
            echo "New user dependent record created successfully<br>";
        }
        else{
            echo "Error\n";
        } */
        return $result;
    }
}


?>