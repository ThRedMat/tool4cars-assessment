<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool4cars - Assessment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Gestionnaire de véhicules</h1>

    <label for="client-select">Choisir un client :</label>
    <select id="client-select">
        <option value="clienta">Client A</option>
        <option value="clientb">Client B</option>
        <option value="clientc">Client C</option>
    </select>

    <div id="module-navigation" style="margin: 20px 0;">
        <button class="nav-btn" data-module="cars">Voitures</button>
        <button class="nav-btn" id="btn-garage" data-module="garage" style="display: none;">Garages</button>
    </div>

    <hr>

    <div class="dynamic-div" data-module="cars" data-script="ajax">
        Initialisation en cours...
    </div>

    <script>
        $(document).ready(function() {
            function getCookie(name) {
                let value = "; " + document.cookie;
                let parts = value.split("; " + name + "=");
                if (parts.length === 2) return parts.pop().split(";").shift();
                return "clienta";
            }

            function refreshContent() {
                const client = getCookie("client_id");
                const module = $(".dynamic-div").attr("data-module");
                const url = `customs/${client}/modules/${module}/ajax.php`;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('.dynamic-div').html(data);
                    },
                    error: function() {
                        $('.dynamic-div').html(`<p>Fichier introuvable.</p>`);
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
                    }
                }
            }

            $('#client-select').on('change', function() {
                document.cookie = "client_id=" + $(this).val() + "; path=/";
                updateNavigation();
                refreshContent();
            });

            $('.nav-btn').on('click', function() {
                $('.dynamic-div').attr('data-module', $(this).data('module'));
                refreshContent();
            });

            $(document).on('click', '.car-item, .garage-item', function() {
                const itemId = $(this).data('id');
                const client = getCookie("client_id");
                const module = $(".dynamic-div").attr("data-module");
                const url = `customs/${client}/modules/${module}/edit.php`;

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        id: itemId
                    },
                    success: function(data) {
                        $('.dynamic-div').html(data);
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