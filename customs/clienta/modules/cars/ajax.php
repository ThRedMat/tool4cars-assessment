<?php
$path = "../../../../data/cars.json";
$jsonData = file_get_contents($path);
$cars = json_decode($jsonData, true);

// Filtrage (on utilise 'customer' pour correspondre à ton JSON)
$clientCars = array_filter($cars, function ($car) {
    return $car['customer'] === 'clienta';
});

echo "<h2>Véhicules de Client A</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
echo "<tr>
        <th>Modèle</th>
        <th>Marque</th>
        <th>Année</th>
        <th>Puissance (CV)</th>
      </tr>";

foreach ($clientCars as $car) {
    // 1. Calcul de l'âge
    $carYear = (int)date('Y', $car['year']);
    $currentYear = 2026;
    $age = $currentYear - $carYear;

    // 2. Construction des règles CSS (le curseur est toujours présent)
    $cssRules = "cursor: pointer; ";

    if ($age > 10) {
        $cssRules .= "color: red; font-weight: bold;";
    } elseif ($age < 2) {
        $cssRules .= "color: green; font-weight: bold;";
    }

    // 3. Affichage (Un seul attribut style propre)
    echo "<tr class='car-item' data-id='" . $car['id'] . "' style='" . $cssRules . "'>";
    echo "<td>" . htmlspecialchars($car['modelName']) . "</td>";
    echo "<td>" . htmlspecialchars($car['brand']) . "</td>";
    echo "<td>" . $carYear . "</td>";
    echo "<td>" . htmlspecialchars($car['power']) . "</td>";
    echo "</tr>";
}
echo "</table>";
