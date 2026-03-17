<?php
$garageId = $_GET['id'] ?? null;

if (!$garageId) {
    echo '<div class="error-banner">⚠ ID du garage manquant.</div>';
    exit;
}

$garages = json_decode(file_get_contents('../../../../data/garages.json'), true);
$cars    = json_decode(file_get_contents('../../../../data/cars.json'),    true);

$selectedGarage = null;
foreach ($garages as $garage) {
    if ($garage['id'] == $garageId) {
        $selectedGarage = $garage;
        break;
    }
}

if (!$selectedGarage) {
    echo '<div class="error-banner">⚠ Garage introuvable.</div>';
    exit;
}

$carsInThisGarage = array_filter($cars, function ($car) use ($garageId) {
    return $car['customer'] === 'clientb' && $car['garageId'] == $garageId;
});

$carCount = count($carsInThisGarage);
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
        --accent-2: #00e5c3;
        --success: #22d3a5;
    }

    .garage-edit {
        font-family: 'DM Sans', sans-serif;
    }

    /* Back button */
    .back-to-list {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: none;
        border: 1px solid var(--border);
        color: var(--text-secondary);
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        padding: 7px 14px;
        border-radius: 8px;
        cursor: pointer;
        margin-bottom: 24px;
        transition: background 0.15s, color 0.15s, border-color 0.15s;
    }

    .back-to-list:hover {
        background: var(--surface-2);
        color: var(--text-primary);
        border-color: rgba(255, 255, 255, 0.14);
    }

    /* Header */
    .edit-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 16px;
    }

    .edit-title {
        font-family: 'Syne', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.3px;
    }

    .edit-title span {
        color: var(--text-secondary);
        font-weight: 400;
    }

    .edit-id-badge {
        font-size: 11px;
        font-weight: 500;
        color: var(--text-muted);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 4px 10px;
        border-radius: 99px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Info card */
    .info-card {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-card-label {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: var(--text-muted);
    }

    .info-card-value {
        font-size: 14px;
        font-weight: 400;
        color: var(--text-secondary);
        font-variant-numeric: tabular-nums;
    }

    /* Section title */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        margin-top: 8px;
    }

    .section-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.1px;
    }

    .car-count-badge {
        font-size: 11px;
        font-weight: 500;
        color: #34d9c3;
        background: rgba(0, 229, 195, 0.08);
        border: 1px solid rgba(0, 229, 195, 0.2);
        padding: 3px 10px;
        border-radius: 99px;
    }

    /* Cars list */
    .car-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .car-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: 12px 16px;
        transition: border-color 0.15s, background 0.15s;
    }

    .car-list-item:hover {
        background: #212435;
        border-color: rgba(255, 255, 255, 0.11);
    }

    .car-list-left {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .car-list-model {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-primary);
    }

    .car-list-brand {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 300;
    }

    .car-power-badge {
        font-size: 12px;
        font-weight: 500;
        color: #818cf8;
        background: var(--accent-glow);
        border: 1px solid rgba(79, 110, 247, 0.2);
        padding: 3px 10px;
        border-radius: 99px;
        white-space: nowrap;
    }

    /* Empty state */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 40px 20px;
        color: var(--text-muted);
        text-align: center;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
    }

    /* Error */
    .error-banner {
        background: rgba(255, 77, 109, 0.08);
        border: 1px solid rgba(255, 77, 109, 0.2);
        border-radius: 8px;
        padding: 14px 18px;
        font-size: 13.5px;
        color: #ff8099;
    }
</style>

<div class="garage-edit">

    <button class="back-to-list">← Retour à la liste</button>

    <div class="edit-header">
        <h2 class="edit-title">
            <span>Garage — </span><?php echo htmlspecialchars($selectedGarage['name']); ?>
        </h2>
        <span class="edit-id-badge"># <?php echo htmlspecialchars($selectedGarage['id']); ?></span>
    </div>

    <!-- Infos -->
    <div class="info-card">
        <span class="info-card-label">Identifiant interne</span>
        <span class="info-card-value"><?php echo htmlspecialchars($selectedGarage['id']); ?></span>
    </div>

    <!-- Véhicules -->
    <div class="section-header">
        <h3 class="section-title">Véhicules pris en charge</h3>
        <span class="car-count-badge"><?= $carCount ?> véhicule<?= $carCount > 1 ? 's' : '' ?></span>
    </div>

    <?php if ($carCount > 0) : ?>
        <div class="car-list">
            <?php foreach ($carsInThisGarage as $car) : ?>
                <div class="car-list-item">
                    <div class="car-list-left">
                        <span class="car-list-model"><?= htmlspecialchars(strtolower($car['modelName'])) ?></span>
                        <span class="car-list-brand"><?= htmlspecialchars($car['brand']) ?></span>
                    </div>
                    <span class="car-power-badge"><?= htmlspecialchars($car['power']) ?> CV</span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="empty-state">
            <span style="font-size:32px;opacity:.3">🔧</span>
            <span style="font-size:13.5px;">Aucun véhicule affecté à ce garage.</span>
        </div>
    <?php endif; ?>

</div>