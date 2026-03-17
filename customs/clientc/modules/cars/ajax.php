<?php
$path = "../../../../data/cars.json";
$jsonData = file_get_contents($path);
$cars = json_decode($jsonData, true);

// Filtrage (on utilise 'customer' pour correspondre à ton JSON)
$clientCars = array_filter($cars, function ($car) {
    return $car['customer'] === 'clientc';
});

echo "<h2>Véhicules de Client C</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
echo "<tr>
        <th>Modèle</th>
        <th>Marque</th>
        <th>Couleur</th>
      </tr>";

foreach ($clientCars as $car) {
    // 1. Calcul de l'âge (Nous sommes en 2026)


    echo "<tr class='car-item' data-id='" . $car['id'] . "' style='cursor:pointer;'>";
    echo "<td>" . htmlspecialchars($car['modelName']) . "</td>";
    echo "<td>" . htmlspecialchars($car['brand']) . "</td>";
    echo "<td style='text-align: center;'>
            <div style='
                display: inline-block; 
                width: 20px; 
                height: 20px; 
                border-radius: 50%; 
                border: 1px solid #000;
                background-color: " . htmlspecialchars($car['colorHex']) . ";
            '></div>
            <span style='margin-left: 10px;'>" . htmlspecialchars($car['colorHex']) . "</span>
          </td>";
    echo "</tr>";
}
echo "</table>";
