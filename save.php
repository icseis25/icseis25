<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des entrées utilisateur
    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $établissement = htmlspecialchars(trim($_POST["établissement"] ?? ""));
    $profile = htmlspecialchars(trim($_POST["profile"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));

    // Vérification des champs obligatoires
    if (!empty($name) && !empty($établissement) && !empty($profile) && !empty($email)) {
        // Validation de l'email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Ouverture du fichier en mode ajout
            $file = fopen("liste.csv", "a");
            if ($file) {
                // Ajout d'un en-tête UTF-8 pour éviter les problèmes d'encodage
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // Écriture des données
                fputcsv($file, [$name, $établissement, $profile, $email]);

                fclose($file);
                echo "Inscription réussie ! <a href='index.html'>Retour</a>";
            } else {
                echo "Erreur : Impossible d'écrire dans le fichier.";
            }
        } else {
            echo "Erreur : Adresse email invalide.";
        }
    } else {
        echo "Erreur : Veuillez remplir tous les champs.";
    }
}
?>

