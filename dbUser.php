<?php 
session_start();
require_once 'config.php';
    class dbUser 
    {              
        function __construct() 
        {  
        }
        function __destruct() 
        {  
        }
        public function GetAllUsers()
        {
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);   
            // Funktion, die alle Nutzer inkl. ID zurückgibt
            $stmt = $pdo->query('SELECT id, username FROM users');
            return $stmt->fetchAll();
        }
        public function UserRegister($username, $emailid, $password, $admin)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD); 
            // Funktion, um einen neuen Nutzer zu registrieren
            $passwordhash = hash("sha512", $password);
            $stmt = $pdo->prepare('INSERT INTO users (username, emailid, password, isadmin) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $emailid, $passwordhash, $admin]);
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
        /**public function UserUpdate($uid, $username, $emailid, $admin)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD); 
            // Funktion, um die persönlichen Details eines Nutzers zu aktualisieren
            $stmt = $pdo->prepare('UPDATE users SET username = ?, emailid = ?, isadmin = ? WHERE id = ?');
            $stmt->execute([$username, $emailid, $admin, $uid]);   
            //return $qr;      
        }*/
        public function UserPWUpdate($uid, $password)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD); 
            // Funktion, um das Passwort eines Nutzers zu aktualisieren
            $passwordhash = hash("sha512", $password);
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->execute([$passwordhash, $uid]); 
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
        public function UserExists($emailid)
        {  
            // Datenbankverbindung herstellen
            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD); 
            // Funktion, um zu überprüfen, ob ein Nutzer bereits existiert - Check auf Mailadresse
            $stmt = $pdo->prepare('SELECT * FROM users WHERE emailid = ?');
            $stmt->execute([$emailid]);
            $result = $stmt->fetchAll();
            $anzahl_user = count($result); 
            if($anzahl_user > 0)
            {  
                return true;  
            } 
            else 
            {  
                return false;  
            }  
        }  
    }  
?>