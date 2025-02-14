<?php
echo "<h2>📃 Liste des Participants</h2>";

if (file_exists("liste.csv")) {
    $file = fopen("liste.csv", "r");
    echo "<ul>";
    while (($data = fgetcsv($file)) !== FALSE) {
        echo "<li>👤 $data[0] - 📧 $data[1]</li>";
    }
    echo "</ul>";
    fclose($file);
} else {
    echo "Aucune inscription pour le moment.";
}
?>
<a href="index.html">⬅ Retour</a>
