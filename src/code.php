<html>

    <body>
    
        <?php
            // Ottaa loginin muistiin toisesta tiedostosta (tietoturvasyistä)
            include "login.php";

            // Kokeilee toimiiko yhteys annetuilla tiedoilla - antaa virheilmoituksen jos ei toimi
            //phpinfo();
            try {
                $conn = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage()."<br>";
            }
        
            // Asettaa assosiatiiviseen arrayhyn booleanin "true" henkilöille jotka olivat paikalla
            $osallistujat = array("jere" => "false", "noora" => "false", "otso" => "false", "sami" => "false", "elias" => "false");
            if (!empty($_POST["jere"])) { 
                $osallistujat["jere"] = true;
            }
            if (!empty($_POST["noora"])) { 
                $osallistujat["noora"] = true;
            }
            if (!empty($_POST["otso"])) { 
                $osallistujat["otso"] = true;
            }
            if (!empty($_POST["sami"])) { 
                $osallistujat["sami"] = true;
            }
            if (!empty($_POST["elias"])) { 
                $osallistujat["elias"] = true;
            }
        
            // Inputattua dataa lähinnä debuggausta varten
            echo "Osallistujat: "."<br>";
            $osallistuneet = "";
            foreach ($osallistujat as $x => $osallistuja) {
                if ($osallistuja != 0) {
                    echo $x.", ";
                    $osallistuneet = $osallistuneet." ".$x;
                }
            }
            $aAika = $_POST["aAika"];
            $lAika = $_POST["lAika"];
            $pvm = $_POST["pvm"];
            $selitys = $_POST["selitys"];
            $alkuTimestamp = date('Y-m-d H:i:s', strtotime("$pvm $aAika"));
            $loppuTimestamp = date('Y-m-d H:i:s', strtotime("$pvm $lAika"));
            // Laskee kuinka monta minuuttia käytettiin
            $aikaaYhteensa = (strtotime("$pvm $lAika") - strtotime("$pvm $aAika")) / 60;
                            
                echo "Päivämäärä: ".$pvm."<br>";
                echo "Aika: ".$aAika."-".$lAika."<br>";
                echo $aikaaYhteensa." minuuttia.<br>";
                if ($selitys != NULL) {
                    echo "Selitys: ".$selitys."<br><br>";
                } 
                
        
            // Aluksi if tarkistaa, jäikö täyttäjältä pakollisia kenttiä väliin.
            if ($aAika != NULL && $lAika != NULL && $pvm != NULL) {                 
                try {
                    // Alustaa yhteyden asetuksia, PDO-komentoja
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Lisää tyoajat-tableen kerran tiedot. Ensimmäinen rivi määrittää SQL-komennon, toinen suorittaa sen ja kolma kirjaa ylös id:n jotta sitä voidaan käyttää seuraavassa kohdassa viiteavaimen luomiseen.
                    $sql = "INSERT INTO tyoajat (sessio_aloitusaika, sessio_lopetusaika, sessio_pvm, sessio_selitys)
                    VALUES ('$alkuTimestamp', '$loppuTimestamp', '$pvm', '$selitys')";
                    $conn->exec($sql);
                    $last_id = $conn->lastInsertId();
                    // Seuraavaksi lisätään kunkin tiimin jäsenen omaan tableen rivi, jos heidät oli aiemmin merkity mukaan työkertaan ja merkitty arrayhyn trueksi. Ottaa tiedot viimeisimmästä lisätystä kerta-rivistä ja asettaa ne tähän uuteen riviin + asettaa sen PK:n omaksi FK:kseen. 
                    foreach ($osallistujat as $x => $osallistuja) {
                        if ($osallistuja != 0) {
                            $sql = "INSERT INTO $x (tyosessio_id, tyosessio_kesto) VALUES ('$last_id', '$aikaaYhteensa');";
                            $conn->exec($sql);
                        }
                    }
                    echo "Merkintä lisätty onnistuneesti";
                } catch(PDOException $e) {
                    //echo $sql . "<br>" . $e->getMessage();
                    echo "Connection failed: " . $e->getMessage()."<br>";
                }
            } else {
                echo "Et täyttänyt kaikkia pakollisia kenttiä!";
            }
            // Määrittelee lokimerkinnän tekstin, ja kirjoittaa sen log.txt-tiedostoon (luo uuden jollei valiimksi ole olemassa.)
            $logOutput = $osallistuneet." ".$pvm." ".$aAika."-".$lAika." (".$aikaaYhteensa." minuuttia) ".$selitys."\r\n";
            file_put_contents('log.txt', $logOutput, FILE_APPEND);
        ?>
        
    </body>

</html>

