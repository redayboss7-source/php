<?php

namespace user;

class User3 {

    public $name = "Ridoy";
    public $designation = "Chairman";
    
    public function userInfo() {
        echo "Name : " . $this->name . '<br>';
        echo "Designation : " . $this->designation . '<br>';
    }
}