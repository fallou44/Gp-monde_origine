<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Cargaisons</title>
  <link href="/public/styles.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen">
  <div class="flex h-full">

  <!-- Sidebar --> <div class="bg-blue-900 text-white w-64 p-5 rounded-sm shadow-lg"> <h1 class="text-2xl  mb-5">GP-MONDE</h1>
   <ul> <li class="mb-3"> <a href="#" onclick="showSection('cargoSection')" class="hover:text-gray-300 flex items-center"> <i class="fas fa-plus-square mr-2"></i> <span class="">Ajouter Cargaison</span> </a> </li> <li class="mb-3"> <a href="#" onclick="showSection('productSection')" class="hover:text-gray-300 flex items-center"> <i class="fas fa-plus-square mr-2"></i> <span class="">Ajouter Produit</span> </a> </li> <li class="mb-3"> <a href="#" onclick="showSection('addProductToCargoSection')" class="hover:text-gray-300 flex items-center"> <i class="fas fa-link mr-2"></i> <span class="">Lier Produit-Cargaison</span> </a> </li> <li class="mb-3"> <a href="#" onclick="showSection('viewProductsInCargoSection')" class="hover:text-gray-300 flex items-center"> <i class="fas fa-eye mr-2"></i> <span class="">Voir Produits-Cargaison</span> </a> </li> </ul> </div>

    <!-- Main Content -->
    <div class="flex-1 p-5">
      
      <h1 class="text-3xl font-bold mb-5">DASHBOARD</h1>
      

      <!-- Section Ajouter Cargaison -->
      <div id="cargoSection" class="hidden flex">
        <!-- Formulaire d'ajout de cargaison -->
        <div class="w-1/3 h-80 bg-white p-5 shadow-lg rounded-xl mb-5">
          <h2 class="text-xl font-bold mb-3">Ajouter une Cargaison</h2>
          <form id="addCargoForm">
            <div class="mb-3">
              <label for="cargoType" class="block text-gray-700">Type de Cargaison</label>
              <select id="cargoType" class="w-full p-2 border border-gray-300 rounded">
                <option value="Aerienne">Aérienne</option>
                <option value="Maritime">Maritime</option>
                <option value="Routiere">Routière</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="distance" class="block text-gray-700">Distance (km)</label>
              <input type="number" id="distance" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Ajouter Cargaison</button>
          </form>
        </div>

        <!-- Liste des cargaisons -->
        <div class="w-2/3 bg-white p-5 shadow-lg rounded-xl mb-5 ml-5">
          <h2 class="text-xl font-bold mb-3">Cargaisons</h2>
          <ul id="cargosList">
            <!-- Les cargaisons seront ajoutées ici -->
          </ul>
        </div>
      </div>

      <!-- Section Ajouter Produit -->
      <div id="productSection" class="hidden flex">
        <!-- Formulaire d'ajout de produit -->
        <div class="w-1/3 h-96 bg-white p-5 shadow-lg rounded-xl mb-5">
          <h2 class="text-xl font-bold mb-3">Ajouter un Produit</h2>
          <form id="addProductForm">
            <div class="mb-3">
              <label for="productType" class="block text-gray-700">Type de Produit</label>
              <select id="productType" class="w-full p-2 border border-gray-300 rounded">
                <option value="Alimentaire">Alimentaire</option>
                <option value="Chimique">Chimique</option>
                <option value="Materiel">Matériel</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="productName" class="block text-gray-700">Libellé</label>
              <input type="text" id="productName" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
              <label for="productWeight" class="block text-gray-700">Poids (kg)</label>
              <input type="number" id="productWeight" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3 hidden" id="toxicityLevelContainer">
              <label for="toxicityLevel" class="block text-gray-700">Degré de Toxicité</label>
              <input type="number" id="toxicityLevel" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Ajouter Produit</button>
          </form>
        </div>

        <!-- Liste des produits -->
        <div class="w-2/3 bg-white  p-5 shadow-lg flex rounded-xl mb-5 ml-5">
          <h2 class="text-xl font-bold mb-3">Produits</h2>
          <ul id="productsList">
            <!-- Les produits seront ajoutés ici -->
          </ul>
        </div>
      </div>

      <!-- Section Ajouter Produit à une Cargaison -->
      <div id="addProductToCargoSection" class="hidden flex">
        <!-- Formulaire d'ajout de produit à une cargaison -->
        <div class="w-1/3 h-auto bg-white p-5 shadow-lg rounded-xl mb-5">
          <h2 class="text-xl font-bold mb-3">Ajouter un Produit à une Cargaison</h2>
          <form id="addProductToCargoForm">
            <div class="mb-3">
              <label for="cargoSelect" class="block text-gray-700">Sélectionner la Cargaison</label>
              <select id="cargoSelect" class="w-full p-2 border border-gray-300 rounded">
                <!-- Les options seront ajoutées dynamiquement -->
              </select>
            </div>
            <div class="mb-3">
              <label for="productSelect" class="block text-gray-700">Sélectionner le Produit</label>
              <select id="productSelect" class="w-full p-2 border border-gray-300 rounded">
                <!-- Les options seront ajoutées dynamiquement -->
              </select>
            </div>
            <div class="mb-3">
              <label for="quantity" class="block text-gray-700">Quantité</label>
              <input type="number" id="quantity" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
              <label for="details" class="block text-gray-700">Détails supplémentaires</label>
              <textarea id="details" class="w-full p-2 border border-gray-300 rounded"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Ajouter Produit</button>
          </form>
        </div>
        <!-- Liste des cargaisons -->
        <div class="w-2/3 bg-white p-5 shadow-lg rounded-xl mb-5 ml-5">
          <h2 class="text-xl font-bold mb-3">Cargaisons</h2>
          <ul id="cargosList">
            <!-- Les cargaisons seront ajoutées ici -->
          </ul>
        </div>
      </div>

      <!-- Section Voir Produits dans Cargaison -->
      <div id="viewProductsInCargoSection" class="hidden flex">
        <div class="w-full bg-white p-5 shadow-lg rounded-xl mb-5">
          <h2 class="text-xl font-bold mb-3">Voir Produits dans une Cargaison</h2>
          <div class="mb-3">
            <label for="viewCargoSelect" class="block text-gray-700">Sélectionner la Cargaison</label>
            <select id="viewCargoSelect" class="w-full p-2 border border-gray-300 rounded">
              <!-- Les options seront ajoutées dynamiquement -->
            </select>
          </div>
          <ul id="cargoProductsList" class="mt-5">
            <!-- Les produits seront ajoutés ici -->
            
          </ul>
        </div>
      </div>
    </div>
  </div>
