<?php
// Connexion a la base de donnees (a personnaliser)
$host = 'pgsql:host=postgresql-tyui.alwaysdata.net;dbname=tyui_inventaire';
$user = 'tyui';
$password = '0ratr1ce';

try {
    $pdo = new PDO($host, $user, $password);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}



// Mettez a jour la base de donnees (a personnaliser)
foreach ($_POST as $ingredient => $quantite) {
    $nom_aliment = str_replace('_', ' ', $ingredient);
    print_r($nom_aliment);
    print_r("\n");
    $sql = "UPDATE aliment SET nb = :quantite WHERE nom_al = :nom_aliment";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
    $stmt->bindParam(':nom_aliment', $nom_aliment, PDO::PARAM_STR);
    $stmt->execute();
}

echo "Quantites mises a jour avec succes !";

// Fermez la connexion
$pdo = null;
?>
