<?php
// On charge uniquement les garages
$path = "../../../../data/garages.json";
$garages = json_decode(file_get_contents($path), true);

echo "<h2>Liste des Garages partenaires</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
echo "<tr>
        <th>ID du Garage</th>
        <th>Nom du Garage</th>
      </tr>";

foreach ($garages as $garage) {
    // Notez qu'on utilise 'garage-item' et non plus 'car-item'
    echo "<tr class='garage-item' data-id='" . $garage['id'] . "' style='cursor:pointer;'>";
    echo "<td>" . htmlspecialchars($garage['id']) . "</td>";
    echo "<td>" . htmlspecialchars($garage['title']) . "</td>";
    echo "</tr>";
}
echo "</table>";
