<?php

/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2/12/2019
 * Time: 5:27 PM
 */
main::start("MiniProject1.csv");

class main {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::returntable($records);

    }

}

class html
{

    public static function generatetable($records)
    {

        $count = 0;

        foreach ($records as $record) {

            if ($count == 0) {

                $array = $record->returnarray();
                $fields = array_keys($array);
                $values = array_values($array);
                print_r($fields);
                print_r($values);

            } else {
                $array = $record->returnarray();
                $values = array_values($array);

                print_r($values);
            }
            $count++;

        }

    }

    public static function returntable($table){
        echo "<html><body><table class='table table-striped'>\n\n";
        $file = fopen("MiniProject1.csv", "r");
        while (($record = fgetcsv($file)) !== false) {
            echo "<tr>";
            foreach ($record as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>\n";
        }
        fclose($file);
        echo "\n</table></body></html>";
    }


}

class csv
{

    static public function getRecords($filename){

        $file = fopen($filename, "r");

        $fieldnames = array();

        $count = 0;

        while(! feof($file))
        {

            $record = fgetcsv($file);
            if($count== 0) {
                $fieldnames = $record;
            } else {
                $records[] = recordfactory::create($fieldnames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;

    }

}

class record{

    public function __construct(Array $fieldnames = null, $values = null)
    {
        $record = array_combine($fieldnames, $values);

        foreach($record as $property => $value) {
            $this->createproperty($property, $value);
        }

    }

    public function returnarray() {
        $array = (array) $this;
        return $array;

    }

    public function createProperty($name = 'name', $value = 'Mike') {

        $this->{$name} = $value;

    }
}

class recordfactory {

    public static function create(Array $fieldnames = null, Array $values = null){


        $record = new record($fieldnames, $values);

        return $record;

    }
}
?>
