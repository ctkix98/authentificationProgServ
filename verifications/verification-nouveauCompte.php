<?php
require_once('../db/Database.php');


$donneeUtilisateur = [];

//Recevoir les données, et vérifier si c'est juste
if (filter_has_var(INPUT_POST, 'submit')) { //ok ça fonctionne
    $donneeUtilisateur['nom'] = filter_input(INPUT_POST, 'nom', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[A-Za-zÇÉÈÊËÀÂÎÏÔÙÛçéèêëàâîïôùû]{1,19}$/"]]);
    $donneeUtilisateur['prenom'] = filter_input(INPUT_POST, 'prenom', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[A-Za-zÇÉÈÊËÀÂÎÏÔÙÛçéèêëàâîïôùû]{1,19}$/"]]);
    $donneeUtilisateur['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $donneeUtilisateur['tel'] = filter_input(INPUT_POST, 'tel', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^\d{3}\s?\d{3}\s?\d{2}\s?\d{2}$/"]]);    
    $donneeUtilisateur['mdp'] = filter_input(INPUT_POST, 'mdp', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[A-Za-z0-9$!€£]{8,20}$/"]]);
}else{
    header('Location: ../pages/errorCreationCompte.php', true, 303);
    exit();

}

//Vérifier si tous les champs sont remplis
$required = [
    'nom',
    'prenom',
    'email',
    'tel',
    'mdp',
];
foreach($required as $champ){
    if(empty($donneeUtilisateur[$champ])){
        header('Location: ../pages/errorCreationCompte.php', true, 303);
        exit();
    }
}

//Traitement des données
$donneeUtilisateur['nom'] = ucfirst(strtolower($donneeUtilisateur['nom']));
$donneeUtilisateur['prenom'] = ucfirst(strtolower($donneeUtilisateur['prenom']));
$donneeUtilisateur['email'] = strtolower($donneeUtilisateur['email']);
$donneeUtilisateur['tel'] = str_replace(' ','',$donneeUtilisateur['tel']);

//changer mdp pour un hash
$donneeUtilisateur['mdp'] = password_hash($donneeUtilisateur['mdp'], PASSWORD_DEFAULT);


//Appel de la DB
$db = new Database();
if ($db->creerTablePersonnes()) {
    echo "Création de la table 'personnes' réussie :-) <br>";
}


//Création d'une nouvelle personne avec les données enregistrées
$personne = new Personne(
    $donneeUtilisateur['prenom'],
    $donneeUtilisateur['nom'],
    $donneeUtilisateur['email'],
    $donneeUtilisateur['tel'],
    $donneeUtilisateur['mdp']
);
$id = $db ->ajouterPersonne($personne);
if($id>0){
    //Redirection sur la page de confirmation de création de compte
    header('Location: ../pages/confirmationCreationCompte.php', true, 303);
    exit();
}else {
    header('Location: ../pages/errorCreationCompte.php', true, 303);
    exit();
}



