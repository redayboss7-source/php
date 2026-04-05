<?php

namespace UserOne;

class User {

public $name = "Meem";
public $designation = "Ceo";
    public function userInfo() {
        echo "Name : " . $this->name . '<br>';
        echo "Designation : " . $this->designation . '<br>';
    }
}