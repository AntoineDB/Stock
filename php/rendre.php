<?php

session_start();

    try 
    {
        $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
    } catch (Exception $e) 
    {
        die('Erreur : ' . $e->getMessage());
    }
   if (isset($_GET['id']) && isset($_GET['bool']) ) 
    {

      /*  date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d', time());
*/
        if ($_GET['bool'] === "Annuler")
        {
            $check = $bdd->prepare('DELETE FROM emprunts WHERE id = '.$_GET['id']);
            $check->execute();
        }
        else
        {
            $check = $bdd->prepare('UPDATE emprunts SET statut = 4 WHERE id = '.$_GET['id'].'');
            $check->execute();
        }

    
    $check->closeCursor();
    }

?>