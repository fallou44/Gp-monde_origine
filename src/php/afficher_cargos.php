<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

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
    echo 'Erreur lors de la lecture du fichier JSON: ' . $e->getMessage();
    exit;
}

// Function to generate the table rows
function generateCargoRows($cargos) {
    $rows = '';
    foreach ($cargos as $cargo) {
        $etatClass = $cargo['etat'] === 'ouvert' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
        $rows .= "<tr>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['numero']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['poids_max']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['prix']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['depart']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['arrivee']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['distance']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['type']}</td>
            <td class='py-2 px-4 text-sm text-gray-500'>{$cargo['statut']}</td>
            <td class='py-2 px-4 text-sm'>
                <span class='inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {$etatClass}'>{$cargo['etat']}</span>
            </td>
        </tr>";
    }
    return $rows;
}

// Generate the HTML table'
echo "<table class='min-w-full divide-y divide-gray-200'>
    <thead>
        <tr>
            <th class='py-2 px-4 text-sm text-gray-500'>Numéro</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Poids Max</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Prix</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Départ</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Arrivée</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Distance</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Type</th>
            <th class='py-2 px-4 text-sm text-gray-500'>Statut</th>
            <th class='py-2 px-4 text-sm text-gray-500'>État</th>
        </tr>
    </thead>
    <tbody id='cargo-table-body'>
        " . generateCargoRows($data) . "
    </tbody>
</table>";
?>
