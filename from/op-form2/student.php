<?php

class Student {
    private $id;
    private $name;
    private $batch;

    public static $file_location = "data_store.txt";

    
    function __construct($id, $name, $batch) {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }

  
    public function data_store() {
        return $this->id . "," . $this->name . "," . $this->batch . PHP_EOL;
    }

    public function dstore() {
        file_put_contents(self::$file_location, $this->data_store(), FILE_APPEND);
    }


    public static function result() {

        echo "<h3 style='text-align:center;'>Student List</h3>";

        if (file_exists(self::$file_location) && filesize(self::$file_location) > 0) {

            $students = file(self::$file_location);

            echo "
            <table style='
                width:80%;
                margin:auto;
                border-collapse:collapse;
                font-family:Arial;
                text-align:center;
            ' border='1' cellpadding='10'>
            
            <tr style='background:#007bff; color:white;'>
                <th>ID</th>
                <th>NAME</th>
                <th>BATCH</th>
            </tr>
            ";

            foreach ($students as $student) {

                list($id, $name, $batch) = explode(",", trim($student));

                echo "
                <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$batch</td>
                </tr>
                ";
            }

            echo "</table>";

        } else {
            echo "<p style='text-align:center; color:red;'>No student data found!</p>";
        }
    }
}

?>