<?php
$path = "../../../../data/cars.json";
$jsonData = file_get_contents($path);
$cars = json_decode($jsonData, true);

$clientCars = array_filter($cars, function ($car) {
    return $car['customer'] === 'clienta';
});

$currentYear = 2026;
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

<style>
    :root {
        --surface-2: #1c1f2b;
        --border: rgba(255, 255, 255, 0.07);
        --text-primary: #eef0f8;
        --text-secondary: #7a7f9a;
        --text-muted: #454966;
        --success: #22d3a5;
        --danger: #ff6b81;
        --accent: #4f6ef7;
        --accent-glow: rgba(79, 110, 247, 0.14);
    }

    .vehicles-section {
        font-family: 'DM Sans', sans-serif;
    }

    .vehicles-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .vehicles-title {
        font-family: 'Syne', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.2px;
    }

    .vehicles-count {
        font-size: 12px;
        font-weight: 500;
        color: #818cf8;
        background: var(--accent-glow);
        border: 1px solid rgba(79, 110, 247, 0.25);
        padding: 3px 10px;
        border-radius: 99px;
    }

    .vehicle-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .vehicle-table thead tr {
        background: var(--surface-2);
        border-bottom: 1px solid var(--border);
    }

    .vehicle-table th {
        padding: 11px 16px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        font-weight: 600;
        color: var(--text-muted);
    }

    .vehicle-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .vehicle-table tbody tr:last-child {
        border-bottom: none;
    }

    .vehicle-table tbody tr.car-item {
        cursor: pointer;
    }

    .vehicle-table tbody tr.car-item:hover {
        background: var(--surface-2);
    }

    .vehicle-table td {
        padding: 12px 16px;
        color: var(--text-primary);
        font-weight: 300;
    }

    .vehicle-table td:first-child {
        font-weight: 500;
    }

    /* Age badges */
    .age-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
        padding: 2px 9px;
        border-radius: 99px;
    }

    .age-badge.old {
        background: rgba(255, 107, 129, 0.10);
        border: 1px solid rgba(255, 107, 129, 0.25);
        color: #ff8099;
    }

    .age-badge.new {
        background: rgba(34, 211, 165, 0.10);
        border: 1px solid rgba(34, 211, 165, 0.25);
        color: #22d3a5;
    }

    .age-badge.normal {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: var(--text-secondary);
    }

    /* Empty state */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 220px;
        color: var(--text-muted);
        text-align: center;
    }
</style>

<div class="vehicles-section">
    <div class="vehicles-header">
        <h2 class="vehicles-title">Véhicules de Client A</h2>
        <span class="vehicles-count"><?= count($clientCars) ?> véhicule<?= count($clientCars) > 1 ? 's' : '' ?></span>
    </div>

    <?php if (empty($clientCars)): ?>
        <div class="empty-state">
            <span style="font-size:36px;opacity:.3">🚗</span>
            <span style="font-size:14px;">Aucun véhicule trouvé pour ce client.</span>
        </div>
    <?php else: ?>
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Modèle</th>
                    <th>Marque</th>
                    <th>Année</th>
                    <th>Puissance (CV)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientCars as $car):
                    $carYear = (int)date('Y', $car['year']);
                    $age = $currentYear - $carYear;

                    if ($age > 10) {
                        $badgeClass = 'old';
                        $badgeLabel = 'Ancienne';
                        $badgeIcon = '⚠';
                    } elseif ($age < 2) {
                        $badgeClass = 'new';
                        $badgeLabel = 'Récente';
                        $badgeIcon = '✦';
                    }
                ?>
                    <tr class="car-item" data-id="<?= $car['id'] ?>">
                        <td><?= htmlspecialchars($car['modelName']) ?></td>
                        <td style="color: var(--text-secondary)"><?= htmlspecialchars($car['brand']) ?></td>
                        <td><?= $carYear ?></td>
                        <td><?= htmlspecialchars($car['power']) ?> <span style="font-size:11px;color:var(--text-muted)">CV</span></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>