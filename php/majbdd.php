<?php

session_start();


    try {
        $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    if (isset($_GET['id']) && isset($_GET['nb'])) {
        $check = $bdd->prepare('UPDATE emprunts SET statut = :lenombre WHERE id = :leid ');
        $check->execute(array('leid' => $_GET['id'], 'lenombre' => $_GET['nb']));
        $bool = $check->fetch();
        if (!$bool) {
            echo 'PAS BON !';
        }
    } elseif (isset($_GET['quantite']) && isset($_GET['id'])) {
        $check = $bdd->prepare('INSERT INTO `borrowme`.`emprunts` '
                . '(`id`, `idobj`, `idgens`, `quantite`, `datedebut`, `datefin`, `statut`) '
                . 'VALUES (NULL, ' . $_GET['id'] . ', ' . $_SESSION['id'] . ', ' . $_GET['quantite'] . ', \'' . $_GET['datedebut'] . '\', \'' . $_GET['datefin'] . '\', \'0\')');
        $check->execute();
        $bool = $check->fetch();
        if (!$bool) {
            echo 'PAS BON !';
        }
    } elseif (isset($_GET['new_name']) && isset($_GET['new_quantite'])) {
        $check = $bdd->prepare('INSERT INTO `borrowme`.`objets` '
                . '(`id`, `nom`, `quantite`, `descriptif`) '
                . 'VALUES (NULL, \'' . $_GET['new_name'] . '\', \'' . $_GET['new_quantite'] . '\', \'' . $_GET['new_descriptif'] . '\')');
        $check->execute();
    } elseif (isset($_GET['up_name']) && isset($_GET['up_quantite'])) {
        $check = $bdd->prepare('UPDATE `borrowme`.`objets` SET'
                . '`nom`="' . $_GET['up_name'] . '" , `quantite`="' . $_GET['up_quantite'] . '", `descriptif`="' . $_GET['up_description'] . '" '
                . 'where `id`=' . $_GET['id']);
        $check->execute();
    } elseif (isset($_GET['id']) && isset($_GET['delete'])) {
        $check = $bdd->prepare('DELETE FROM `borrowme`.`objets`'
                . 'where `id`=' . $_GET['id']);
        $check->execute();
    }
    $check->closeCursor();

?>