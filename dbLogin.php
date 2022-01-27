<?php   
session_start();
require_once 'config.php';
    class dbLogin
    {             
        public function __construct() 
        {  
        }
        function __destruct() 
        {       
        }
        public function Login($emailid, $password)
        {
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
            // Funktion, um einen neuen Nutzer einzuloggen
            $passwordhash = hash("sha512", $password);
            $stmt = $pdo->prepare('SELECT * FROM users WHERE emailid = ? AND password = ?');
            $stmt->execute([$emailid, $passwordhash]);
            $result = $stmt->fetchAll();
            // Ermittle Anzahl der matchenden User
            $anzahl_user = count($result);      
            if ($anzahl_user == 1)
            {   
                // Hier werden die Benutzerdetails in der Session-Variable gespeichert
                $_SESSION['login'] = true;  
                $_SESSION['uid'] = $result[0]['id'];  
                $_SESSION['username'] = $result[0]['username'];  
                $_SESSION['email'] = $result[0]['emailid'];
                $_SESSION['admin'] = $result[0]['isadmin'];
                return true;  
            }  
            else  
            {
                // Falls die Kombination aus Mailadresse und Passwort falsch war  
                return false;  
            } 
        }
    }  
?>