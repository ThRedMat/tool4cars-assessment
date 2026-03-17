<?php
$path   = "../../../../data/cars.json";
$cars   = json_decode(file_get_contents($path), true);

$clientCars = array_filter($cars, function ($car) {
    return $car['customer'] === 'clientc';
});
?>

<style>
    :root {
        --surface-2: #1c1f2b;
        --border: rgba(255, 255, 255, 0.07);
        --text-primary: #eef0f8;
        --text-secondary: #7a7f9a;
        --text-muted: #454966;
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

    .color-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .color-swatch {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.12);
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
    }

    .color-hex {
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-secondary);
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.04em;
    }

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
        <h2 class="vehicles-title">Véhicules de Client C</h2>
        <span class="vehicles-count"><?= count($clientCars) ?> véhicule<?= count($clientCars) > 1 ? 's' : '' ?></span>
    </div>

    <?php if (empty($clientCars)) : ?>
        <div class="empty-state">
            <span style="font-size:36px;opacity:.3">🚗</span>
            <span style="font-size:14px;">Aucun véhicule trouvé pour ce client.</span>
        </div>
    <?php else : ?>
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Modèle</th>
                    <th>Marque</th>
                    <th>Couleur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientCars as $car) : ?>
                    <tr class="car-item" data-id="<?= $car['id'] ?>">
                        <td><?= htmlspecialchars($car['modelName']) ?></td>
                        <td style="color: var(--text-secondary)"><?= htmlspecialchars($car['brand']) ?></td>
                        <td>
                            <div class="color-cell">
                                <div class="color-swatch" style="background: <?= htmlspecialchars($car['colorHex']) ?>;"></div>
                                <span class="color-hex"><?= htmlspecialchars($car['colorHex']) ?></span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>