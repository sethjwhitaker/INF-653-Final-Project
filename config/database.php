<?php

class Database {

    public function connect() {
        try {
            $url = getenv('JAWSDB_URL');
            if(!empty($url)) {
                $dbparts = parse_url($url);
    
                $hostname = $dbparts['host'];
                $username = $dbparts['user'];
                $password = $dbparts['pass'];
                $database = ltrim($dbparts['path'],'/');
                return new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            } else {
                $dsn = "mysql:host=localhost;dbname=quotesdb";
                $username = "root";
                return new PDO($dsn, $username);
            }
            
        } catch (PDOException $e) {
            $error_message = "Database Error: ";
            $error_message .= $e->getMessage();
            include("view/error.php");
            exit();
        }

    }
}
    


    
  