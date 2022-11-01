<?php
class Dbase
{
    public $con;

    public function __construct($host = DB_HOST, $username = DB_USER, $password = DB_PASSWORD, $db = DB_DATABASE)
    {
        $this->con = new mysqli($host, $username, $password);
        if ($this->con->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->con->connect_error;
            exit();
        }
        $this->query("CREATE DATABASE IF NOT EXISTS $db");
        mysqli_select_db($this->con, $db);
    }

    public function __destruct()
    {
        $this->con->close();
    }

    function insert($tableName, $params)
    {
        if (is_array($params) && count($params) > 0) {
            $values = implode("','", array_values($params));
            $keys = implode(",", array_keys($params));
            $query = "INSERT INTO " . $tableName . " ($keys) VALUES ('$values')";
            return $this->query($query);
        }
    }

    function batch_insert($tableName, $params)
    {
        if (is_array($params) && count($params) > 0) {
            $keys = '';
            foreach ($params as $row) {
                $columnvalue = array();
                foreach ($row as $key => $val) {
                    $columnvalue[$key] = "'" . $this->db_input($val) . "'";
                }
                $values[] = "(" . implode(",", $columnvalue) . ")";
                if (empty($keys)) {
                    $keys = implode(",", array_keys($row));
                }
            }
            $values = implode(", ", $values);
            $query = "INSERT INTO " . $tableName . " ($keys) VALUES $values";
            return $this->query($query);
        }
    }

    function escape_string($string)
    {
        return mysqli_real_escape_string($this->con, $string);
    }

    function query($query)
    {
        return mysqli_query($this->con, $query);
    }

    function num_rows($res)
    {
        return mysqli_num_rows($res);
    }

    function fetch_array_assoc($res)
    {
        return mysqli_fetch_array($res, MYSQLI_ASSOC);
    }

    function db_input($string)
    {
        if (function_exists('mysqli_real_escape_string')) {
            return mysqli_real_escape_string($this->con, stripslashes($string));
        } elseif (function_exists('mysqli_escape_string')) {
            return mysqli_escape_string($this->con, $string);
        }
        return $string;
    }
}
