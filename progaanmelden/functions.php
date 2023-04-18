<?php

function dbConnect()
{

    //Laad de database gegevens uit het config bestand
    $db = require(__DIR__ . '/config.php');

    try {
        // Hier maken we de database verbinding
        $connection = new PDO("mysql:host=" . $db['server'] . ";dbname=" . $db['database'] . ";port=" . $db['port'], $db['username'], $db['password']);

        // Database verbindings opties instellen
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
        
    } catch (PDOException $error) {
        echo "Verbinding niet gemaakt: " .  $error->getMessage();
        exit;
    }
}

function check_login($con) //De functie verwacht een parameter genaamd $con die een MySQLi-verbinding representeert
{

    if(isset($_SESSION['userid'])) //Er wordt een check uitgevoerd om te kijken of de $_SESSION-variabele 'user_id' is gezet
    {

        $id = $_SESSION['userid']; //Als de $_SESSION['user_id'] is gezet, wordt de variabele $id gezet op de waarde van $_SESSION['user_id']
        $query = "select * from users where userid = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0) //Er wordt een SQL-query opgebouwd die gegevens selecteert uit de tabel "users" waar het 'user_id' gelijk is aan de waarde van $id en beperkt is tot 1 rij
        {
            $user_data = mysqli_fetch_assoc($result); //De query wordt uitgevoerd met de mysqli_query()-functie en het resultaat wordt opgeslagen in de variabele $result
            return $user_data; //Returned de userdata
        }
    }

    // ga terug naar de login
    header("Location: login.php");
    die;

}

function random_num($length) //De functie verwacht een parameter genaamd $length die aangeeft hoeveel cijfers het nummer moet hebben
{

    $text = ""; //Een variabele $text wordt aangemaakt en is een lege string.
    if($length < 5) //Er wordt een check uitgevoerd om te kijken of de opgegeven $length kleiner is dan 5. Als dit het geval is, wordt de $length op 5 gezet
    {
        $length = 5;
    }

    $len = rand(4, $length); //Er wordt een variabele $len aangemaakt en gevuld met een willekeurig nummer tussen 4 en de opgegeven $length

    for ($i=0; $i < $len; $i++) { //Er wordt een for-loop uitgevoerd die zoveel keer zal lopen als $len aangeeft

        $text .= rand(0,9); //Binnen de loop wordt er een willekeurig cijfer tussen 0 en 9 aan de variabele $text toegevoegd
    }

    return $text; //Aan het einde van de functie wordt de variabele $text teruggegeven als het resultaat
}

function isEmpty($value){
    return empty($value);
}


function isValidEmail($value){ //De functie isValidEmail wordt gebruikt om te controleren of een opgegeven waarde (meestal een e-mailadres) een geldig e-mailadres is

    $cleaned = filter_var($value, FILTER_SANITIZE_EMAIL);
    if($cleaned == false){
        return false; //Als de email niet echt is krijg je dit terug
    }

    return filter_var($cleaned, FILTER_VALIDATE_EMAIL);
}

function hasMinLength($value, $min_length)
{

    $length = strlen($value);
    if ($length >= $min_length){
    return true; //Als je email echt is krijg je dit terug
}
    return false;
}
