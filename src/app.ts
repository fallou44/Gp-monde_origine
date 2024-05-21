import { Aerienne } from './classes/Aerienne.js';
import { Maritime } from './classes/Maritime.js';
import { Routiere } from './classes/Routiere.js';
import { Alimentaire } from './classes/Alimentaire.js';
import { Chimique } from './classes/Chimique.js';
import { Materiel } from './classes/Materiel.js';
import {Produit }from './classes/Produit.js';
import {Cargaison }from './classes/Cargaison.js';

// Stockage des cargaisons et produits
const cargos: Cargaison[] = [];
const produits: Produit[] = [];

// Gérer l'ajout de cargaison
document.getElementById('addCargoForm')!.addEventListener('submit', (event) => {
  event.preventDefault();
  let cargo: Cargaison | null = null; // Initialisation avec null
  
  const cargoType = (document.getElementById('cargoType') as HTMLSelectElement).value;
  const distance = parseFloat((document.getElementById('distance') as HTMLInputElement).value);
  
  switch (cargoType) {
    case 'Aerienne':
      cargo = new Aerienne(distance);
      break;
    case 'Maritime':
      cargo = new Maritime(distance);
      break;
    case 'Routiere':
      cargo = new Routiere(distance);
      break;
  }

  if (cargo !== null) { // Vérifier si cargo a été assigné
    cargos.push(cargo);
    updateCargosList();
  }
});

// Gérer l'ajout de produit
document.getElementById('addProductForm')!.addEventListener('submit', (event) => {
  event.preventDefault();
  let product: Produit | null = null; // Initialisation avec null
  
  const productType = (document.getElementById('productType') as HTMLSelectElement).value;
  const productName = (document.getElementById('productName') as HTMLInputElement).value;
  const productWeight = parseFloat((document.getElementById('productWeight') as HTMLInputElement).value);
  
  switch (productType) {
    case 'Alimentaire':
      product = new Alimentaire(productName, productWeight);
      break;
    case 'Chimique':
      const toxicityLevel = parseFloat((document.getElementById('toxicityLevel') as HTMLInputElement).value);
      product = new Chimique(productName, productWeight, toxicityLevel);
      break;
    case 'Materiel':
      product = new Materiel(productName, productWeight);
      break;
  }

  if (product !== null) { // Vérifier si product a été assigné
    produits.push(product);
    updateProductsList();
  }
});

// Afficher ou masquer le champ "Degré de Toxicité" en fonction du type de produit sélectionné
document.getElementById('productType')!.addEventListener('change', (event) => {
  const selectedType = (event.target as HTMLSelectElement).value;
  const toxicityLevelContainer = document.getElementById('toxicityLevelContainer');
  if (selectedType === 'Chimique') {
    toxicityLevelContainer!.style.display = 'block';
  } else {
    toxicityLevelContainer!.style.display = 'none';
  }
});

// Mise à jour de la liste des cargaisons
function updateCargosList() {
  const cargosList = document.getElementById('cargosList');
  cargosList!.innerHTML = cargos.map((cargo, index) => `
    <div class="mb-3 p-3 border border-gray-200 rounded">
      <h3 class="font-bold">Cargaison ${index + 1} (${cargo.constructor.name})</h3>
      <p>Distance: ${cargo.distance} km</p>
      <p>Nombre de produits: ${cargo.nbProduit()}</p>
      <p>Montant total: ${cargo.sommetotaleC()} F</p>
    </div>
  `).join('');
}

// Mise à jour de la liste des produits
function updateProductsList() {
  const productsList = document.getElementById('productsList');
  productsList!.innerHTML = produits.map((product, index) => `
    <div class="mb-3 p-3 border border-gray-200 rounded">
      <h3 class="font-bold">Produit ${index + 1} (${product.constructor.name})</h3>
      <p>Libellé: ${product.libelle}</p>
      <p>Poids: ${product.poids} kg</p>
      ${product instanceof Chimique ? `<p>Degré de toxicité: ${product.degreToxicite}</p>` : ''}
    </div>
  `).join('');
}

