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
$nb_perso = $_GET['nb_personne'];

$query = 'SELECT DISTINCT nom_plat FROM plat AS p1
WHERE NOT EXISTS(
SELECT * FROM aliment JOIN plat ON aliment.nom_al = plat.ingredient NATURAL JOIN recette
WHERE aliment.nb < (plat.quantite * :nb_perso) / recette.nb_personne
AND plat.nom_plat = p1.nom_plat);';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':nb_perso', $nb_perso, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo '<tr>';
    echo '<td >'.$row['nom_plat'].'</td>';
    echo '</tr>';

}


// Fermez la connexion
$pdo = null;
?>
