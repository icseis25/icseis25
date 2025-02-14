<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $file_name = basename($file["name"]);
    $file_size = $file["size"];
    $file_tmp = $file["tmp_name"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_dir = "uploads/";

    // Vérification du format et de la taille
    if ($file_ext !== "pdf") {
        $error = "Le fichier doit être au format PDF.";
    } elseif ($file_size > 20 * 1024 * 1024) { // 20 Mo max
        $error = "Le fichier est trop volumineux (max : 20 Mo).";
    } else {
        // Création du dossier si nécessaire
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Générer un nom unique
        $new_file_name = time() . "_" . uniqid() . ".pdf";
        $upload_path = $upload_dir . $new_file_name;

        // Déplacement du fichier
        if (move_uploaded_file($file_tmp, $upload_path)) {
            $success = "Fichier téléchargé avec succès !";
        } else {
            $error = "Erreur lors du téléchargement du fichier.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #f9f9f9; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: blue; color: white; border: none; cursor: pointer; }
        .message { margin-top: 20px; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<h2>Soumettre un fichier PDF</h2>

<?php if (isset($success)) echo "<p class='message success'>$success</p>"; ?>
<?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <label>Fichier (PDF, max 20 Mo) :</label>
    <input type="file" name="file" accept="application/pdf" required>
    <button type="submit">Téléverser</button>
</form>

</body>
</html>
