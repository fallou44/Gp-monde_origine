// Types for Leaflet and Turf.js
/// <reference types="leaflet" />
/// <reference types="turf" />


import * as L from 'leaflet';
import * as turf from '@turf/turf'; // Importez également turf si ce n'est pas déjà fait


// Type definitions
interface Cargo {
    numero: string;
    poids_max: number;
    prix: number;
    depart: string;
    arrivee: string;
    distance: number;
    type: string;
    statut: string;
    etat: string;
}

// Sélectionner les éléments nécessaires
const openModalBtn = document.getElementById('open-cargo-modal') as HTMLButtonElement;
const cargoModal = document.getElementById('cargo-modal') as HTMLDivElement;
const cargoFormContainer = document.getElementById('cargo-form-container') as HTMLDivElement;

let departMarker: L.Marker | null = null;
let arriveeMarker: L.Marker | null = null;
let cargos: Cargo[] = [];
const pageSize = 4;
let currentPage = 1;

// Créer le formulaire d'ajout de cargaison
function createCargoForm(): void {
    const form = document.createElement('form');
    form.innerHTML = `
        <div>
            <label for="poids-max">Poids maximum</label>
            <input id="poids-max" type="number" placeholder="Entrez le poids maximum">
            <span class="error-message" id="error-poids-max">Veuillez entrer un poids maximum valide.</span>
        </div>
        <div>
            <label for="prix">Prix total</label>
            <input id="prix" type="number" placeholder="Entrez le prix total">
            <span class="error-message" id="error-prix">Veuillez entrer un prix total valide.</span>
        </div>
        <div>
            <label for="depart">Lieu de départ</label>
            <input id="depart" type="text" placeholder="Sélectionnez sur la carte" readonly>
            <span class="error-message" id="error-depart">Veuillez sélectionner un lieu de départ.</span>
        </div>
        <div>
            <label for="arrivee">Lieu d'arrivée</label>
            <input id="arrivee" type="text" placeholder="Sélectionnez sur la carte" readonly>
            <span class="error-message" id="error-arrivee">Veuillez sélectionner un lieu d'arrivée.</span>
        </div>
        <div>
            <label for="distance">Distance (km)</label>
            <input id="distance" type="number" placeholder="Calculée automatiquement" readonly>
            <span class="error-message" id="error-distance">La distance doit être calculée automatiquement.</span>
        </div>
        <div>
            <label for="type">Type de cargaison</label>
            <select id="type">
                <option value="">Sélectionnez un type</option>
                <option value="maritime">Maritime</option>
                <option value="aerienne">Aérienne</option>
                <option value="routiere">Routière</option>
            </select>
            <span class="error-message" id="error-type">Veuillez sélectionner un type de cargaison.</span>
        </div>
        <div>
            <label for="statut">État d'avancement</label>
            <select id="statut">
                <option value="">Sélectionnez un état</option>
                <option value="en-attente">En attente</option>
                <option value="en-cours">En cours</option>
                <option value="termine">Terminé</option>
            </select>
            <span class="error-message" id="error-statut">Veuillez sélectionner un état d'avancement.</span>
        </div>
        <div>
            <label for="etat">État global</label>
            <select id="etat">
                <option value="">Sélectionnez un état</option>
                <option value="ouvert">Ouvert</option>
                <option value="ferme">Fermé</option>
            </select>
            <span class="error-message" id="error-etat">Veuillez sélectionner un état global.</span>
        </div>
        <button id="btn-add-cargo" type="button">Ajouter la cargaison</button>
    `;
    cargoFormContainer.appendChild(form);
}

// Ouvrir le modal
openModalBtn.addEventListener('click', () => {
    cargoModal.classList.remove('hidden');
    createCargoForm();
});

// Fermer le modal
cargoModal.addEventListener('click', (event) => {
    if (event.target === cargoModal) {
        cargoModal.classList.add('hidden');
    }
});

// Initialize the map and set its view to the coordinates of Senegal
const map = L.map('map').setView([14.4974, -14.4524], 6);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Custom icon
const customIcon = L.divIcon({
    className: 'custom-marker',
    html: '<i class="fas fa-map-marker-alt" style="color: #19d28b; text-shadow: 1px 1px 2px #484c4a;"></i>',
    iconSize: [24, 24],
    iconAnchor: [12, 24]
});



