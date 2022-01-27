<?php
    session_start();
    // Überprüfung, ob der User eingeloggt ist - falls nicht, zurück zum Login
    if(!($_SESSION))
    {  
        header('Location:index.php');  
    }
    // Überprüfung, ob der User wirklich Admin ist - falls nicht, zurück auf die Übersichtsseite
    if($_SESSION['admin'] == '0')
    {
        header('Location:home.php');
    }
    // Überprüfe ob das Registrierungs-Attribut in POST gesetzt wurde
    if(isset($_POST['register']))    
    {
        // Speichere Daten aus POST-Übertragung   
        $username = $_POST['username'];  
        $emailid = $_POST['emailid'];  
        $password = $_POST['password'];  
        $confirmPassword = $_POST['confirm_password'];
        if ($_POST['isadmin'] == 'on')
        {
            $isadmin = '1';
        }
        else
        {
            $isadmin = '0';
        }
        // Stelle Registrierungs-Funktionalität bereit
        require_once('dbUser.php');
        $UserObj = new dbUser(); 
        // Überprüfe, ob die eingegebenen Passwörter gleich sind
        if($password == $confirmPassword)
        {
            // Überprüfe, ob der User bereits angelegt ist
            $email = $UserObj->UserExists($emailid);  
            if(!$email)
            {  
                $register = $UserObj->UserRegister($username, $emailid, $password, $isadmin);  
                if($register)
                {  
                    echo "<script>alert('Registrierung erfolgreich!')</script>";  
                }
                else
                {  
                    echo "<script>alert('Das hat nicht geklappt.')</script>";  
                }  
            } 
            else 
            {  
                echo "<script>alert('Die Mailadresse existiert schon.')</script>";  
            }
        } 
        else 
        {  
            echo "<script>alert('Die Passwörter sind nicht gleich.')</script>";        
        }  
    }
    if(isset($_POST['strafe']))    
    {
        // Speichere Daten aus POST-Übertragung   
        $strafenhoehe = $_POST['hoehe'];  
        $begruendung = $_POST['begruendung'];  
        $id = $_POST['uid'];
        // printf('Debug AdminPage<br>');
        // Stelle Strafen-Funktionalität bereit
        require_once('dbStrafe.php');
        $UserObj = new dbStrafe();
        $erfolg = $UserObj->AddStrafe($id, $begruendung, $strafenhoehe);  
        if($erfolg)
        {  
            echo "<script>alert('Strafe erfolgreich verteilt!')</script>";  
        }
        else
        {  
            echo "<script>alert('Das hat nicht geklappt.')</script>";  
        } 
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>SchützenApp - Administrationsbereich</title>
        <!-- Durch Buttons Vorbelegung der Strafen auslösen -->
        <script>
            function changeValues(hoehe, begr) 
            {
                var elem1 = document.getElementById("begr");
                elem1.value = begr;
                var elem2 = document.getElementById("hoehe");
                elem2.value = hoehe;
            }
        </script>
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
                        Hallo <?php echo($_SESSION['username']); ?>, du befindest dich im Administrationsbereich. <a href="home.php">Zurück zu deiner persönlichen Übersicht.</a>
                    </div>
                    <br/>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Strafen verwalten
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form name="strafe" method="post" action="">
                                        <select class="form-select" name="uid" aria-label="Default select example">
                                            <?php
                                                // Gib alle Benutzer als Dropdown aus
                                                require_once('dbUser.php');
                                                $GetUserObj = new dbUser();
                                                $allUsers = $GetUserObj->GetAllUsers();
                                                for ($i = 0; $i < count($allUsers); $i++)
                                                {   
                                                    echo '<option value="'.$allUsers[$i][id].'">'.$allUsers[$i][username].'</option>';
                                                }
                                            ?>    
                                        </select>
                                        <br/>
                                        <!-- Buttons zur Vorbelegung der Felder -->
                                        <button type="button" onclick="changeValues('2', 'Uniform unvollständig');" class="btn btn-primary">Uniform unvollständig (2€)</button>
                                        <button type="button" onclick="changeValues('5', 'Verpasstes Antreten');" class="btn btn-primary">Verpasstes Antreten (5€)</button>
                                        <button type="button" onclick="changeValues('15', 'Verpasster Festumzug');" class="btn btn-primary">Verpasster Festumzug (15€)</button>
                                        <button type="button" onclick="changeValues('25', 'Verpasste Parade');" class="btn btn-primary">Verpasste Parade (25€)</button>
                                        <br/>
                                        <br/>
                                        <!-- Formular zur Strafen-Vergabe -->
                                        <label class="form-label">Individuelle Strafe festlegen</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="hoehe" id="hoehe" class="form-control" placeholder="Strafe" aria-label="Strafe">
                                                    <span class="input-group-text">,00 €</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="begruendung" id="begr" class="form-control" placeholder="Begründung" aria-label="Begründung">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" name="strafe" class="btn btn-primary">Strafe festlegen</button>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Zugsau ermitteln / Strafenübersicht
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- Tabelle mit Strafenübersicht -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Höhe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Ermittle Benutzer gruppiert und summiert nach Strafenhöhe
                                            require_once('dbStrafe.php');
                                            $StrafObj = new dbStrafe();
                                            $strafe = $StrafObj->GetAllUsersStrafenSum();
                                            for ($i = 0; $i < count($strafe); $i++)
                                            {
                                                $j = $i + 1;
                                                echo '<tr>';
                                                echo '<th scope="row">'.$j.'</th>';
                                                echo '<td>'.$strafe[$i][username].'</td>';
                                                echo '<td>'.$strafe[$i]["SUM(amount)"].'€</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Neues Zugmitglied anlegen
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- Formular für Benutzeranlage -->
                                    <form name="register" method="post" action="">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Name</label>
                                            <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp">
                                            <div id="usernameHelp" class="form-text">Bitte gib hier den vollständigen Namen des Zugmitgliedes an.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">E-Mail-Adresse</label>
                                            <input type="email" name="emailid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            <div id="emailHelp" class="form-text">Die Mailadresse des Zugmitgliedes dient zur eindeutigen Identifizierung.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Passwort</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword2" class="form-label">Passwort wiederholen</label>
                                            <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword2">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="isadmin" class="form-check-input" id="isadmin">
                                            <label class="form-check-label" for="exampleCheck1">Ist das Zugmitglied ein Administrator?</label>
                                        </div>
                                        <button type="submit" name="register" class="btn btn-primary">Daten übermitteln</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                </div>
            </div>
        </div>
        <!-- Bootstrap Bundle mit Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>