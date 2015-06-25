<?php

function table_borrowing($bdd) 
{
    $bdd->query("SET NAMES 'utf8'");
    $check = $bdd->prepare('SELECT * FROM emprunts, objets WHERE idgens = :lemec AND idobj = objets.id AND statut != 2');
    $check->execute(array('lemec' => $_SESSION['id']));
    echo '<div id = "emprunts">'
    . '<div id = "emprunts_reload"><h2>Tes Emprunts :</h2>'
    . '<table><div class = "list-group">';
    while ($bool = $check->fetch()) 
    {
        $rend = true;
        $estceendemande = "";
        $dateActuelle = date('Y-m-d', time());
        if ($bool['datedebut'] > $dateActuelle || $bool['statut'] == 0)
            $textButton = "Annuler";
        else
            $textButton = "Rendre";
        $datearray = explode("-", $bool["datefin"]);
        $datearray2 = explode("-", $bool["datedebut"]);
        $mois = ["Jan", "Fev", "Mars", "Avril", "Mai", "Juin", "Juil", "Aout", "Sept", "Nov", "Dec"];
        $datefinlisible = $datearray[2]." ".$mois[intval($datearray[1] - 1)]." ".$datearray[0];
        $datedebutlisible = $datearray2[2]." ".$mois[intval($datearray2[1] - 1)]." ".$datearray2[0];
        if ($bool['statut'] == 0)
            $estceendemande = "[Demande] ";
        if ($bool['statut'] == 4)
            $estceendemande = "[Rendu] ";
        echo '<tr><td style="width:100%;"><a class = "list-group-item">'
        . '<h4 class = "list-group-item-heading">' . $estceendemande . $bool["nom"] .'</h4>'
        . '<p class = "list-group-item-text">Emprunt du '.$datedebutlisible.' au ' . $datefinlisible . '</p></a></td>'
        . '<td><button style="height:100%;" type="button" onclick="bdd_return('.$bool[0].', \''.$textButton.'\')" class="btn btn-default">'.$textButton.'</button></td></tr>';
    }
    echo '</div></table>';
    if (!isset($rend))
        echo 'Aucune location en cours';
    echo '</div></div>';
}

function table_wait_demand($bdd) 
{
    echo '<div id ="news"><div id="news_reload"><h2>Informations</h2>';
    $check3 = $bdd->prepare('SELECT emprunts.id, objets.nom, gens.nom, datefin, statut FROM emprunts, objets, gens WHERE (statut = 0 OR statut = 4) AND idobj = objets.id AND idgens = gens.id');
    $check3->execute();
    echo '<table id = news4 class="table table-striped"><thead>'
    . '<tr>'
    . '<th>Type</th>'
    . '<th>Objet</th>'
    . '<th>Emprunteur</th>'
    . '<th>Date fin emprunt</th>'
    . '<th>Action</th>'
    . '</tr >'
    . '</thead><tbody>';
    for ($i = 0; $bool = $check3->fetch(); $i++) 
    {
        if ($bool['statut'] == 4)
        {
            $onclick = "majrendu";
            $type = "Retour";
            $textButton = "Confirmer";
        }
        else
        {
            $onclick = "majbdd";
            $type = "Demande";
            $textButton = "Accepter";
        }
        $rend = true;
        echo '<tr id = "ligne' . $i . '">'
        . '<td>' . $type . '</td>'
        . '<td>' . $bool[1] . '</td>'
        . '<td>' . $bool[2] . '</td>'
        . '<td>' . $bool[3] . '</td>'
        . '<td> <div class = "btn-group">'
        . '<button type = "button" class = "btn btn-success" onclick = "$(\'#ligne' . $i . '\').hide(); '.$onclick.'(1, ' . $bool[0] . ', '.$i.'); ">'.$textButton.'</button>'
        . '<button type = "button" class = "btn btn-danger" onclick = "$(\'#ligne' . $i . '\').hide(); '.$onclick.'(2, ' . $bool[0] . '); ">Refuser</button>'
        . '</div></td>'
        . '</tr>';
    }
    echo '</tbody></table></div></div>';
    if (!isset($rend))
        echo 'Aucune Demande en attente';
}

