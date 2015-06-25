<?php

session_start();

if ($_SESSION['rang'] <= 2) {
    try 
    {
        $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
    } catch (Exception $e) 
    {
        die('Erreur : ' . $e->getMessage());
    }
    if (isset($_GET['id'])) 
    {
        $check = $bdd->prepare('DELETE FROM emprunts WHERE id='.$_GET['id'].'');
        $check->execute();
        $bool = $check->fetch();
        if (!$bool) 
        {
            
        }
    
    $check->closeCursor();
    }
}
?>