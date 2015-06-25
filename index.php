<?php
session_start();
if (isset($_SESSION)) {
    unset($_SESSION);
}
?>


<html>
    <head>
        <title>Connexion</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./css/swag.css">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
    </head>
    <BODY>
        <div id="co">
            <h2> BORROW ME </h2>
            <form id="recherche" NAME="formulaire" ACTION="liste.php" METHOD="POST"> 
                <label> Nom d'utilisateur : <input type="text" NAME="login" class="form-control" value="" required></label> 
                <label> Mot de passe : <input type="password" NAME="passwd" class="form-control" required></label> 
                <br \>
                <button type ="submit" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-tree-"></span> Envoyer</button> 
            </form>
        </div>
    </BODY>
</HTML>