<!-- popup -->

<!-- popup -->
  <script src="./node_modules/preline/dist/preline.js"></script>
  <script src="../dist/app.js" type="module"></script>
  <script>
    function showSection(sectionId) {
      document.getElementById('cargoSection').classList.add('hidden');
      document.getElementById('productSection').classList.add('hidden');
      document.getElementById('addProductToCargoSection').classList.add('hidden');
      document.getElementById('viewProductsInCargoSection').classList.add('hidden');
      document.getElementById(sectionId).classList.remove('hidden');
    }

    showSection('cargoSection');

    document.getElementById('productType').addEventListener('change', function() {
      const toxicityLevelContainer = document.getElementById('toxicityLevelContainer');
      if (this.value === 'Chimique') {
        toxicityLevelContainer.classList.remove('hidden');
      } else {
        toxicityLevelContainer.classList.add('hidden');
      }
    });

    function loadFromLocalStorage(key) {
      return JSON.parse(localStorage.getItem(key)) || [];
    }

    function saveToLocalStorage(key, data) {
      localStorage.setItem(key, JSON.stringify(data));
    }

    function populateOptions() {
      const cargoSelect = document.getElementById('cargoSelect');
      const productSelect = document.getElementById('productSelect');
      const viewCargoSelect = document.getElementById('viewCargoSelect');

      const cargos = loadFromLocalStorage('cargos');
      const products = loadFromLocalStorage('products');

      cargoSelect.innerHTML = '';
      productSelect.innerHTML = '';
      viewCargoSelect.innerHTML = '';

      cargos.forEach(cargo => {
        const option = document.createElement('option');
        option.value = cargo.id;
        option.textContent = `${cargo.type} - ${cargo.distance} km`;
        cargoSelect.appendChild(option);
        viewCargoSelect.appendChild(option.cloneNode(true));
      });

      products.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id;
        option.textContent = `${product.name} (${product.type})`;
        productSelect.appendChild(option);
      });
    }

    function viewProductsInCargo() {
      const cargoId = parseInt(document.getElementById('viewCargoSelect').value);
      const cargoProductsList = document.getElementById('cargoProductsList');

      const cargoProducts = loadFromLocalStorage('cargoProducts');
      const products = loadFromLocalStorage('products');

      cargoProductsList.innerHTML = '';

      const filteredProducts = cargoProducts.filter(cp => cp.cargoId === cargoId);
      filteredProducts.forEach(cp => {
        const product = products.find(p => p.id === cp.productId);
        const listItem = document.createElement('li');
        listItem.textContent = `${product.name} - Quantité: ${cp.quantity}`;
        cargoProductsList.appendChild(listItem);
      });
    }

    document.getElementById('viewCargoSelect').addEventListener('change', viewProductsInCargo);

    // Event listeners pour les formulaires d'ajout
    document.getElementById('addCargoForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const cargos = loadFromLocalStorage('cargos');
      const id = cargos.length ? cargos[cargos.length - 1].id + 1 : 1;
      const type = document.getElementById('cargoType').value;
      const distance = document.getElementById('distance').value;
      cargos.push({ id, type, distance });
      saveToLocalStorage('cargos', cargos);
      populateOptions();
      updateCargosList();
    });

    document.getElementById('addProductForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const products = loadFromLocalStorage('products');
      const id = products.length ? products[products.length - 1].id + 1 : 1;
      const type = document.getElementById('productType').value;
      const name = document.getElementById('productName').value;
      const weight = document.getElementById('productWeight').value;
      const toxicity = document.getElementById('toxicityLevel').value;
      const product = { id, type, name, weight };
      if (type === 'Chimique') {
        product.toxicity = toxicity;
      }
      products.push(product);
      saveToLocalStorage('products', products);
      populateOptions();
      updateProductsList();
    });

    document.getElementById('addProductToCargoForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const cargoProducts = loadFromLocalStorage('cargoProducts');
      const cargoId = parseInt(document.getElementById('cargoSelect').value);
      const productId = parseInt(document.getElementById('productSelect').value);
      const quantity = parseInt(document.getElementById('quantity').value);
      cargoProducts.push({ cargoId, productId, quantity });
      saveToLocalStorage('cargoProducts', cargoProducts);
      alert('Produit ajouté à la cargaison');
    });

    // Fonction pour mettre à jour la liste des cargaisons affichées
    function updateCargosList() {
      const cargosList = document.getElementById('cargosList');
      const cargos = loadFromLocalStorage('cargos');

      cargosList.innerHTML = '';

      cargos.forEach(cargo => {
        const listItem = document.createElement('li');
        listItem.textContent = `${cargo.type} - ${cargo.distance} km`;
        cargosList.appendChild(listItem);
      });
    }

    // Fonction pour mettre à jour la liste des produits affichés
    function updateProductsList() {
      const productsList = document.getElementById('productsList');
      const products = loadFromLocalStorage('products');

      productsList.innerHTML = '';

      products.forEach(product => {
        const listItem = document.createElement('li');
        listItem.textContent = `${product.name} (${product.type}) - ${product.weight} kg`;
        if (product.type === 'Chimique') {
          listItem.textContent += ` - Toxicité: ${product.toxicity}`;
        }
        productsList.appendChild(listItem);
      });
    }

    // Initialisation
    populateOptions();
    updateCargosList();
    updateProductsList();
  </script>
</body>
</html>
