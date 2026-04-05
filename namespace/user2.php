<?php

namespace UserTwo;

class User {

public $name = "Sumi";
public $designation = "Co-Founder";
    public function userInfo() {
        echo "Name : " . $this->name . '<br>';
        echo "Designation : " . $this->designation . '<br>';
    }
}