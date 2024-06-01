<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Path to data.json file
$dataFile = 'data.json';

// Read the JSON data from the file
try {
    if (!file_exists($dataFile)) {
        file_put_contents($dataFile, '[]');
    }
    $data = json_decode(file_get_contents($dataFile), true);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur de décodage JSON: ' . json_last_error_msg());
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la lecture du fichier JSON: ' . $e->getMessage()]);
    exit;
}

// Handle POST request to add new cargo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Données JSON invalides: ' . json_last_error_msg()]);
        exit;
    }

    if (isValidCargo($input)) {
        $data[] = $input;
        try {
            if (!is_writable($dataFile)) {
                throw new Exception('Le fichier n\'est pas accessible en écriture.');
            }
            file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'message' => 'Cargaison ajoutée avec succès.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'écriture du fichier JSON: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données de cargaison invalides.']);
    }
    exit;
}



// Validate cargo data
function isValidCargo($cargo) {
    return isset($cargo['numero']) && isset($cargo['poids_max']) && isset($cargo['prix']) &&
           isset($cargo['depart']) && isset($cargo['arrivee']) && isset($cargo['distance']) &&
           isset($cargo['type']) && isset($cargo['statut']) && isset($cargo['etat']);
}

// Handle GET request to fetch cargos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($data);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Méthode non supportée.']);
?>
