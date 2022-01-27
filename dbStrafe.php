<?php   
session_start();
require_once 'config.php';
    class dbStrafe
    {              
        function __construct() 
        {          
        }
        function __destruct() 
        {  
        }
        public function AddStrafe($userid, $text, $amount)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
            // Funktion, um eine Strafe hinzuzufügen
            $time = time();
            $stmt = $pdo->prepare('INSERT INTO strafen (userid, text, time, amount) VALUES (?, ?, ?, ?)');
            $stmt->execute([$userid, $text, $time, $amount]);
            $arr = $stmt->errorInfo();
            if ($arr[0] == '00000')
            {
                return true; 
            }
            else
            {
                return false;
            }         
        }
        public function GetUserStrafen($uid)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
            // Funktion, um die für den Benutzer hinterlegten Strafen abzurufen
            $stmt = $pdo->prepare('SELECT * FROM strafen WHERE userid = ?');
            $stmt->execute([$uid]);
            return $stmt->fetchAll();
        }
        public function GetUserStrafenSum($uid)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
            // Funktion, um die für den Benutzer hinterlegten Strafen abzurufen
            $stmt = $pdo->prepare('SELECT SUM(amount) FROM strafen WHERE userid = ?');
            $stmt->execute([$uid]);
            return $stmt->fetchAll();
        }
        public function GetAllUsersStrafenSum()
        {
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
            // Funktion, um die für den Benutzer hinterlegten Strafen abzurufen
            $stmt = $pdo->prepare('SELECT username,SUM(amount) FROM users INNER JOIN strafen ON users.id = strafen.userid GROUP BY strafen.userid ORDER BY SUM(amount) DESC');
            $stmt->execute();
            return $stmt->fetchAll();
        } 
    }  
?>