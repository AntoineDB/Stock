<?php
session_start();

if ((!isset($_SESSION)) || ($_SESSION['id'] != true )) 
    printf("<script>location.href='index.php'</script>");

date_default_timezone_set('Europe/Paris');

require ('./php/functions.php');
?>
<!Doctype HTML>
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
        <title>Borrow Me</title>
        <?php /* if(isset($_SESSION['nom']))
          {
          echo '<div id=connected>';
          echo 'Connecté(e) en tant que : '.$_SESSION['nom']. '  (<a href= "deco.php">Deconnexion</a>)' ;
          echo '</div>';
          }
         */ ?>
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
                table_wait_demand($bdd);
            table_borrowing($bdd);
            stufs_available($bdd);
            echo '</div></div>';

// DEUXIEME COLONNE !!!

            echo '<div class = "col-md-4">'
            . '<div id = connected style="padding-bottom:15px;">'
            . 'Connecté(e) en tant que :<br \> <a align = center style = "color:blue;">' . $_SESSION['nom'] . '</a><br \>'
            . '<br \>'
            . '<button type = "button" onclick = "deco()" class = "btn btn-primary">Déconnexion</button>';
            if($_SESSION['rang'] <= 2)
            {
                echo  '<button type = "button" onclick="inventaire()" class = "btn btn-info">Gérer les objets</button>';
            }
            echo '</div>';
            news($bdd);
             
            echo '</div>'
            . '</div>';
            ?>
        </main>
        <footer>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('[data-toggle = "tooltip"]').tooltip();
                });
                setInterval(
                        function ()
                        {
                            $('#emprunts').load('./centre.php #emprunts_reload');
                        }, 1000);
                setInterval(
                        function ()
                        {
                            $('#news').load('./centre.php #news_reload');
                        }, 1000);

                function inventaire()
                {
                    location.href='inventaire.php';
                }
 
            </script>
        </footer>
    </body>
</html>