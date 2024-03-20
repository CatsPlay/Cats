<!DOCTYPE html>

<html>
<head>
  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
  <title>Inventaire</title>
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
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <header id="bandeau" class="blue">
    <h1>
      Inventaire
    </h1>
  </header>
    <nav class="centrer black">
      <a href="https://tyui.alwaysdata.net/mon-projet/plat.php">Mon plat</a>
      <a href="https://tyui.alwaysdata.net/mon-projet/inventaire.php">Mon inventaire</a>
    </nav>
  <div class="centrer">
    <table>
      <thead>
        <th>
          Ingrédients
        </th>
        <th>
          Nombre
        </th>
      </thead>
      <tbody>
      <?php
  $query = 'SELECT * FROM aliment';
  $result = $pdo->query($query);

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td class="ingredient">'.$row['nom_al'].'</td>';
      echo '<td>';
      echo '<span id="quantite_'.$row['nom_al'].'">'.$row['nb'].'</span>';
      echo '<button onclick="adjustQuantity(\''.$row['nom_al'].'\', \'plus\')">+</button>';
      echo '<button onclick="adjustQuantity(\''.$row['nom_al'].'\', \'moins\')">-</button>';
      echo '</td>';
      echo '</tr>';

  }
      ?>
      </tbody>
    </table>
  </div>
  <div class="centrer" >
    <button id="btn" onclick="updateDatabase()">Modifier</button>
  </div>
  <script>
    function adjustQuantity(ingredient, action) {
        const spanQuantite = document.getElementById(`quantite_${ingredient}`);
        let quantite = parseInt(spanQuantite.innerText);

        if (action === 'plus') {
            quantite++;
        } else if (action === 'moins') {
            quantite--;
        }

        spanQuantite.innerText = quantite;
    }
    function updateDatabase() {
        const ingredients =  document.getElementsByClassName('ingredient');
        // Creez un objet FormData pour envoyer les donnees au serveur
        const formData = new FormData();
        for (const ingredient of ingredients) {
          const nomIngredient = ingredient.innerText;
          const quantite = document.getElementById(`quantite_${nomIngredient}`);
          const quantiteIngredient = quantite.innerText;
          console.log(quantite);
          formData.append(nomIngredient, quantiteIngredient);
        }

        // Envoyez les donnees au serveur via une requete AJAX
        fetch('update_quantite.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Affichez la reponse du serveur (a des fins de débogage)
        })
        .catch(error => {
            console.error('Erreur lors de la mise a jour :', error);
        });
    }
</script>
</body>
</html>
