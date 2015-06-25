<?php

session_start();

if ($_SESSION['rang'] <= 2) 
{
    try 
    {
        $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
    } catch (Exception $e) 
    {
        die('Erreur : ' . $e->getMessage());
    }

        if ($_GET['nb'] === "1")
        {

            $check = $bdd->prepare('DELETE FROM emprunts WHERE id = '.$_GET['id']);
            $check->execute();
        }
        else
        {
            $check = $bdd->prepare('UPDATE emprunts SET statut = 1 WHERE id = '.$_GET['id']);
            $check->execute();
        }
    

    $check->closeCursor();
}
?>