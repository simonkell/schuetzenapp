<?php
    session_start();
    // Überprüfe ob das Login-Attribut in POST gesetzt wurde
    if(isset($_POST['login']))
    {  
        // Speichere Daten aus POST-Übertragung
        $emailid = $_POST['emailid'];  
        $password = $_POST['password'];
        // Stelle Login-Funktionalität bereit
        require_once('dbLogin.php');
        $LoginObj = new dbLogin();
        $user = $LoginObj->Login($emailid, $password);
        if ($user) 
        {  
            // War der Login erfolgreich, springe auf die Übersichtsseite 
            header('location:home.php');
        } 
        else 
        {  
            // War der Login nicht erfolgreich, gebe Fehlermeldung aus 
            echo "<script>alert('Mail und/oder Passwort falsch.')</script>";  
        }  
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Meta Tags für Bootstrap -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS - eingebunden über CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>SchützenApp - Login</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                </div>
                <div class="col-10">
                    <div style="text-align: center;">    
                        <img src="logo_globetrotters.jpg" width="100px">
                        <h2>SchützenApp - Nüss Globetrotters 2014</h2>
                    </div>
                    <!-- Login-Formular (POST) -->
                    <form name="login" method="post" action="">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">E-Mail-Adresse</label>
                            <input type="email" name="emailid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Bitte gib die Mailadresse und das Passwort an, die dir von der Zugführung mitgeteilt wurden.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Passwort</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Einloggen</button>
                    </form>
                </div>
                <div class="col">
                </div>
            </div>
        </div>
        <!-- Bootstrap Bundle mit Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>