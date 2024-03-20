  <?php
$dsn = 'pgsql:host=postgresql-tyui.alwaysdata.net;dbname=tyui_inventaire';
$user = 'tyui';
$password = '0ratr1ce';

try {
    $pdo = new PDO($dsn, $user, $password);
    
} catch (PDOException $e) {
    die('Erreur de connexion : '.$e->getMessage());
}
?>

<?php
$query = 'SELECT * FROM aliment';
$result = $pdo->query($query);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>'.$row['nom_al'].'</td>';
    echo '<td>'.$row['nb'].'</td>';
    echo '</tr>';
}
$pdo = null;
    ?>