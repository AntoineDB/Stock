<?php
session_start();
if ((!isset($_SESSION)) || ($_SESSION['id'] != true )) {
    printf("<script>location.href='index.php'</script>");
}

require './php/functions.php';

function stufs_invotory($bdd) {
    echo '<div id = "inventaires">'
    . '<div id = "inventaires_reload"><h2>Objets Enregistrés :</h2>';
    $bdd->query("SET NAMES 'utf8'");
    $check = $bdd->prepare('SELECT * FROM objets');
    $check->execute();
    echo '<table class="table table-striped">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Quantité</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>';

    while ($bool = $check->fetch()) {
        $rend = false;
        echo'


      <tr>
        <td><input id="update_name'.$bool['id'].'" value="' . $bool['nom'] . '" type="text""></td>
        <td><input id="update_count'.$bool['id'].'" value="' . $bool['quantite'] . '" type="number" min="0" ></td>
        <td><input id="update_descrip'.$bool['id'].'" value="' . $bool['descriptif'] . '" type="text" ></td>
        <td><button type = "button" class = "btn btn-warning" onclick="bdd_update_obj(\'' . $bool['id'] . '\', document.getElementById(\'update_name'.$bool['id'].'\'), document.getElementById(\'update_count'.$bool['id'].'\') ,
            document.getElementById(\'update_descrip'.$bool['id'].'\'));$(\'#inventaires\').load(\'./inventaire.php #inventaires_reload\')">Modif</button>
            <button type = "button" class = "btn btn-danger" onclick="bdd_delete_obj(' . $bool['id'] . ');$(\'#inventaires\').load(\'./inventaire.php #inventaires_reload\')">Suppr</button></td>
      </tr>';






    }
    echo'    </tbody>
  </table>';
    if (!isset($rend))
        echo 'Aucune materiel n\'a été rentré dans la base de donnée';
    echo '</div></div>';
    $check->closeCursor();
}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./css/centre.css">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/jquery-ui.min.css">
        <script src="./js/jquery.min.js"></script>
        <script src="./js/jquery-ui.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./js/scripts.js"></script>
        <title>Gestion Stock</title>
    </head>
    <body>
        <main>
            <?php
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
                $bdd->query("SET NAMES 'utf8'");
            echo '<div id = "reload"><div id ="ecran">'
            . '<div class="col-md-8">';
            if ($_SESSION['rang'] <= 2)
            {
                stufs_invotory($bdd);
                add_stufs($bdd);
            }
            else
            {
                echo '<div class="alert alert-danger" align=center>
                    <strong >Vous n\'avez pas accès à cette partie !</strong>
                    <br \> <br \>
                    <button type = "button" onclick="centre()" class = "btn btn-success x">Retour à l\'accueil</button>
                    </div>';
            }
            echo '</div></div>';

// DEUXIEME COLONNE !!!

            echo '<div class = "col-md-4">'
            . '<div id = connected style="padding-bottom:15px;>'
            . 'Connecté(e) en tant que :<br \> <a align = center style = "color:blue;">' . $_SESSION['nom'] . '</a><br \>'
            . '<br \>'
            . '<button type = "button" onclick = "deco()" class = "btn btn-primary">Déconnexion</button>'
            . '</div>';
            if ($_SESSION['rang'] <= 2)
              echo '<button type = "button" onclick="centre()" class = "btn btn-info">Retour à l\'accueil</button>';
            echo '</div>'
            . '</div>';
            ?>
        </main>
        <footer>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('[data-toggle = "tooltip"]').tooltip();
                });

                  function centre()
                {
                    location.href='centre.php';
                }
            </script>
        </footer>
    </body>
</html>