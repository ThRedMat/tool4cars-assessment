<?php
// 1. Récupération de l'ID du garage cliqué
$garageId = $_GET['id'] ?? null;

if (!$garageId) {
    die("ID du garage manquant.");
}

// 2. Chargement des bases de données
$garages = json_decode(file_get_contents('../../../../data/garages.json'), true);
$cars = json_decode(file_get_contents('../../../../data/cars.json'), true);

// 3. Trouver le bon garage
$selectedGarage = null;
foreach ($garages as $garage) {
    if ($garage['id'] == $garageId) {
        $selectedGarage = $garage;
        break;
    }
}

if (!$selectedGarage) {
    die("Garage introuvable.");
}

// 4. Trouver les voitures affectées à ce garage (La valeur ajoutée pour l'entretien)
$carsInThisGarage = array_filter($cars, function ($car) use ($garageId) {
    // On vérifie que la voiture appartient bien au client B ET qu'elle est dans ce garage
    return $car['customer'] === 'clientb' && $car['garageId'] == $garageId;
});

?>

<div class="edit-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Fiche du Garage : <?php echo htmlspecialchars($selectedGarage['name']); ?></h2>
    <button class="back-to-list" style="cursor:pointer; padding: 5px 10px;">&larr; Retour à la liste</button>
</div>

<div style="background: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
    <h3>Informations</h3>
    <p><strong>Identifiant interne :</strong> <?php echo htmlspecialchars($selectedGarage['id']); ?></p>

    <hr style="margin: 20px 0;">

    <h3>Véhicules actuellement pris en charge (<?php echo count($carsInThisGarage); ?>)</h3>

    <?php if (count($carsInThisGarage) > 0): ?>
        <ul>
            <?php foreach ($carsInThisGarage as $car): ?>
                <li>
                    <strong><?php echo htmlspecialchars($car['brand']); ?></strong> -
                    <?php echo htmlspecialchars(strtolower($car['modelName'])); ?>
                    (<?php echo htmlspecialchars($car['power']); ?> CV)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>Aucun véhicule n'est affecté à ce garage pour le moment.</em></p>
    <?php endif; ?>
</div>