map.on('click', function(e: L.LeafletMouseEvent) {
    if (!departMarker) {
        departMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        (document.getElementById('depart') as HTMLInputElement).value = `${e.latlng.lat}, ${e.latlng.lng}`;
        reverseGeocode(e.latlng, 'depart');
    } else if (!arriveeMarker) {
        arriveeMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        (document.getElementById('arrivee') as HTMLInputElement).value = `${e.latlng.lat}, ${e.latlng.lng}`;
        reverseGeocode(e.latlng, 'arrivee');
        calculateDistance();
    } else {
        map.removeLayer(departMarker);
        map.removeLayer(arriveeMarker);
        departMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        (document.getElementById('depart') as HTMLInputElement).value = `${e.latlng.lat}, ${e.latlng.lng}`;
        (document.getElementById('arrivee') as HTMLInputElement).value = '';
        (document.getElementById('distance') as HTMLInputElement).value = '';
        arriveeMarker = null;
        reverseGeocode(e.latlng, 'depart');
    }
});

function calculateDistance(): void {
    if (departMarker && arriveeMarker) {
        const depart = departMarker.getLatLng();
        const arrivee = arriveeMarker.getLatLng();

        const from = turf.point([depart.lng, depart.lat]);
        const to = turf.point([arrivee.lng, arrivee.lat]);
        const options: turf.DistancesOptions = { units: 'kilometers' };

        const distance = turf.distance(from, to, options);
        (document.getElementById('distance') as HTMLInputElement).value = distance.toFixed(2);
    }
}


function reverseGeocode(latlng: L.LatLng, inputId: string): void {
    const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const placeName = data.display_name;
            (document.getElementById(inputId) as HTMLInputElement).value = placeName;
        })
        .catch(error => console.log('Error:', error));
}

// Fonction pour charger les cargaisons depuis le fichier JSON
function loadCargos(): void {
    fetch('php/cargo.php')
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Erreur lors de la récupération des cargaisons');
            }
        })
        .then(data => {
            cargos = data; // Stocker les cargaisons récupérées
            updateCargos(); // Mettre à jour le tableau des cargaisons
        })
        .catch(error => console.log('Error:', error));
}

// Fonction pour mettre à jour le tableau des cargaisons en fonction des critères de filtrage et de pagination
function updateCargos(): void {
    const filterNumero = (document.getElementById('filter-numero') as HTMLInputElement).value.toLowerCase();
    const filterPrixTotal = (document.getElementById('filter-prix-total') as HTMLInputElement).value.toLowerCase();
    const filterDepart = (document.getElementById('filter-depart') as HTMLInputElement).value.toLowerCase();
    const filterArrivee = (document.getElementById('filter-arrivee') as HTMLInputElement).value.toLowerCase();

    // Filtrer les cargaisons selon les critères
    const filteredCargos = cargos.filter(cargo =>
        cargo.numero.toLowerCase().includes(filterNumero) &&
        (filterPrixTotal === '' || cargo.prix.toString().toLowerCase().includes(filterPrixTotal)) &&
        cargo.depart.toLowerCase().includes(filterDepart) &&
        cargo.arrivee.toLowerCase().includes(filterArrivee)
    );

    // Paginer les cargaisons filtrées
    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const paginatedCargos = filteredCargos.slice(start, end);

    // Afficher les cargaisons paginées
    afficherCragos(paginatedCargos);

    // Afficher la pagination
    afficherPagination(filteredCargos.length);
}

// Ajouter un écouteur d'événement pour les champs de recherche/filtrage
const searchInputs = document.querySelectorAll('input[type="text"], input[type="number"]');
searchInputs.forEach(input => {
    input.addEventListener('input', function() {
        currentPage = 1; // Réinitialiser la page actuelle lors de la modification des critères de recherche
        updateCargos();
    });
});

