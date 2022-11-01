<?php
class ImportDatabase extends Dbase
{

    public function index($tables = array("countries" => COUNTRY, "currencies" => CURRENCY))
    {
        foreach ($tables as $table => $file) {
            if ($fp = fopen($file, 'r')) {
                $i = 0;
                $columns = array();
                while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                    $values = array();
                    if ($i == 0) {
                        $columns = implode(" varchar(255),", $data);
                        $sql = "CREATE TABLE IF NOT EXISTS $table
                                (id int(11) NOT NULL AUTO_INCREMENT,
                                $columns varchar(255) DEFAULT NULL,
                                PRIMARY KEY  (id)) CHARSET=utf8";
                        $this->query($sql);
                        $this->query("TRUNCATE TABLE $table");
                        $columns = $data;
                    } else {
                        foreach ($data as $key => $row) {
                            $values[$columns[$key]] = "'" . $this->db_input($row) . "'";
                        }
                        if (!empty($values)) {
                            $keys = implode(",", array_keys($values));
                            $values = implode(",", $values);
                            $query = "insert into $table (" . $keys . ") values($values)";
                            $this->query($query);
                        }
                    }
                    $i++;
                }
                fclose($fp);
            } else {
                echo "$file is not opened. Please try again later";
            }
        }
    }
}
