<?php
session_start();
if(!isset($_SESSION['utilisateur'])){
    echo "Pas connecté";
}else{
    $prenom = $_SESSION['utilisateur']['prenom'];
    $nom = $_SESSION['utilisateur']['nom'];
    $email = $_SESSION['utilisateur']['email'];
    $tel = $_SESSION['utilisateur']['noTel'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecté</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
<header>
        <ul>
            <li><a href="../index.php">Verdo Sàrl</a></li>
            <li id="deconnexion"><a href="deconnexion.php">Se déconnecter</a></li>
        </ul>
    </header>
    <main class ="pages">
        <div class = "confirmation">
            <h1>Salut <?php echo $prenom; ?>  ! </h1>
            <p>Félicitation tu es connecté.e !</p>
        </div>

        <div id='donneesUtilisateur'>
            <h2>Voici tes données  </h2>
            <p><?php echo $prenom; ?></p>
            <p><?php echo $nom; ?> </p>
            <p><?php echo $email; ?></p>
            <p><?php echo $tel; ?></p>
        </div>

    </main>
    <footer>
        <p>made with &nbsp; &#9829;&nbsp; by Cédrine Tille </p>
    </footer>
    
</body>
</html>