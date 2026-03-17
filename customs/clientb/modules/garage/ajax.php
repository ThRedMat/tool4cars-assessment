<?php
$path   = "../../../../data/garages.json";
$garages = json_decode(file_get_contents($path), true);
?>

<style>
    :root {
        --surface-2: #1c1f2b;
        --border: rgba(255, 255, 255, 0.07);
        --text-primary: #eef0f8;
        --text-secondary: #7a7f9a;
        --text-muted: #454966;
        --accent-2: #00e5c3;
    }

    .garages-section {
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
        color: #34d9c3;
        background: rgba(0, 229, 195, 0.08);
        border: 1px solid rgba(0, 229, 195, 0.2);
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

    .vehicle-table tbody tr.garage-item {
        cursor: pointer;
    }

    .vehicle-table tbody tr.garage-item:hover {
        background: var(--surface-2);
    }

    .vehicle-table td {
        padding: 12px 16px;
        color: var(--text-primary);
        font-weight: 300;
    }

    .garage-id {
        font-size: 11.5px;
        font-variant-numeric: tabular-nums;
        color: var(--text-muted);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 2px 9px;
        border-radius: 99px;
        display: inline-block;
    }

    .garage-name {
        font-weight: 500;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .garage-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #00e5c3;
        opacity: 0.7;
        flex-shrink: 0;
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

<div class="garages-section">
    <div class="vehicles-header">
        <h2 class="vehicles-title">Garages partenaires</h2>
        <span class="vehicles-count"><?= count($garages) ?> garage<?= count($garages) > 1 ? 's' : '' ?></span>
    </div>

    <?php if (empty($garages)) : ?>
        <div class="empty-state">
            <span style="font-size:36px;opacity:.3">🔧</span>
            <span style="font-size:14px;">Aucun garage enregistré.</span>
        </div>
    <?php else : ?>
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Nom du garage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($garages as $garage) : ?>
                    <tr class="garage-item" data-id="<?= $garage['id'] ?>">
                        <td><span class="garage-id"># <?= htmlspecialchars($garage['id']) ?></span></td>
                        <td>
                            <span class="garage-name">
                                <span class="garage-dot"></span>
                                <?= htmlspecialchars($garage['title']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>