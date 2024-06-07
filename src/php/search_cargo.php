<?php
$cargoDataFile = 'data.json'; // Chemin vers votre fichier JSON contenant les informations sur les cargaisons.
$cargoData = json_decode(file_get_contents($cargoDataFile), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Erreur de lecture du fichier JSON : ' . json_last_error_msg();
    exit;
}

$productCode = $_GET['cargo_code'] ?? '';

if (!$productCode) {
    echo 'Aucun code de produit fourni';
    exit;
}

$productInfo = null;
$cargoInfo = null;

foreach ($cargoData as $cargo) {
    if (isset($cargo['produits']) && is_array($cargo['produits'])) {
        foreach ($cargo['produits'] as $produit) {
            if ($produit['code'] === $productCode) {
                $productInfo = $produit;
                $cargoInfo = $cargo;
                break 2; // Sortir des deux boucles
            }
        }
    }
}

if (!$productInfo) {
    echo 'Produit non trouvé';
    exit;
}

$client = $productInfo['client'];
$destinataire = $productInfo['destinataire'];

// Extraire les coordonnées des champs 'depart' et 'arrivee'
function extractCoordinates($location) {
    preg_match('/\(([^)]+)\)/', $location, $matches);
    if (isset($matches[1])) {
        return explode(', ', $matches[1]);
    }
    return null;
}

$departureCoordinates = extractCoordinates($cargoInfo['depart']);
$arrivalCoordinates = extractCoordinates($cargoInfo['arrivee']);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <title>Details du Produit</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 mt-20">Détails du Produit</h1>
        <div class="bg-white shadow-xl rounded-lg p-4 mt-20 ">
            <p><strong>Code Produit:</strong> <?php echo htmlspecialchars($productCode); ?></p>
            <p><strong>Nom Client:</strong> <?php echo htmlspecialchars($client['nom']); ?></p>
            <p><strong>Prénom Client:</strong> <?php echo htmlspecialchars($client['prenom']); ?></p>
            <p><strong>Nom Destinataire:</strong> <?php echo htmlspecialchars($destinataire['nom']); ?></p>
            <p><strong>Prénom Destinataire:</strong> <?php echo htmlspecialchars($destinataire['prenom']); ?></p>
            <p><strong>Type de Produit:</strong> <?php echo htmlspecialchars($productInfo['type_produit']); ?></p>
            <p><strong>Poids:</strong> <?php echo htmlspecialchars($productInfo['poids']); ?></p>
            <p><strong>Type Matériel:</strong> <?php echo htmlspecialchars($productInfo['type_materiel']); ?></p>
            <p><strong>État:</strong> <?php echo htmlspecialchars($productInfo['etat']); ?></p>
            <div id="map"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([14.692, -17.446], 6); // Vue initiale centrée sur le Sénégal

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var departureCoordinates = <?php echo json_encode($departureCoordinates); ?>;
            var arrivalCoordinates = <?php echo json_encode($arrivalCoordinates); ?>;

            var departureMarker = L.marker(departureCoordinates).addTo(map)
                .bindPopup('Départ: ' + <?php echo json_encode($cargoInfo['depart']); ?>)
                .openPopup();

            var arrivalMarker = L.marker(arrivalCoordinates).addTo(map)
                .bindPopup('Arrivée: ' + <?php echo json_encode($cargoInfo['arrivee']); ?>);

            // Déterminer la couleur de la ligne en fonction de l'état
            var etat = <?php echo json_encode($productInfo['etat']); ?>;
            var lineColor;
            switch(etat) {
                case 'Perdu':
                    lineColor = 'red';
                    break;
                case 'Terminé':
                    lineColor = 'green';
                    break;
                case 'en-cours':
                    lineColor = 'orange';
                    break;
                default:
                    lineColor = 'blue'; // Couleur par défaut
            }

            var route = L.polyline([departureCoordinates, arrivalCoordinates], {color: lineColor}).addTo(map);

            map.fitBounds(route.getBounds());
        });
    </script>
</body>
</html>
