<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title>Mon plat</title>
        <link rel="stylesheet" type="text/css" href="style.css">
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
    </head>

    <body>
        <header id="bandeau" class="red">
            <h1>
                Mon plat
            </h1>
        </header>
        <nav class="centrer black">
            <a href="https://tyui.alwaysdata.net/mon-projet/plat.php">Mon plat</a>
            <a href="https://tyui.alwaysdata.net/mon-projet/inventaire.php">Mon inventaire</a>
        </nav>
        <div>
            <p>Nombre de personne :</p>

            <button onclick="adjustQuantity('moins')">-</button>
            <span id="nb_personne">0</span>
            <button onclick="adjustQuantity('plus')">+</button>
        </div>
        <div class="centrer">
            <table>
                <thead>
                    <th>
                        Plat possible
                    </th>
                </thead>
                <tbody>
                    <?php
                    
                    $query = 'SELECT DISTINCT nom_plat FROM plat AS p1
                    WHERE NOT EXISTS(
                    SELECT * FROM aliment JOIN plat ON aliment.nom_al = plat.ingredient
                    WHERE aliment.nb < plat.quantite
                    AND plat.nom_plat = p1.nom_plat);';
                    $result = $pdo->query($query);
                
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td class="ingredient">'.$row['nom_plat'].'</td>';
                        echo '</tr>';
                
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
    function adjustQuantity(action) {
        const spanQuantite = document.getElementById(`nb_personne`);
        let quantite = parseInt(spanQuantite.innerText);

        if (action === 'plus') {
            quantite++;
        } else if (action === 'moins') {
            if(quantite > 1){
                quantite--;
            }
        }

        spanQuantite.innerText = quantite;
    }
        </script>
    </body>
</html>