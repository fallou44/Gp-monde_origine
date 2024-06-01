<?php
$dataFile = 'data.json';

// Load existing data
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
} else {
    $data = [];
}

// Handle POST request to add new cargo or product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Données JSON invalides: ' . json_last_error_msg()]);
        exit;
    }

    if (isset($input['numero']) && isValidCargo($input)) {
        // Adding new cargo
        $data[] = $input;
        $responseMessage = 'Cargaison ajoutée avec succès.';
    } elseif (isset($input['cargo_numero']) && isset($input['produit']) && isValidProduit($input['produit'])) {
        // Adding new product to existing cargo
        $cargoIndex = findCargoIndex($data, $input['cargo_numero']);
        if ($cargoIndex !== -1) {
            $cargo = &$data[$cargoIndex];

            // Check if cargo is closed
            if ($cargo['etat'] === 'ferme') {
                echo json_encode(['success' => false, 'message' => 'La cargaison est fermée et ne peut plus recevoir de produit.']);
                exit;
            }

            // Check product constraints
            $produit = $input['produit'];
            if ($produit['type'] === 'chimique' && $cargo['type'] !== 'maritime') {
                echo json_encode(['success' => false, 'message' => 'Les produits chimiques doivent être transportés par voie maritime.']);
                exit;
            }
            if ($produit['type'] === 'materiel' && $produit['type_materiel'] === 'cassable' && $cargo['type'] === 'maritime') {
                echo json_encode(['success' => false, 'message' => 'Les produits fragiles ne doivent pas être transportés par voie maritime.']);
                exit;
            }

            // Check if cargo is full (implement your own logic for this check)
            if (isCargoFull($cargo)) {
                echo json_encode(['success' => false, 'message' => 'La cargaison est pleine et ne peut plus recevoir de produit.']);
                exit;
            }

            $cargo['produits'][] = $produit;
            $cargo['prix'] += calculateProductPrice($produit);

            $responseMessage = 'Produit ajouté avec succès.';
        } else {
            echo json_encode(['success' => false, 'message' => 'Cargaison non trouvée.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données invalides.']);
        exit;
    }

    try {
        if (!is_writable($dataFile)) {
            throw new Exception('Le fichier n\'est pas accessible en écriture.');
        }
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true, 'message' => $responseMessage, 'updatedCargo' => $cargo ?? null]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'écriture du fichier JSON: ' . $e->getMessage()]);
    }
    exit;
}

// Validate cargo data
function isValidCargo($cargo) {
    return isset($cargo['numero']) && isset($cargo['poids_max']) && isset($cargo['prix']) &&
           isset($cargo['depart']) && isset($cargo['arrivee']) && isset($cargo['distance']) &&
           isset($cargo['type']) && isset($cargo['statut']) && isset($cargo['etat']) &&
           isset($cargo['date_depart']) && isset($cargo['date_arrivee']) && isset($cargo['cargo_plein']) &&
           is_array($cargo['produits']);
}

// Validate product data
function isValidProduit($produit) {
    return isset($produit['nom']) && isset($produit['poids']) && isset($produit['type']) &&
           isset($produit['etat']) && isset($produit['client']) && isset($produit['destinataire']) &&
           isValidClientOrDestinataire($produit['client']) && isValidClientOrDestinataire($produit['destinataire']);
}

// Validate client or destinataire data
function isValidClientOrDestinataire($person) {
    return isset($person['nom']) && isset($person['prenom']) && isset($person['telephone']) && isset($person['adresse']);
}

// Find cargo index by numero
function findCargoIndex($data, $numero) {
    foreach ($data as $index => $cargo) {
        if ($cargo['numero'] === $numero) {
            return $index;
        }
    }
    return -1;
}

// Check if cargo is full (implement your own logic)
function isCargoFull($cargo) {
    return isset($cargo['cargo_plein']) && $cargo['cargo_plein'] === 'oui';
}

// Calculate the price of the product (implement your own logic)
function calculateProductPrice($produit) {
    // This is just an example, replace with actual price calculation logic
    return $produit['poids'] * 10;
}
?>
