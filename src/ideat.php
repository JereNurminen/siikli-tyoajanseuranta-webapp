<html>
     <body>
        <?php
            // Ottaa loginin muistiin
            include "login.php";

            // Kokeilee toimiiko yhteys annetuilla tiedoilla - antaa virheilmoituksen jos ei toimi
            try {
                 $conn = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage()."<br>";
            }

            $innovoija = $_POST['ideoija'];
            $idea = $_POST['idea'];
            echo $idea."<br>- ".ucfirst($innovoija)."<br>".$timestamp;

            if ($idea != NULL) {
                try {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO ideat(idea_selitys, idea_innovoija) VALUES ('$idea', '$innovoija');";
                    $conn->exec($sql);
                } catch(PDOException $e) {
                    echo "<br>Jokin meni pieleen!<br>";
                    echo $sql . "<br>" . $e->getMessage();
                }
            }
        // Määrittelee lokimerkinnän tekstin, ja kirjoittaa sen log.txt-tiedostoon (luo uuden jollei valiimksi ole olemassa.)
        $logOutput = $innovoija.": ".$idea."\n";
        file_put_contents('ideat_log.txt', $logOutput, FILE_APPEND);
        ?>
     </body>
</html>