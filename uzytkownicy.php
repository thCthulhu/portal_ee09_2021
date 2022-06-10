<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal społecznościowy</title>
    <link rel="stylesheet" href="styl5.css">
</head>
<body>
    <div class="bannerLeft">
        <h2>Nasze osiedle</h2>
    </div>
    <div class="bannerRight">
        <?php
            $conn = mysqli_connect("localhost", "root", "", "portal");
            if(!$conn){
                mysqli_connect_error("Error");
            }
            $query = "SELECT COUNT(*) FROM `dane` WHERE 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            echo "<h5>Liczba użytkowników portalu: $row[0]</h5>";
            mysqli_close($conn);
        ?>
    </div>
    <div class="mainLeft">
        <h3>Logowanie</h3>
        <form method="POST" action="uzytkownicy.php">
            Login:<br>
            <input type="text" name="login"><br>
            Hasło:<br>
            <input type="password" name="password"><br>
            <input type="submit" value="Zaloguj">
        </form>
    </div>
    <div class="mainRight">
        <h3>Wizytówka</h3>
        <div class="card">
            <?php
                if(isset($_POST['login']) && isset($_POST['password'])){
                    $login = $_POST['login'];
                    $password = $_POST['password'];
                    $conn = mysqli_connect("localhost", "root", "", "portal");
                    if(!$conn){
                        mysqli_connect_error("Error");
                    }
                    $query = "SELECT `haslo` FROM `uzytkownicy` WHERE `login`='$login'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_row($result);
                    if(mysqli_num_rows($result) > 0){
                        $passwrodSecured = sha1($password);
                        if($passwrodSecured == $row[0]){
                            $query2 = "SELECT `uzytkownicy`.`login`, `dane`.`rok_urodz`, `dane`.`przyjaciol`, `dane`.`hobby`, `dane`.`zdjecie` FROM `uzytkownicy`, `dane` WHERE `uzytkownicy`.`id` = `dane`.`id` AND `login`='$login'";
                            $result2 = mysqli_query($conn, $query2);
                            while($row2 = mysqli_fetch_row($result2)){
                                echo "<img src=\"$row2[4]\" alt=\"osoba\"";
                                $age = date("Y") - $row2[1];
                                echo "<h4>$row2[0] ($age)</h4>";
                                echo "<p>hobby: $row2[3]</p>";
                                echo "<h1><img src=\"icon-on.png\">$row2[2]</h1>";
                                echo "<a href=\"dane.html\" target=\"_blank\"><input type=\"button\" value=\"Więcej informacji\"></a>";
                            }
                        }
                        else{
                            echo "Hasła się nie zgadzają!";
                        }
                    }
                    else{
                        echo "Podany login nie istnieje!";
                    }
                    
                    mysqli_close($conn);
                }
                
            ?>
        </div>
    </div>
    <div class="footer">
        Stronę wykonał: thCthulhu
    </div>
</body>
</html>