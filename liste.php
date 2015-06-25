<?php
session_start();

function my_log($bdd) {
    $check = $bdd->prepare('SELECT * FROM gens WHERE login = :lelogin AND pass = :lepass');
    $check->execute(array('lelogin' => $_POST['login'], 'lepass' => $_POST['passwd']));
    $bool = $check->fetch();
    if ($bool) {
        
        echo '<div class="alert alert-success" align=center>
    Bonjour <strong>' . $bool['nom'] . '</strong>, vous avez été identifié(e) avec succes.</div>';
        $_SESSION['id'] = $bool['id'];
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['nom'] = $bool['nom'];
        $_SESSION['rang'] = $bool['hierarchie'];
        printf("<script>
    	setTimeout(function() {
    		location.href='centre.php'
		}, 2000);
    	</script>");
    } else {

        echo '<div class="alert alert-danger" align=center>
        Mot de passe ou identifiant incorrect !
        </div>';
        echo '<center><a href="index.php" class="btn btn-info" role="button">Retour à l\'index</a></center>';

    }
    $check->closeCursor();
}
?>


<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <title>Connexion</title>
    </head>
    <body>
        <?php
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=borrowme', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        my_log($bdd);
        ?>
    </body>
</html>