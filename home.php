<?php
    session_start();
    // Überprüfe, ob das Logout-Attribut in POST gesetzt wurde
    if(isset($_POST['logout']))
    {
        // SESSION-Variableninhalt entfernen  
        session_unset();   
        // SESSION beenden   
        session_destroy();  
    }
    // Überprüfung, ob der User eingeloggt ist - falls nicht, zurück zum Login
    if(!($_SESSION))
    {  
        header('Location:index.php');  
    }
    // Überprüfe ob das Registrierungs-Attribut in POST gesetzt wurde
    if(isset($_POST['pwupdate']))    
    {
        // Speichere Daten aus POST-Übertragung   
        $username = $_POST['uid']; 
        $password = $_POST['password'];  
        $confirmPassword = $_POST['confirm_password'];
        // Stelle Passwordupdate-Funktionalität bereit
        require_once('dbUser.php');
        $UserObj = new dbUser(); 
        // Überprüfe, ob die eingegebenen Passwörter gleich sind
        if($password == $confirmPassword)
        { 
            $update = $UserObj->UserPWUpdate($uid, $password);  
            if($update)
            {  
                echo "<script>alert('Passwortwechsel erfolgreich!')</script>";  
            }
            else
            {  
                echo "<script>alert('Das hat nicht geklappt.')</script>";  
            }  
        } 
        else 
        {  
            echo "<script>alert('Die Passwörter sind nicht gleich.')</script>";        
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
        <title>SchützenApp - persönliche Übersicht</title>
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
                        Hallo <?php echo($_SESSION['username']); ?>, du befindest dich in deiner persönlichen Übersicht.<?php if($_SESSION['admin'] == '1') {echo ' <a href="admin.php">Hier geht es zum Adminbereich.</a>';} ?>
                        <br>
                        <br>
                        <!-- Ermittlung Strafenstand des eingeloggten Benutzer -->
                        <h4>Dein aktueller Strafenstand beträgt <?php
                        require_once('dbStrafe.php');
                        $StrafObjSum = new dbStrafe();
                        $strafeSum = $StrafObjSum->GetUserStrafenSum($_SESSION['uid']);
                        echo($strafeSum[0][0]);
                        ?>€.</h4>
                        <br>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Überblick über Strafen
                                </button>
                            </h2>
                            <br>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- Tabelle mit Strafenübersicht des eingeloggten Benutzers -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Höhe</th>
                                            <th scope="col">Begründung</th>
                                            <th scope="col">Zeitpunkt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once('dbStrafe.php');
                                            $StrafObj = new dbStrafe();
                                            $strafe = $StrafObj->GetUserStrafen($_SESSION['uid']);
                                            for ($i = 0; $i < count($strafe); $i++)
                                            {
                                                $j = $i + 1;
                                                echo '<tr>';
                                                echo '<th scope="row">'.$j.'</th>';
                                                echo '<td>'.$strafe[$i][amount].'€</td>';
                                                echo '<td>'.$strafe[$i][text].'</td>';
                                                echo '<td>'.date("d.m.Y, H:i", $strafe[$i][time]).'</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Passwort ändern / Logout
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- Passwort ändern-Formular (POST) -->
                                    <form name="pwupdate" method="post" action="">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Neues Passwort</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                                            <div id="passwordHelp" class="form-text">Hier kannst du ein neues Passwort festlegen.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword2" class="form-label">Passwort wiederholen</label>
                                            <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword2">
                                        </div>
                                        <button type="submit" name="pwupdate" class="btn btn-primary">Passwort ändern</button>
                                    </form>
                                    <br/>
                                    <!-- Logout-Funktionalität -->
                                    <form name="logout" method="post" action="">
                                        <button type="submit" name="logout" class="btn btn-primary">Ausloggen</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center;">
                        <h4>Zugbefehl / Programm</h4>
                    </div>
                    <br>
                    <div class="accordion" id="accordion2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                    Samstag, 27.08.2022
                                </button>
                            </h2>
                            <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5>Krönung S.M. Thomas I. Schommers Jr. & Fackelzug</h5>
                                    <strong>Treffpunkt: 14:00 Uhr</strong> zur Krönung, Gut Selikum 1, 41466 Neuss<br>
                                    <strong>gegen 18:00 Uhr</strong>, gemeinsame Fahrt zur Fackelbauhalle
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo">
                                    Sonntag, 28.08.2022
                                </button>
                            </h2>
                            <div id="collapseTwo2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5>Königsparade & Grenadierball</h5>
                                    <strong>Treffpunkt: 07:30 Uhr</strong> zum Frühstück bei Oberleutnant Thomas Schommers, Gut Selikum 1, 41466 Neuss<br>
                                    <strong>09:00 Uhr</strong>, Antreten zur Abnahme durch den Feldwebel<br>
                                    <strong>09:15 Uhr</strong>, Abfahrt mit dem Planwagen zum Antreten/Korpsaufmarsch<br>
                                    <strong>10:00 Uhr</strong>, Antreten zum Korpsaufmarsch des Neusser Grenadierkorps, Sebastianusstr./Spitze Büchel<br>
                                    <strong>10:10 Uhr</strong>, Abmarsch und anschließend Abnahme der Front auf dem Marktplatz<br>
                                    <strong>Königsparade zu Ehren S.M. Kurt I. Koenemann</strong><br>
                                    <strong>gegen 12:30 Uhr</strong>, Mittagessen im Zuglokal <i>Em Schwatte Päd</i><br>
                                    <strong>16:00 Uhr</strong>, Antreten zum Abmarsch, Sebastianusstr./Spitze Büchel<br>
                                    <strong>16:15 Uhr</strong>, Festumzug, anschließend geselliges Beisammensein auf der Festwiese<br>
                                    <strong>21:00 Uhr</strong>, Grenadierball im Festzelt<br>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree2" aria-expanded="false" aria-controls="collapseThree">
                                    Montag, 29.08.2022
                                </button>
                            </h2>
                            <div id="collapseThree2" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5>Festumzug & Jägerball</h5>
                                    <strong>Treffpunkt: 11:30 Uhr</strong> zum Frühschoppen im Zuglokal <i>Em Schwatte Päd</i><br>
                                    <strong>14:50 Uhr</strong>, Antreten zur Abnahme durch den Feldwebel<br>
                                    <strong>15:05 Uhr</strong>, Korpsaufmarsch des Neusser Grenadierkorps, Sebastianusstr./Spitze Büchel<br>
                                    <strong>15:15 Uhr</strong>, Festumzug, anschließend geselliges Beisammensein auf der Festwiese<br>
                                    <strong>19:15 Uhr</strong>, Antreten zum Festumzug, Löwendenkmal auf dem Marktplatz<br>
                                    <strong>19:30 Uhr</strong>, Rückzug des Regiments, anschließend Jägerball im Festzelt<br>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour2" aria-expanded="false" aria-controls="collapseFour">
                                    Dienstag, 30.08.2022
                                </button>
                            </h2>
                            <div id="collapseFour2" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5>Höffner-Biwak & Wackelzug</h5>
                                    <strong>Treffpunkt: 11:30 Uhr</strong> zum Biwak bei <i>Möbel Höffner</i><br>
                                    <strong>13:30 Uhr</strong>, Antreten zur Abnahme durch den Feldwebel<br>
                                    <strong>14:20 Uhr</strong>, Korpsaufmarsch des Neusser Grenadierkorps, Sebastianusstr./Spitze Büchel<br>
                                    <strong>14:30 Uhr</strong>, Festumzug, anschließend geselliges Beisammensein auf der Festwiese<br>
                                    <strong>18:15 Uhr</strong>, Königsvogelschießen<br>
                                    <strong>19:45 Uhr</strong>, Großer Zapfenstreich im Festzelt<br>
                                    <strong>20:15 Uhr</strong>, Antreten zum Festumzug, Löwendenkmal auf dem Marktplatz<br>
                                    <strong>20:30 Uhr</strong>, Festumzug/Wackelzug mit dem neuen Schützenkönig<br>
                                    <strong>23:00 Uhr</strong>, Zapfenstreich der Scheibenschützen auf dem Münsterplatz<br>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive2" aria-expanded="false" aria-controls="collapseFive">
                                    Rahmenprogramm zum Schützenfest
                                </button>
                            </h2>
                            <div id="collapseFive2" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5>Weitere Termine im Schützenjahr</h5>
                                    <strong>31.07., 17:00 Uhr</strong> Majorsehrenabend, Treffpunkt im Zuglokal <i>Em Schwatte Päd</i><br>
                                    <strong>13.08., 17:00 Uhr</strong> Königsehrenabend, Treffpunkt im Zuglokal <i>Em Schwatte Päd</i><br>
                                    <strong>21.08., 11:00 Uhr</strong> Promenadenkonzert vor dem <i>Weißen Haus</i><br>
                                    <strong>22.08., 17:30 Uhr</strong> Fackelrichtfest in der Zietschmannhalle<br>
                                    <strong>26.08., 19:00 Uhr</strong> Eröffnung Kirmesplatz, Treffpunkt Bierbude auf der <i>Rollmopsallee</i><br>
                                    <strong>31.08., 17:00 Uhr</strong> Kirmesausklang bei Oberleutnant Thomas Schommers<br>
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