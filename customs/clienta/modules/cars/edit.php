<?php
// 1. On récupère l'ID passé dans l'URL par AJAX
$carId = $_GET['id'] ?? null;

if (!$carId) {
    echo "Erreur : ID manquant.";
    exit;
}

// 2. On charge les données JSON
$path = "../../../../data/cars.json";
$cars = json_decode(file_get_contents($path), true);

// 3. On cherche la voiture qui possède cet ID
$selectedCar = null;
foreach ($cars as $car) {
    if ($car['id'] == $carId) {
        $selectedCar = $car;
        break;
    }
}

// 4. Si la voiture est trouvée, on l'affiche
if ($selectedCar) : ?>
    <div class="detail-container">
        <button class="back-to-list" style="cursor:pointer;">&larr; Retour à la liste</button>

        <h2>Fiche détaillée : <?php echo htmlspecialchars($selectedCar['brand'] . " " . $selectedCar['modelName']); ?></h2>

        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($selectedCar['id']); ?></td>
            </tr>
            <tr>
                <th>Année</th>
                <td><?php echo date('Y', $selectedCar['year']); ?></td>
            </tr>
            <tr>
                <th>Puissance</th>
                <td><?php echo htmlspecialchars($selectedCar['power']); ?> CV</td>
            </tr>
            <tr>
                <th>Couleur (HEX)</th>
                <td>
                    <span style="display:inline-block; width:20px; height:20px; background:<?php echo $selectedCar['colorHex']; ?>; border:1px solid #000; vertical-align:middle;"></span>
                    <?php echo htmlspecialchars($selectedCar['colorHex']); ?>
                </td>
            </tr>
        </table>
    </div>
<?php else : ?>
    <p>Véhicule introuvable.</p>
<?php endif; ?>