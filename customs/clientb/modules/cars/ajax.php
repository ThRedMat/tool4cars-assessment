<?php
// 1. On charge les deux fichiers (Structure identique, juste un fichier de plus)
$cars = json_decode(file_get_contents('../../../../data/cars.json'), true);
$garages = json_decode(file_get_contents('../../../../data/garages.json'), true);

// 2. Étape de préparation (Nouveau) : on crée une liste rapide "ID => NOM" pour les garages
$garageNames = [];
foreach ($garages as $g) {
    $garageNames[$g['id']] = $g['name'];
}

// 3. Filtrage (Même structure)
$clientCars = array_filter($cars, function ($car) {
    return $car['customer'] === 'clientb';
});

echo "<h2>Véhicules de Client B</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0' style='width:100%; border-collapse: collapse;'>";
echo "<tr><th>Modèle (minuscules)</th><th>Marque</th><th>Nom du Garage</th></tr>";

// 4. La boucle (Structure identique)
foreach ($clientCars as $car) {

    // On récupère le nom du garage grâce à son ID
    $idDuGarage = $car['garageId'];
    $nomDuGarage = $garageNames[$idDuGarage] ?? "Non renseigné";

    echo "<tr class='car-item' data-id='" . $car['id'] . "' style='cursor:pointer;'>";
    // Utilisation de strtolower pour la demande spécifique du Client B
    echo "<td>" . htmlspecialchars(strtolower($car['modelName'])) . "</td>";
    echo "<td>" . htmlspecialchars($car['brand']) . "</td>";
    echo "<td>" . htmlspecialchars($nomDuGarage) . "</td>";
    echo "</tr>";
}
echo "</table>";
