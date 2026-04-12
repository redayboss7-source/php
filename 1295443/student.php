<?php

class Student {
    private $id;
    private $name;
    private $batch;

    public static $file = "data.txt";


    public function __construct($id = "", $name = "", $batch = "") {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }

    public function save() {
        $data = $this->id . "," . $this->name . "," . $this->batch . PHP_EOL;
        file_put_contents(self::$file, $data, FILE_APPEND);
    }


    public function result($search_id) {

        if (file_exists(self::$file)) {

            $students = file(self::$file);

            foreach ($students as $student) {

                list($id, $name, $batch) = explode(",", trim($student));

                if ($id == $search_id) {
                    echo "<h3 style='color:green;'>Result Found</h3>";
                    echo "ID: $id <br>";
                    echo "Name: $name <br>";
                    echo "Batch: $batch <br>";
                    return;
                }
            }

            echo "<h3 style='color:red;'>Student not found!</h3>";

        } else {
            echo "<h3>No data file found!</h3>";
        }
    }
}

?>