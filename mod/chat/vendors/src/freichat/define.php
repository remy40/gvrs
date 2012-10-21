<?php


//static $connected = false;

class DB_conn {
    
    public static $connected = false;
    public static $connection;
    public static $driver;
    public static $debug;
    
    
    public static function get_connection($host,$client_db_name,$username,$password){
        
        if(self::$connected == true){
            return self::$connection;
        }
        
        
         try {
             self::$connection = new PDO('mysql:host=' . $host . ';dbname=' . $client_db_name, $username, $password, array(
                        PDO::ATTR_PERSISTENT => true
                    ));
        } catch (PDOException $e) {
            self::freichat_debug("unable to connect to database. Error : " . $e->getMessage());
            die();
        }
         
        self::freichat_debug("connected to database successfully");
        self::$connection->exec("SET CHARACTER SET utf8");
        self::$connection->exec("SET NAMES utf8");
        
        self::$connected=true;
        return self::$connection;

    }
    
        private static function freichat_debug($message) {
            if(self::$debug == true){
                $dbgfile = fopen("../freixlog.log", "a");
                fwrite($dbgfile, "\n" . date("F j, Y, g:i a") . ": " . $message . "\n");
            }
    }
    

    
}