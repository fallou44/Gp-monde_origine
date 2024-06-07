<?php
// Affichage des erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Définir le header JSON
header('Content-Type: application/json');

// Inclusion de l'autoloader de Composer
require 'vendor/autoload.php';  // Assurez-vous que ce chemin est correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Chemin vers le fichier data.json
$dataFile = 'data.json';

// Lire les données JSON depuis le fichier
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

// Fonction pour valider les données de cargaison
function isValidCargo($cargo) {
    return isset($cargo['numero']) && isset($cargo['poids_max']) && isset($cargo['prix']) &&
           isset($cargo['depart']) && isset($cargo['arrivee']) && isset($cargo['distance']) &&
           isset($cargo['type']) && isset($cargo['statut']) && isset($cargo['etat']) &&
           isset($cargo['date_arrivee']) && is_array($cargo['produits']);
}

// Fonction pour envoyer un email avec PHPMailer
function envoyerMail($cargo) {
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'seck22331@gmail.com';  // Remplacez par votre adresse email
        $mail->Password = 'yjri kxet dpjn xvxc';  // Remplacez par votre mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $subject = "Statut de votre cargaison";
        $body = "Le statut de la cargaison a changé à : " . $cargo['statut'];

        // Envoyer l'email au client et destinataire
        foreach ($cargo['produits'] as $produit) {
            $clientEmail = $produit['client']['email'];
            $destinataireEmail = $produit['destinataire']['email'];

            // Envoyer l'email au client
            $mail->setFrom('seck22331@gmail.com', 'Votre Compagnie de Transport');
            $mail->addAddress($clientEmail);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "Cher(e) {$produit['client']['prenom']} {$produit['client']['nom']},<br><br> $body";

            $mail->send();
            $mail->clearAddresses();

            // Envoyer l'email au destinataire
            $mail->addAddress($destinataireEmail);
            $mail->Body = "Cher(e) {$produit['destinataire']['prenom']} {$produit['destinataire']['nom']},<br><br> $body";

            $mail->send();
            $mail->clearAddresses();
        }

        echo json_encode(['success' => true, 'message' => 'Email envoyé avec succès.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Erreur lors de l'envoi de l'email: {$mail->ErrorInfo}"]);
    }
}

// Gestion des requêtes POST pour ajouter une nouvelle cargaison
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

// Gestion des requêtes PUT pour mettre à jour le statut ou l'état de la cargaison
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Données JSON invalides: ' . json_last_error_msg()]);
        exit;
    }

    $numero = $input['numero'];
    $statut = $input['statut'] ?? null;
    $etat = $input['etat'] ?? null;

    $updated = false;
    $currentDate = date('Y-m-d');

    foreach ($data as &$cargo) {
        if ($cargo['numero'] === $numero) {
            if ($statut) {
                if ($statut === 'Arrivé') {
                    if ($cargo['date_arrivee'] !== $currentDate) {
                        echo json_encode(['success' => false, 'message' => 'Une cargaison ne peut être marquée comme arrivée que si la date d\'arrivée correspond à la date actuelle.']);
                        exit;
                    }
                    $cargo['statut'] = 'Terminé';
                } elseif ($statut === 'Perdu') {
                    if ($cargo['statut'] !== 'en-cours' || $cargo['etat'] !== 'ferme') {
                        echo json_encode(['success' => false, 'message' => 'Une cargaison peut être marquée comme perdue seulement si son statut est en cours et son état est fermé.']);
                        exit;
                    }
                    $cargo['statut'] = 'Perdu';
                    foreach ($cargo['produits'] as &$produit) {
                        $produit['etat'] = 'Perdu';
                    }
                } elseif ($statut === 'en-cours') {
                    if ($cargo['statut'] !== 'en-attente' || $cargo['etat'] !== 'ferme') {
                        echo json_encode(['success' => false, 'message' => 'Condition non remplie pour mettre en cours.']);
                        exit;
                    }
                    if (empty($cargo['produits'])) {
                        echo json_encode(['success' => false, 'message' => 'Une cargaison vide ne peut pas être mise en cours.']);
                        exit;
                    }
                    $cargo['statut'] = 'en-cours';
                } else {
                    echo json_encode(['success' => false, 'message' => 'Statut non reconnu.']);
                    exit;
                }
            }

            if ($etat) {
                if ($cargo['statut'] === 'Perdu') {
                    echo json_encode(['success' => false, 'message' => 'Une cargaison perdue ne peut pas être fermée ni ouverte.']);
                    exit;
                }
                if ($etat === 'ouvert' && $cargo['statut'] === 'en-cours') {
                    echo json_encode(['success' => false, 'message' => 'Une cargaison en cours ne peut pas être ouverte.']);
                    exit;
                }
                if ($etat === 'ferme' && ($cargo['etat'] === 'ferme' || $cargo['statut'] === 'Perdu')) {
                    echo json_encode(['success' => false, 'message' => 'Une cargaison fermée ou perdue ne peut pas être fermée ni ouverte à nouveau.']);
                    exit;
                }
                if ($etat === 'ferme' && $cargo['statut'] === 'en-cours') {
                    echo json_encode(['success' => false, 'message' => 'Une cargaison en cours ne peut pas être fermée.']);
                    exit;
                }
                $cargo['etat'] = $etat;
            }

            // Envoi de l'email si le statut est "Terminé" ou "Perdu"
            if ($cargo['statut'] === 'Terminé' || $cargo['statut'] === 'Perdu') {
                envoyerMail($cargo);
            }

            $updated = true;
            break;
        }
    }

    if ($updated) {
        try {
            file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'message' => 'Cargaison mise à jour avec succès.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'écriture du fichier JSON: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Cargaison non trouvée.']);
    }
    exit;
}

// Gestion des requêtes GET pour récupérer les cargaisons
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($data);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Méthode non supportée.']);
?>
