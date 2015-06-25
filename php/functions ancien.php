<?php

function table_borrowing($bdd) {
    $bdd->query("SET NAMES 'utf8'");
    $check = $bdd->prepare('SELECT * FROM emprunts, objets WHERE idgens = :lemec AND idobj = objets.id');
    $check->execute(array('lemec' => $_SESSION['id']));
    echo '<div id = "emprunts">'
    . '<div id = "emprunts_reload"><h2>Tes Emprunts :</h2>'
    . '<div class = "list-group">';
    while ($bool = $check->fetch()) {
        //echo 'tu dois : '.$bool['idobj'].'<br \>';
        $rend = true;
        $estceendemande = "";
        if ($bool['statut'] == 0)
            $estceendemande = "[Demande] ";
        echo '<a class = "list-group-item">'
        . '<h4 class = "list-group-item-heading">' . $estceendemande . $bool["nom"] . '</h4>'
        . '<p class = "list-group-item-text">A rendre avant le ' . $bool["datefin"] . '</p>'
        . '</a>';
    }
    echo '</div>';
    if (!isset($rend))
        echo 'Aucune location en cours';
    echo '</div></div>';
}

function table_wait_demand($bdd) {
    echo '<div id ="news"><div id="news_reload"><h2>Informations</h2>';
    $bdd->query("SET NAMES 'utf8'");
    $check3 = $bdd->prepare('SELECT * FROM emprunts, objets, gens WHERE objets.id = idobj AND gens.id = idgens AND statut = 0');
    $check3->execute();
    echo '<table id = news class="table table-striped"><thead>'
    . '<tr>'
    . '<th>Objet</th>'
    . '<th>Mec qui demande</th>'
    . '<th>Date fin emprunt</th>'
    . '<th>Action</th>'
    . '</tr >'
    . '</thead><tbody>';
    for ($i = 0; $bool = $check3->fetch(); $i++) {
        $rend = true;
        echo '<tr id = "ligne' . $i . '">'
        . '<td>' . $bool[8] . '</td>'
        . '<td>' . $bool['nom'] . '</td>'
        . '<td>' . $bool['datefin'] . '</td>'
        . '<td> <div class = "btn-group">'
        . '<button type = "button" class = "btn btn-success" onclick = "$(\'#ligne' . $i . '\').hide(); majbdd(1, ' . $bool[0] . '); ">Accepter</button>'
        . '<button type = "button" class = "btn btn-danger" onclick = "$(\'#ligne' . $i . '\').hide(); majbdd(2, ' . $bool[0] . '); ">Refuser</button>'
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
    //$check->closeCursor();
    $check = $bdd->prepare('SELECT * FROM objets');
    $check->execute(array('lemec' => $_SESSION['id']));
    echo '<ul class = "list-group">';
    while ($bool = $check->fetch()) {
        $rend = false;
        $check2 = $bdd->prepare('SELECT idobj, SUM(quantite) AS q FROM emprunts WHERE idobj = ' . $bool['id'] . ' AND statut = 1');
        $check2->execute(array('haha' => $bool['id']));
        $bool2 = $check2->fetch();
        $reste = intval($bool['quantite']) - intval($bool2['q']);
        if ($reste > 0)
            echo'<li class = "list-group-item">'
            . '<table> <tr><td style="max-width:100px;"><a data-toggle = "tooltip" title = "' . $bool['descriptif'] . '">' . $bool['nom'] . '</a></td><td style="padding:5px;"><input type="number" min = "0" size="3" max="$reste" id="count[' . $bool['id'] . ']">'
                . '</td><td style="padding:5px;" ><input id="datedebut['.$bool['id'].']" type="date" class="date"></td><td style="padding:5px;"><input id="datefin['.$bool['id'].']" type="date" class="date">'
            . '</td><td style="padding:5px;"><button type = "button" class = "btn btn-primary" onclick="bdd_bor(document.getElementById(\'count['.$bool['id'].']\'),'
            . $bool['id'].', document.getElementById(\'datedebut['.$bool['id'].']\') ,'
            . 'document.getElementById(\'datefin['.$bool['id'].']\'));">Emprunter</button></td></tr></table> <span class = "badge">' . $reste . '</span>'
            . '</li>';
    }
    echo'</ul>';
    if (!isset($rend))
        echo 'Aucune materiel n\'a été rentré dans la base de donnée';
    echo '</div>';
    $check->closeCursor();
}