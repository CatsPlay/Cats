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
        <button id="afficherResultats">Valider</button>
        <div class="centrer">
            <table>
                <thead>
                    <th>
                        Plat possible
                    </th>
                </thead>
                <tbody id="resultats">
                    
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
    document.getElementById('afficherResultats').addEventListener('click', function() {
    const nbPersonne = document.getElementById("nb_personne").innerText;

    // Créez l'URL avec le paramètre nb_personne
    const url = `update_nb_perso.php?nb_personne=${nbPersonne}`;

    // Envoyez une requête GET au serveur
    fetch(url)
        .then(response => response.text())
        .then(data => {
            // Mettez à jour le contenu du tableau avec les résultats
            document.getElementById('resultats').innerHTML = data;
        })
        .catch(error => console.error('Erreur lors de la récupération des résultats :', error));
});
        </script>
    </body>
</html>