// Fonction pour afficher les cargaisons dans le tableau
function afficherCragos(cargos: Cargo[]): void {
    const tableBody = document.getElementById('cargo-table-body') as HTMLTableSectionElement;
    tableBody.innerHTML = ''; // Effacer le contenu existant du tableau
    cargos.forEach(cargo => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.numero}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.poids_max}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.prix}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.depart}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.arrivee}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.distance}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.type}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${cargo.statut}</td>
            <td class="py-2 px-4 text-sm">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${cargo.etat === 'ouvert' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${cargo.etat}</span>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Fonction pour afficher la pagination
function afficherPagination(totalCargos: number): void {
    const totalPages = Math.ceil(totalCargos / pageSize);
    const paginationContainer = document.getElementById('pagination') as HTMLDivElement;
    paginationContainer.innerHTML = ''; // Effacer la pagination existante

    if (totalPages > 1) {
        for (let i = 1; i <= totalPages; i++) {
            const pageLink = document.createElement('button');
            pageLink.textContent = i.toString();
            pageLink.classList.add('mx-1', 'px-3', 'py-1', 'bg-gray-200', 'text-gray-800', 'border', 'border-gray-300', 'rounded', 'hover:bg-gray-300', 'focus:outline-none', 'focus:bg-gray-300');
            if (i === currentPage) {
                pageLink.classList.add('bg-gray-400', 'font-bold');
            }
            pageLink.addEventListener('click', function() {
                currentPage = i;
                updateCargos();
            });
            paginationContainer.appendChild(pageLink);
        }
    }
}

// Charger les cargaisons au chargement initial de la page
document.addEventListener('DOMContentLoaded', loadCargos);

document.getElementById('cargo-form-container')!.addEventListener('click', function (event) {
    if ((event.target as HTMLElement).id === 'btn-add-cargo') {
        const poidsMax = document.getElementById('poids-max') as HTMLInputElement;
        const prix = document.getElementById('prix') as HTMLInputElement;
        const depart = document.getElementById('depart') as HTMLInputElement;
        const arrivee = document.getElementById('arrivee') as HTMLInputElement;
        const distance = document.getElementById('distance') as HTMLInputElement;
        const type = document.getElementById('type') as HTMLSelectElement;
        const statut = document.getElementById('statut') as HTMLSelectElement;
        const etat = document.getElementById('etat') as HTMLSelectElement;
        const dateDepart = document.getElementById('date-depart') as HTMLInputElement;
        const dateArrivee = document.getElementById('date-arrivee') as HTMLInputElement;
        const cargoPlein = document.querySelector('input[name="cargo-plein"]:checked') as HTMLInputElement;

        let valid = true;

        if (poidsMax.value === '' || isNaN(Number(poidsMax.value)) || parseFloat(poidsMax.value) <= 0) {
            document.getElementById('error-poids-max')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-poids-max')!.style.display = 'none';
        }

        if (prix.value === '' || isNaN(Number(prix.value)) || parseFloat(prix.value) <= 0) {
            document.getElementById('error-prix')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-prix')!.style.display = 'none';
        }

        if (depart.value === '') {
            document.getElementById('error-depart')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-depart')!.style.display = 'none';
        }

        if (arrivee.value === '') {
            document.getElementById('error-arrivee')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-arrivee')!.style.display = 'none';
        }

        if (distance.value === '' || isNaN(Number(distance.value)) || parseFloat(distance.value) <= 0) {
            document.getElementById('error-distance')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-distance')!.style.display = 'none';
        }

        if (type.value === '') {
            document.getElementById('error-type')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-type')!.style.display = 'none';
        }

        if (statut.value === '') {
            document.getElementById('error-statut')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-statut')!.style.display = 'none';
        }

        if (etat.value === '') {
            document.getElementById('error-etat')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-etat')!.style.display = 'none';
        }

        if (dateDepart.value === '') {
            document.getElementById('error-date-depart')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-date-depart')!.style.display = 'none';
        }

        if (dateArrivee.value === '') {
            document.getElementById('error-date-arrivee')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-date-arrivee')!.style.display = 'none';
        }

        // Vérification supplémentaire pour les dates
        const departDate = new Date(dateDepart.value);
        const arriveeDate = new Date(dateArrivee.value);

        if (departDate > arriveeDate) {
            document.getElementById('error-date-arrivee')!.textContent = 'La date d\'arrivée ne peut pas être antérieure à la date de départ.';
            document.getElementById('error-date-arrivee')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-date-arrivee')!.style.display = 'none';
        }

        if (!cargoPlein) {
            document.getElementById('error-cargo-plein')!.style.display = 'inline';
            valid = false;
        } else {
            document.getElementById('error-cargo-plein')!.style.display = 'none';
        }

        if (valid) {
            const numero = 'CGN' + Math.floor(Math.random() * 1000);  // Génération d'un numéro de cargaison unique

            const cargo = {
                numero: numero,
                poids_max: poidsMax.value,
                prix: prix.value,
                depart: depart.value,
                arrivee: arrivee.value,
                distance: distance.value,
                type: type.value,
                statut: statut.value,
                etat: etat.value,
                date_depart: dateDepart.value,
                date_arrivee: dateArrivee.value,
                cargo_plein: cargoPlein.value
            };


            fetch('php/cargo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cargo)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);  // Log the raw response
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.success) {
                        alert('Cargaison ajoutée avec succès');
                        loadCargos();  // Recharger les cargaisons pour afficher la nouvelle entrée
                        cargoModal.classList.add('hidden');  // Fermer le modal
                    } else {
                        alert('Erreur: ' + jsonData.message);
                    }
                } catch (e) {
                    console.error('Erreur de parsing JSON:', e);
                    console.error('Données reçues:', data);
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            alert('Veuillez corriger les erreurs avant de soumettre le formulaire.');
        }
    }
});
