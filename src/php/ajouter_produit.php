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

// Handle POST request to add a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Données JSON invalides: ' . json_last_error_msg()]);
        exit;
    }

    if (isValidProduct($input)) {
        $cargoId = $input['cargo_id'];
        $product = [
            'code' => $input['code'],
            'poids' => $input['poids'],
            'type_produit' => $input['type_produit'],
            'degre_toxicite' => $input['degre_toxicite'] ?? null,
            'type_materiel' => $input['type_materiel'] ?? null,
            'etat' => $input['etat'],
            'client' => [
                'nom' => $input['client_nom'],
                'prenom' => $input['client_prenom'],
                'telephone' => $input['client_telephone'],
                'adresse' => $input['client_adresse']
            ],
            'destinataire' => [
                'nom' => $input['destinataire_nom'],
                'prenom' => $input['destinataire_prenom'],
                'telephone' => $input['destinataire_telephone'],
                'adresse' => $input['destinataire_adresse']
            ]
        ];

        foreach ($data as &$cargo) {
            if ($cargo['numero'] === $cargoId) {
                if (!isset($cargo['produits'])) {
                    $cargo['produits'] = [];
                }
                $cargo['produits'][] = $product;
                break;
            }
        }

        try {
            if (!is_writable($dataFile)) {
                throw new Exception('Le fichier n\'est pas accessible en écriture.');
            }
            file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'message' => 'Produit ajouté avec succès.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'écriture du fichier JSON: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données de produit invalides.']);
    }
    exit;
}

// Validate product data
function isValidProduct($product) {
    return isset($product['cargo_id']) && isset($product['code']) && isset($product['poids']) &&
           isset($product['type_produit']) && isset($product['etat']) &&
           isset($product['client_nom']) && isset($product['client_prenom']) &&
           isset($product['client_telephone']) && isset($product['client_adresse']) &&
           isset($product['destinataire_nom']) && isset($product['destinataire_prenom']) &&
           isset($product['destinataire_telephone']) && isset($product['destinataire_adresse']);
}
?>
