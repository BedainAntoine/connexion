<?php
$host = 'localhost';        //
$dbname = 'workshop';
$dbuser = 'bitnami';
$dbpw = 'mdpdebian';

$pdoReqArg1 = "mysql:host=". $host .";dbname=". $dbname .";";
$pdoReqArg2 = $adresseMail; //login
$pdoReqArg3 = $mdp; //password

try {

    $db = new \PDO($pdoReqArg1, $pdoReqArg2, $pdoReqArg3);
    $db->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_LOWER); // ATTR_CASE force les noms des colonnes à la casse // CASE_LOWER force les minuscules dans la colonne
    $db->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION); //ATTR_ERRMODE renvoie un rapport d'erreur // ERRMODE_EXCEPTION émet une exception
    $db->exec("SET NAMES 'utf8'");

} catch(\PDOException $e) { //la fonction catch permet d'attraper l'exception et d'empecher une erreur

    $errorMessage = $e->getMessage(); //getMessage affiche une chaine de caractère représentant l'erreur
}

$adresseMail = (!empty($_POST['adresseMail'])) ? $_POST['adresseMail'] : ''; //création variable login avec $_POST
$mdp = (!empty($_POST['mdp'])) ? sha1($_POST['mdp']) : ''; //création variable password avec $_POST

if($adresseMail != '' && $mdp != ''){ // si les variables sont différentes de '', on rentre dans le if
  echo = "mdp pas vide";
    global $db; // accède aux variables locales
    $sql = "SELECT *
           FROM utilisateur
           WHERE adresseMail=:adresseMail
           AND mdp=:mdp"; // connexion à la bd et à la table 'administrateur'

    $requete = $db->prepare($sql); // envoie d'une requête, qui est préparée
    $requete->bindParam(":adresseMail",$adresseMail); //bindParam lie la variable $login à leLogin
    $requete->bindParam(":mdp", $mdp);
    $requete->execute(); //execution, renvoi 0 en cas d'erreur et 1 si jamais le code est bon
    //on stocke le résultat dans un Array
    $array_Result = $requete->fetch(\PDO::FETCH_ASSOC); //fetch récupère une ligne depuis le tableau

    if ($requete->rowCount() > 0) { // rowCount retourne le nombre de ligne affectées par le dernier appel à la fonction execute.
                        
        echo "row 0";// dans le cas présent, si $requete > 0, on ouvre l'accès
        session_start(); // la session démarre
        foreach ($array_Result as $key => $value) { //foreach parcoure les tableaux et assigne la clé de lancement à $key

            $_SESSION[$key] = $value; // la session s'ouvre
        }
    }
    else echo " row 1";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style_login.css">
    <title>Login</title>
</head>
<body>

    <div class="centre box">
        <span><h1>Bienvenue !</h1></span>
        <br>
        <br>
        <br>
        <form action="" method="post">
              <input type="hidden" value="ok" name="control">
              <input class="date" type="text" name="adresseMail" placeholder="Adresse Email"><br>
              <input class="date" type="password" name="mdp" placeholder="MDP"><br>
              <input class="bouton" type="submit" value="Valider"/>
        </form><br>
    </div>
</body>
</html>
