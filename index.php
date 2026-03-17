<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool4cars - Assessment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b0c10;
            --surface: #13151c;
            --surface-2: #1c1f2b;
            --border: rgba(255, 255, 255, 0.07);
            --accent: #4f6ef7;
            --accent-glow: rgba(79, 110, 247, 0.18);
            --accent-2: #00e5c3;
            --text-primary: #eef0f8;
            --text-secondary: #7a7f9a;
            --text-muted: #454966;
            --danger: #ff4d6d;
            --success: #22d3a5;
            --radius: 14px;
            --radius-sm: 8px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Ambient background */
        body::before {
            content: '';
            position: fixed;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 900px;
            height: 600px;
            background: radial-gradient(ellipse at center, rgba(79, 110, 247, 0.12) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 64px;
            background: rgba(11, 12, 16, 0.82);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 17px;
            letter-spacing: -0.3px;
        }

        .logo-text span {
            color: var(--accent);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .client-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid var(--text-secondary);
            pointer-events: none;
        }

        #client-select {
            appearance: none;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            padding: 8px 36px 8px 14px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
            min-width: 140px;
        }

        #client-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        #client-select:hover {
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* ─── LAYOUT ─── */
        .app-layout {
            display: flex;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
            padding: 24px 16px;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-section {
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
            font-weight: 600;
            padding: 0 12px;
            margin-bottom: 6px;
            margin-top: 12px;
        }

        .sidebar-section:first-child {
            margin-top: 0;
        }

        .nav-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 400;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-align: left;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .nav-btn .btn-icon {
            width: 18px;
            height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-btn:hover {
            background: var(--surface-2);
            color: var(--text-primary);
        }

        .nav-btn:hover .btn-icon {
            opacity: 1;
        }

        .nav-btn.active {
            background: var(--accent-glow);
            color: var(--text-primary);
            font-weight: 500;
        }

        .nav-btn.active .btn-icon {
            opacity: 1;
        }

        .nav-btn.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            flex: 1;
            padding: 32px 36px;
            overflow: auto;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 26px;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 500;
            background: var(--accent-glow);
            border: 1px solid rgba(79, 110, 247, 0.3);
            color: #818cf8;
            padding: 3px 9px;
            border-radius: 99px;
            letter-spacing: 0.03em;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 6px;
            font-weight: 300;
        }

        /* ─── DYNAMIC DIV ─── */
        .dynamic-div {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            min-height: 420px;
            padding: 28px;
            position: relative;
            transition: opacity 0.2s;
        }

        .dynamic-div.loading {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Loading state */
        .loading-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            min-height: 300px;
            color: var(--text-muted);
        }

        .spinner {
            width: 32px;
            height: 32px;
            border: 2px solid var(--border);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 13px;
            letter-spacing: 0.03em;
        }

        /* Empty / error state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 300px;
            color: var(--text-muted);
            text-align: center;
        }

        .empty-icon {
            font-size: 40px;
            opacity: 0.4;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .empty-desc {
            font-size: 13px;
            max-width: 280px;
            line-height: 1.6;
        }

        /* Error state */
        .error-banner {
            background: rgba(255, 77, 109, 0.08);
            border: 1px solid rgba(255, 77, 109, 0.2);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            color: #ff8099;
        }

        /* ─── STATUS BAR ─── */
        .statusbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 32px;
            border-top: 1px solid var(--border);
            background: rgba(11, 12, 16, 0.6);
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .status-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--success);
            margin-right: 7px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dynamic-div {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Garage button hidden by default */
        #btn-garage {
            display: none;
        }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <header class="topbar">
        <div class="topbar-logo">
            <div class="logo-icon">🚗</div>
            <div class="logo-text">Tool<span>4cars</span></div>
        </div>
        <div class="topbar-right">
            <span class="client-label">Client</span>
            <div class="select-wrapper">
                <select id="client-select">
                    <option value="clienta">Client A</option>
                    <option value="clientb">Client B</option>
                    <option value="clientc">Client C</option>
                </select>
            </div>
        </div>
    </header>

    <!-- LAYOUT -->
    <div class="app-layout">

        <!-- SIDEBAR -->
        <nav class="sidebar">
            <div class="sidebar-section">Modules</div>

            <button class="nav-btn active" id="btn-cars" data-module="cars">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="8" width="22" height="10" rx="2" />
                    <path d="M5 8l3-5h8l3 5" />
                    <circle cx="7" cy="18" r="2" />
                    <circle cx="17" cy="18" r="2" />
                </svg>
                Voitures
            </button>

            <button class="nav-btn" id="btn-garage" data-module="garage">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                    <path d="M9 21V12h6v9" />
                </svg>
                Garages
            </button>
        </nav>

        <!-- MAIN -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">
                    Gestionnaire de véhicules
                    <span class="page-title-badge">Assessment</span>
                </h1>
                <p class="page-subtitle">Gérez les véhicules et garages de vos clients en temps réel.</p>
            </div>

            <div class="dynamic-div" data-module="cars" data-script="ajax">
                <div class="loading-state">
                    <div class="spinner"></div>
                    <span class="loading-text">Initialisation en cours…</span>
                </div>
            </div>
        </main>
    </div>

    <!-- STATUS BAR -->
    <footer class="statusbar">
        <span><span class="status-dot"></span>Système opérationnel</span>
        <span>Tool4cars — Assessment v1.0</span>
    </footer>

    <script>
        $(document).ready(function() {
            function getCookie(name) {
                let value = "; " + document.cookie;
                let parts = value.split("; " + name + "=");
                if (parts.length === 2) return parts.pop().split(";").shift();
                return "clienta";
            }

            function setLoading(on) {
                if (on) {
                    $('.dynamic-div').addClass('loading').html(`
                        <div class="loading-state">
                            <div class="spinner"></div>
                            <span class="loading-text">Chargement…</span>
                        </div>`);
                } else {
                    $('.dynamic-div').removeClass('loading');
                }
            }

            function refreshContent() {
                const client = getCookie("client_id");
                const module = $(".dynamic-div").attr("data-module");
                const url = `customs/${client}/modules/${module}/ajax.php`;

                setLoading(true);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('.dynamic-div').removeClass('loading').html(data);
                    },
                    error: function() {
                        $('.dynamic-div').removeClass('loading').html(`
                            <div class="empty-state">
                                <div class="empty-icon">⚠️</div>
                                <div class="empty-title">Fichier introuvable</div>
                                <div class="empty-desc">Le module demandé n'a pas pu être chargé pour ce client.</div>
                            </div>`);
                    }
                });
            }

            function updateNavigation() {
                const currentClient = $('#client-select').val();
                if (currentClient === 'clientb') {
                    $('#btn-garage').show();
                } else {
                    $('#btn-garage').hide();
                    if ($('.dynamic-div').attr('data-module') === 'garage') {
                        $('.dynamic-div').attr('data-module', 'cars');
                        setActiveNav('cars');
                    }
                }
            }

            function setActiveNav(module) {
                $('.nav-btn').removeClass('active');
                $(`.nav-btn[data-module="${module}"]`).addClass('active');
            }

            $('#client-select').on('change', function() {
                document.cookie = "client_id=" + $(this).val() + "; path=/";
                updateNavigation();
                refreshContent();
            });

            $('.nav-btn').on('click', function() {
                const module = $(this).data('module');
                $('.dynamic-div').attr('data-module', module);
                setActiveNav(module);
                refreshContent();
            });

            $(document).on('click', '.car-item, .garage-item', function() {
                const itemId = $(this).data('id');
                const client = getCookie("client_id");
                const module = $(".dynamic-div").attr("data-module");
                const url = `customs/${client}/modules/${module}/edit.php`;

                setLoading(true);

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        id: itemId
                    },
                    success: function(data) {
                        $('.dynamic-div').removeClass('loading').html(data);
                    }
                });
            });

            $(document).on('click', '.back-to-list', function() {
                refreshContent();
            });

            const currentClient = getCookie("client_id");
            $('#client-select').val(currentClient);
            updateNavigation();
            refreshContent();
        });
    </script>

</body>

</html>