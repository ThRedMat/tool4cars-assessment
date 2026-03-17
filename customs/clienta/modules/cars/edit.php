<?php
$carId = $_GET['id'] ?? null;

if (!$carId) {
    echo '<div class="error-banner">⚠ Erreur : ID manquant.</div>';
    exit;
}

$path = "../../../../data/cars.json";
$cars = json_decode(file_get_contents($path), true);

$selectedCar = null;
foreach ($cars as $car) {
    if ($car['id'] == $carId) {
        $selectedCar = $car;
        break;
    }
}

$currentYear = 2026;
?>

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

    .edit-wrapper {
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
        font-weight: 400;
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
        margin-bottom: 28px;
        gap: 16px;
    }

    .edit-title {
        font-family: 'Syne', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.3px;
        line-height: 1.3;
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

    /* Card grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .detail-card {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 18px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        transition: border-color 0.15s;
    }

    .detail-card:hover {
        border-color: rgba(255, 255, 255, 0.12);
    }

    .detail-card.wide {
        grid-column: span 2;
    }

    .detail-label {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: var(--text-muted);
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.4;
    }

    .detail-value.muted {
        font-size: 13.5px;
        font-weight: 300;
        color: var(--text-secondary);
    }

    /* Color swatch */
    .color-value {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .color-swatch {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
    }

    .color-hex {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-primary);
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.04em;
    }

    /* Age badge */
    .age-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 99px;
        margin-top: 4px;
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

<?php if ($selectedCar) :
    $carYear = (int)date('Y', $selectedCar['year']);
    $age = $currentYear - $carYear;

    if ($age > 10) {
        $badgeClass = 'old';
        $badgeLabel = 'Ancienne (' . $age . ' ans)';
        $badgeIcon = '⚠';
    } elseif ($age < 2) {
        $badgeClass = 'new';
        $badgeLabel = 'Récente ('  . $age . ' an)';
        $badgeIcon = '✦';
    } else {
        $badgeClass = 'normal';
        $badgeLabel = $age . ' ans';
        $badgeIcon = '·';
    }
?>

    <div class="edit-wrapper">

        <button class="back-to-list">← Retour à la liste</button>

        <div class="edit-header">
            <h2 class="edit-title">
                <span>Fiche — </span><?php echo htmlspecialchars($selectedCar['brand'] . ' ' . $selectedCar['modelName']); ?>
            </h2>
            <span class="edit-id-badge"># <?php echo htmlspecialchars($selectedCar['id']); ?></span>
        </div>

        <div class="detail-grid">

            <div class="detail-card">
                <span class="detail-label">Marque</span>
                <span class="detail-value"><?php echo htmlspecialchars($selectedCar['brand']); ?></span>
            </div>

            <div class="detail-card">
                <span class="detail-label">Modèle</span>
                <span class="detail-value"><?php echo htmlspecialchars($selectedCar['modelName']); ?></span>
            </div>

            <div class="detail-card">
                <span class="detail-label">Année</span>
                <span class="detail-value"><?php echo $carYear; ?></span>
            </div>

            <div class="detail-card">
                <span class="detail-label">Puissance</span>
                <span class="detail-value"><?php echo htmlspecialchars($selectedCar['power']); ?> <span style="font-size:12px;color:var(--text-muted);font-weight:400">CV</span></span>
            </div>

            <div class="detail-card wide">
                <span class="detail-label">Couleur</span>
                <div class="color-value">
                    <div class="color-swatch" style="background: <?php echo htmlspecialchars($selectedCar['colorHex']); ?>;"></div>
                    <span class="color-hex"><?php echo htmlspecialchars($selectedCar['colorHex']); ?></span>
                </div>
            </div>

        </div>

    </div>

<?php else : ?>
    <div class="error-banner">⚠ Véhicule introuvable pour l'ID demandé.</div>
<?php endif; ?>