function stufs_available($bdd) {
    echo '<div id = "dispo">'
    . '<h2>Objets Disponibles :</h2>';
    
    $check = $bdd->prepare('SELECT * FROM objets');
    $check->execute();
    echo '<table class="table table-striped">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Quantité</th>
        <th>Date debut</th>
        <th>Date fin</th>
        <th>Quantité en stock</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    while ($bool = $check->fetch()) {
        $rend = false;
        $check2 = $bdd->prepare('SELECT idobj, SUM(quantite) AS q FROM emprunts WHERE idobj = ' . $bool['id'] . ' AND statut = 1');
        $check2->execute(array('haha' => $bool['id']));
        $bool2 = $check2->fetch();
        $reste = intval($bool['quantite']) - intval($bool2['q']);
        if ($reste > 0)
            echo'<tr align=center>'
            . '<td> <a data-toggle = "tooltip" title = "' . $bool['descriptif'] . '">' . $bool['nom'] . '</a></td><td><input type="number" min="1" max="'.$reste.'" id="count[' . $bool['id'] . ']"></td>'
            . '<td><input id="datedebut[' . $bool['id'] . ']" type="date" class="date"></td><td><input id="datefin[' . $bool['id'] . ']" type="date" class="date"></td>'
            .'<td> <span class = "badge">' . $reste . '</span></td>'
            . '<td><button type = "button" class = "btn btn-primary" onclick="bdd_bor(document.getElementById(\'count[' . $bool['id'] . ']\'),'
            . $bool['id'] . ', document.getElementById(\'datedebut[' . $bool['id'] . ']\') ,'
            . 'document.getElementById(\'datefin[' . $bool['id'] . ']\'));">Emprunter</button></td>'
            . '</tr>';
    }
    echo'</tbody></table>';
    if (!isset($rend))
        echo 'Aucune materiel n\'a été rentré dans la base de donnée';
    echo '</div>';
    $check->closeCursor();
}

function add_stufs($bdd) {
    echo '<div id = "new_stufs">'
    . '<h2>Ajouter un nouvel objet :</h2>';
    //$check->closeCursor();
    echo '<table class="table table-striped">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Quantité</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>';
    echo'<tr>'
    . '<td> <input id="new_name" placeholder="Ex : câble hdmi" type="text"> </td>'
    . '<td> <input id="new_quantite" type="number" min="0" value="0">'
    . '<td> <input id="new_description" placeholder="Ex : Réptile à corne" type="text">'
    . '<td> <button type = "button" class = "btn btn-primary" onclick="bdd_new(document.getElementById(\'new_name\'), '
    . 'document.getElementById(\'new_quantite\'), '
    . 'document.getElementById(\'new_description\'));$(\'#inventaires\').load(\'./inventaire.php #inventaires_reload\')">Ajouter</button>'
    . '</td> </tr>'
    . '</tbody></table>';
    echo '</div>';
}

function news($bdd)
{

    echo '<div id = "dispo">'
    . '<h2>Objets  :</h2>';
    //$check->closeCursor();
    $check = $bdd->prepare('SELECT * FROM emprunts, objets WHERE objets.id = idobj AND statut != 1 AND idgens = '.$_SESSION['id']);
    $check->execute();
    echo '<div id="notif">';
    
    while ($bool = $check->fetch()) {
        $rend = false;
        
        if ($bool['statut'] == 0)
        {
            echo'<div class="alert alert-info" style="padding-bottom: 10px;">'
            .'L\'objet '.$bool['nom'].' est actuellement cours de validation'
            .'</div>';
        }
        if ($bool['statut'] == 2)
        {
            echo'<div id="div'.$bool[0].'" class="alert alert-danger" style="padding-bottom: 10px;">'
            .'<table> <tr><td> '
            .'L\'emprunt de l\'objet "'.$bool['nom'].'" est été refusé par l\'administration !'
            .'</td><td> <button onclick=supprNotif('.$bool[0].') type="button" class="btn btn-default">Ok</button> </td></tr></table>'
            .'</div>';

        }
    }
    if (!isset($rend))
        echo '';
    echo '</div>';
    $check->closeCursor();


}


?>