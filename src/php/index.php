<!-- component -->
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@turf/turf/turf.min.js"></script>
    <style>
        .hidden {
    display: none;
}

.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.mt-2 {
    margin-top: 0.5rem;
}

.w-48 {
    width: 12rem;
}

.bg-white {
    background-color: white;
}

.border {
    border-width: 1px;
}

.border-gray-200 {
    border-color: #E5E7EB;
}

.rounded-md {
    border-radius: 0.375rem;
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.text-sm {
    font-size: 0.875rem;
}

.text-gray-700 {
    color: #4B5563;
}

.hover\:bg-gray-100:hover {
    background-color: #F3F4F6;
}

.block {
    display: block;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

        [x-cloak] {
            display: none !important;
        }
        #map {
            height: 200px;
            border-radius: 10px;
        }
        .custom-marker {
            font-size: 24px;
            color: #19d28b;
            text-shadow: 1px 1px 2px #484c4a;
        }

        .error-message {
            color: red;
            font-size: 0.875rem;
            display: none;
        }



        .max-w-2xl {
    max-width: 772px ;
}


    </style>
</head>

<body class="relative antialiased bg-gray-100">

    <nav class="p-4 md:py-8 xl:px-0 md:container md:mx-w-6xl md:mx-auto">
        <div class="hidden lg:flex lg:justify-between lg:items-center">
            <a href="#" class="flex items-start gap-2 group">
                <div class=" text-white p-2 rounded-md">
                    <img src=" https://i.postimg.cc/j5NZJ2kk/cargo.png" class="w-12 h-12" alt="">
                    <!-- <svg xmlns="https://i.postimg.cc/j5NZJ2kk/cargo.png" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg> -->
                   
                </div>
                <p class="text-sm font-light uppercase">
                   
                    <span class="text-base block font-bold tracking-widest">
                    
                    </span>
                </p>
            </a>
            <!-- <ul class="flex items-center space-x-4 text-sm font-semibold">
                <li><a href="#" class="px-2 xl:px-4 py-2 text-gray-800 rounded-md hover:bg-gray-200">My Account</a></li>
                <li class="relative" x-data="{ open: false }">
                    <a x-on:click="open = !open" x-on:click.outside="open = false" href="#"
                        class="px-2 xl:px-4 py-2 text-gray-600 rounded-md hover:bg-gray-200 flex gap-2 items-center">
                        Gestion des cargaisons
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-current stroke-2 text-gray-800 transform duration-500 ease-in-out" :class="open ? 'rotate-90' : ''"  fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg> </a>
                    <ul x-cloak x-show="open" x-transition
                        class="absolute top-10 left-0 bg-white p-4 rounded-md shadow overflow-hidden w-64">
                        <li>
                            <a href="#"
                                class="p-4 block text-sm text-gray-600 rounded flex items-center gap-2 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Ajouter une nouvelle cargaison
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="p-4 block text-sm text-gray-600 rounded flex items-center gap-2 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Consulter le détail d'une cargaison
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="p-4 block text-sm text-gray-600 rounded flex items-center gap-2 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Modifier les informations d'une cargaison
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#" class="px-2 xl:px-4 py-2 text-gray-600 rounded-md hover:bg-gray-200">Cargaison En cours </a></li>
                <li><a href="#" class="px-2 xl:px-4 py-2 text-gray-600 rounded-md hover:bg-gray-200">Cargaison terminé</a></li>
            </ul> -->
            <ul class="flex space-x-2 xl:space-x-4 text-sm font-semibold">
                <li>
                    <a href="#">
                        <div class="p-2 rounded hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-current text-gray-800"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="p-2 rounded hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-current text-gray-800"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="p-2 rounded hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-current text-gray-800"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="flex items-center gap-6">
                <li>
                    <a href="#" class="text-sm font-sans text-gray-800 font-semibold tracking-wider">
                    <!-- <?php echo htmlspecialchars($_SESSION['name']); ?> -->
                    <!-- htmlspecialchars($_SESSION['name']); -->
                    Serigne Fallou
                    </a>
                </li>
                <li>
                <a href="logout.php" method="POST"> <div class="p-2 rounded hover:bg-gray-200"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /> </svg> </div> </a>

                </li>
            </ul>
        </div>
        <div x-data="{ open: false }" class="lg:hidden relative flex justify-between w-full">
            <a href="#" class="flex items-start gap-2 group">
            <img src=" https://i.postimg.cc/j5NZJ2kk/cargo.png" class="w-12 h-12" alt="">
                <p class="text-sm font-light uppercase">
                    <!-- Dashboard -->
                    <span class="text-base block font-bold tracking-widest">
                        <!-- Atom    -->
                    </span>
                </p>
            </a>
            <button x-on:click="open = !open" type="button" class="bg-gray-200 p-3 rounded-md">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div x-show="open" x-transition class="absolute top-14 left-0 right-0 w-full bg-white rounded-md border">
                <ul class="p-4">
                    <li class="px-4 py-2 rounded hover:bg-gray-200">
                        <a href="#" class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            My Account
                        </a>
                    </li>
                    <li class="px-4 py-2 rounded hover:bg-gray-200">
                        <a href="#" class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Transactions
                        </a>
                    </li>
                    <li class="px-4 py-2 rounded hover:bg-gray-200">
                        <a href="#" class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Cards
                        </a>
                    </li>
                    <li class="px-4 py-2 rounded hover:bg-gray-200">
                        <a href="#" class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />ser
                            </svg>
                            Offers
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- End Nav -->
    <!-- Start Main -->
    <main class="container mx-w-6xl mx-auto py-4">
        <div class="flex flex-col space-y-8">
            <!-- First Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-5 px-4 xl:p-0 gap-y-4 md:gap-6">
                <div class="md:col-span-2 xl:col-span-3 bg-white p-6 rounded-2xl border border-gray-50 transition-shadow shadow-sm hover:shadow-lg ">
                    <div class="flex flex-col space-y-6 md:h-full md:justify-between">
                        <div class="flex justify-between">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider">
                                <!-- Main Account -->
                            </span>
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider">
                                <!-- Available Funds -->
                            </span>
                        </div>
                        <div class="flex gap-2 md:gap-4 justify-between items-center">
                            <div class="flex flex-col space-y-4">
                                <h2 class="text-gray-800 font-bold tracking-widest leading-tight">Indicateurs de performance</h2>
                                <div class="flex items-center gap-4">
                                    <p class="text-lg text-gray-600 tracking-wider">Valeur totale des cargaisons</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg md:text-xl xl:text-3xl text-gray-700 font-black tracking-wider">
                                <span class="md:text-xl">$</span>
                                8 456 789
                            </h2>
                        </div>
                        <div class="flex gap-2 md:gap-4">
                            <a href="#"
                                class="bg-teal-900 px-5 py-3 w-full text-center md:w-auto rounded-lg text-white text-xs tracking-wider font-semibold hover:bg-teal-300">
                                Consulter
                            </a>
                            <!-- <a href="#"
                                class="bg-blue-50 px-5 py-3 w-full text-center md:w-auto rounded-lg text-teal-950 text-xs tracking-wider font-semibold hover:text-teal-950">
                                Link Account
                            </a> -->
                        </div> 
                    </div>
                </div>
                <div
                    class="col-span-2 p-6 rounded-2xl bg-gradient-to-r from-emerald-950 to-teal-200 flex flex-col justify-between">
                    <div class="flex flex-col">
                        <p class="text-white font-bold">GP-MONDE</p>
                        <p class="mt-1 text-xs md:text-sm text-gray-50 font-light leading-tight max-w-sm">
                        L'objectif de cette page de tableau de bord est de fournir une vue d'ensemble claire et concise des principales informations liées à la gestion de la cargaison, tout en permettant un accès rapide aux fonctionnalités clés de l'application
                        </p>
                    </div>
                    <div class="flex justify-between items-end">
                        <a href="#"
                            class="bg-teal-400 px-4 py-3 rounded-lg text-white text-xs tracking-wider font-semibold hover:bg-teal-500 hover:text-white">
                            En savoir plus
                        </a>
                        <!-- <img src="https://atom.dzulfarizan.com/assets/calendar.png" alt="calendar" class="w-auto h-24 object-cover"> -->
                    </div>
                </div>
            </div>
            <!-- End First Row -->
            <!-- Start Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 px-4 xl:p-0 gap-4 xl:gap-6 ">
                <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-between">
                    <h2 class="text-xs md:text-sm text-gray-700 font-bold tracking-wide md:tracking-wider">
                     Type Cargaison</h2>
                    <!-- <a href="#" class="text-xs text-gray-800 font-semibold uppercase">Plus</a> -->
                </div>
                <div id="card-maritime" class=" bg-white p-6 rounded-xl border border-gray-50 transition-shadow shadow-sm hover:shadow-lg">
                    <div class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <p class="text-xs text-gray-600 tracking-wide">Martime</p>
                            <h3 class="mt-1 text-lg text-blue-500 font-bold">Total : $ 818</h3>
                            <span class="mt-4 text-xs text-gray-500">Limites de responsabilité de la compagnie maritime</span>
                        </div>
                        <div class=" md:p-1 xl:p-2 rounded-md">
                            <img src="https://i.postimg.cc/BQ5kVYpw/Capture-d-cran-du-2024-05-23-09-13-45.png" alt="icon" class="w-auto h-12 md:h-12 xl:h-12 object-cover">
                        </div>
                    </div>
                </div>
                <!-- <div class="bg-white p-6 rounded-xl border border-gray-50"> -->
                <div  id="card-aerienne"class="bg-white p-6 rounded-xl border border-gray-50 transition-shadow shadow-sm hover:shadow-lg">

                    <div class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <p class="text-xs text-gray-600 tracking-wide">Aérienne</p>
                            <h3 class="mt-1 text-lg text-green-500 font-bold">Total : $ 8,918</h3>
                            <span class="mt-4 text-xs text-gray-500">Limites de responsabilité de la compagnie Aérienne</span>
                        </div>
                        <div class=" md:p-1 xl:p-2 rounded-md">
                            <!-- <img src="https://atom.dzulfarizan.com/assets/grocery.png" alt="icon" class="w-auto h-8 md:h-6 xl:h-8 object-cover"> -->
                            <img src="https://i.postimg.cc/wTzbL5z5/Capture-d-cran-du-2024-05-23-09-16-31.png" alt="icon" class="w-auto h-12 md:h-12 xl:h-12 object-cover">
                        </div>
                    </div>
                </div>
                <!-- <div class="bg-white p-6 rounded-xl  border border-gray-50"> -->
                <div class="bg-white p-6 rounded-xl border border-gray-50 transition-shadow shadow-sm hover:shadow-lg">

                    <div id="card-routiere" class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <p class="text-xs text-gray-600 tracking-wide">Routière</p>
                            <h3 class="mt-1 text-lg text-yellow-500 font-bold">$ 1,223</h3>
                             <span class="mt-4 text-xs text-gray-500">Limites de responsabilité de la compagnie Routière</span>
                        </div>
                        <div class=" md:p-1 xl:p-2 rounded-md">
                            <!-- <img src="https://atom.dzulfarizan.com/assets/gaming.png" alt="icon" class="w-auto h-8 md:h-6 xl:h-8 object-cover"> -->
                            <img src="https://i.postimg.cc/2jhK1cs8/Capture-d-cran-du-2024-05-23-09-21-02.png" alt="icon" class="w-auto h-12 md:h-12 xl:h-12 object-cover">
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-50 transition-shadow shadow-sm hover:shadow-lg">

                    <div class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <p class="text-xs text-gray-600 tracking-wide">cargaison</p>
                            <h3 class="mt-1 text-lg text-indigo-500 font-bold">$ 5,918</h3>
                            <span class="mt-4 text-xs text-gray-500">Limites de responsabilité de la compagnie Routière</span>
                        </div>
                        <div class="bg-indigo-500 p-2 md:p-1 xl:p-2 rounded-md">
                            <!-- <img src="https://atom.dzulfarizan.com/assets/holiday.png" alt="icon" class="w-auto h-8 md:h-6 xl:h-8 object-cover"> -->
                        </div>
                    </div>
                </div> 
            </div>
            <!-- End Second Row -->
            <div class="fixed bottom-4 right-4 xl:right-18">
        <a href="#" class="transform duration-500 ease-in-out animate-bounce bg-teal-400 px-2 py-2 text-white font-mono font-semibold rounded-xl shadow hover:shadow-xl hover:text-white flex justify-between items-center gap-2" id="open-cargo-modal">
            <i class="fas fa-plus-circle text-white text-2xl"></i>
             cargaison
        </a>
    </div>
    <!-- ajout produit -->
    <!-- <div class="fixed bottom-20 right-4 xl:right-18">
        <a href="#" class="transform duration-500 ease-in-out animate-bounce bg-teal-900 px-2 py-2 text-white font-mono font-semibold rounded-xl shadow hover:shadow-xl hover:text-white flex justify-between items-center gap-7" id="open-cargo-modal">
            <i class="fas fa-plus-circle text-white text-2xl"></i>
            Produit
        </a>
    </div> -->
    
        <div class="fixed inset-0 z-50 overflow-y-auto hidden" id="cargo-modal">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
                <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Ajouter une cargaison</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeModal()">
                                        <span class="sr-only">Close</span>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="mt-2" id="cargo-form-container">
                                    <!-- <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2" for="poids-max">Poids maximum</label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="poids-max" type="number" placeholder="Entrez le poids maximum">
                                        <span class="error-message" id="error-poids-max">Veuillez entrer un poids maximum valide.</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2" for="prix">Prix total</label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="prix" type="number" placeholder="Entrez le prix total">
                                        <span class="error-message" id="error-prix">Veuillez entrer un prix total valide.</span>
                                    </div> -->
                                <form id="cargo-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="mb-4 col-span-2">
        <label class="block text-gray-700 font-bold mb-2" for="cargo-plein">Cargaison pleine</label>
        <div class="flex items-center">
            <input class="mr-2 leading-tight" type="radio" id="plein-poids" name="cargo-plein" value="poids">
            <label for="plein-poids" class="text-gray-700">Par poids</label>
            <input class="ml-4 mr-2 leading-tight" type="radio" id="plein-nombre" name="cargo-plein" value="nombre">
            <label for="plein-nombre" class="text-gray-700">Par nombre de produits</label>
        </div>
        <span class="error-message" id="error-cargo-plein">Veuillez sélectionner une option pour la cargaison pleine.</span>
    </div>
    <div class="mb-4" id="poids-max-container">
        <label class="block text-gray-700 font-bold mb-2" for="poids-max">Poids maximum</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="poids-max" type="number" placeholder="Entrez le poids maximum">
        <span class="error-message" id="error-poids-max">Veuillez entrer un poids maximum valide.</span>
    </div>
    <div class="mb-4" id="prix-container">
        <label class="block text-gray-700 font-bold mb-2" for="prix">nombre Produit</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="prix" type="number" placeholder="Entrez le prix total">
        <span class="error-message" id="error-prix">Veuillez entrer un prix total valide.</span>
    </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="depart">Lieu de départ</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="depart" type="text" placeholder="Sélectionnez sur la carte" readonly>
            <span class="error-message" id="error-depart">Veuillez sélectionner un lieu de départ.</span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="arrivee">Lieu d'arrivée</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="arrivee" type="text" placeholder="Sélectionnez sur la carte" readonly>
            <span class="error-message" id="error-arrivee">Veuillez sélectionner un lieu d'arrivée.</span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="distance">Distance (km)</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="distance" type="number" placeholder="Calculée automatiquement" readonly>
            <span class="error-message" id="error-distance">La distance doit être calculée automatiquement.</span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="type">Type de cargaison</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type">
                <option value="">Sélectionnez un type</option>
                <option value="maritime">Maritime</option>
                <option value="aerienne">Aérienne</option>
                <option value="routiere">Routière</option>
            </select>
            <span class="error-message" id="error-type">Veuillez sélectionner un type de cargaison.</span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="statut">État d'avancement</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="statut">
                <option value="">Sélectionnez un état</option>
                <option value="en-attente">En attente</option>
                <option value="en-cours">En cours</option>
                <option value="termine">Terminé</option>
            </select>
            <span class="error-message" id="error-statut">Veuillez sélectionner un état d'avancement.</span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="etat">État global</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="etat">
                <option value="">Sélectionnez un état</option>
                <option value="ouvert">Ouvert</option>
                <option value="ferme">Fermé</option>
            </select>
            <span class="error-message" id="error-etat">Veuillez sélectionner un état global.</span>
        </div>
          
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="date-depart">Date de départ</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date-depart" type="date">
        <span class="error-message" id="error-date-depart">Veuillez sélectionner une date de départ.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="date-arrivee">Date d'arrivée</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date-arrivee" type="date">
        <span class="error-message" id="error-date-arrivee">Veuillez sélectionner une date d'arrivée.</span>
    </div>
    
    <!-- <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="cargo-plein">Cargaison pleine</label>
        <div class="flex items-center">
            <input class="mr-2 leading-tight" type="radio" id="plein-poids" name="cargo-plein" value="poids">
            <label for="plein-poids" class="text-gray-700">Par poids</label>
            <input class="ml-4 mr-2 leading-tight" type="radio" id="plein-nombre" name="cargo-plein" value="nombre">
            <label for="plein-nombre" class="text-gray-700">Par nombre de produits</label>
        </div>
        <span class="error-message" id="error-cargo-plein">Veuillez sélectionner une option pour la cargaison pleine.</span>
    </div> -->
        <div id="map" class="col-span-2"></div>
        <div class="col-span-2 flex items-center justify-between">
            <button id="btn-add-cargo" class="bg-teal-200 hover:bg-teal-600 text-teal-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Ajouter la cargaison</button>
        </div>
                                </form>

                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
function closeModal() {
    document.getElementById('cargo-modal').classList.add('hidden');
}
</script>
    <!-- <button class="text-blue-500 hover:text-blue-700" onclick="openModalProduct('CGN364')">
        <i class="fas fa-plus-circle"></i>
    </button> -->

<!-- form product -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="produit-modal">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
        <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Ajouter un produit</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeModal()">
                                <span class="sr-only">Close</span>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="mt-2" id="produit-form-container">
                        <form id="product-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <!-- Code du produit -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="code">Code du produit</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" type="text" placeholder="Entrez le code du produit">
        <span class="error-message" id="error-code">Veuillez entrer un code de produit valide.</span>
    </div>
    <!-- Poids -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="poids">Poids</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="poids" type="number" placeholder="Entrez le poids">
        <span class="error-message" id="error-poids">Veuillez entrer un poids valide.</span>
    </div>
    <!-- Type de produit -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="type-produit">Type de produit</label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type-produit">
            <option value="">Sélectionnez un type</option>
            <option value="alimentaire">Alimentaire</option>
            <option value="chimique">Chimique</option>
            <option value="materiel">Matériel</option>
        </select>
        <span class="error-message" id="error-type-produit">Veuillez sélectionner un type de produit.</span>
    </div>
    <!-- Degré de toxicité (pour chimique) -->
    <div class="mb-4" id="degre-toxicite-container" style="display: none;">
        <label class="block text-gray-700 font-bold mb-2" for="degre-toxicite">Degré de toxicité (0-10)</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="degre-toxicite" type="number" min="0" max="10" placeholder="Entrez le degré de toxicité">
        <span class="error-message" id="error-degre-toxicite">Veuillez entrer un degré de toxicité valide (0-10).</span>
    </div>
    <!-- Type de matériel (pour matériel) -->
    <div class="mb-4" id="type-materiel-container" style="display: none;">
        <label class="block text-gray-700 font-bold mb-2" for="type-materiel">Type de matériel</label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type-materiel">
            <option value="">Sélectionnez un type</option>
            <option value="cassable">Cassable</option>
            <option value="incassable">Incassable</option>
        </select>
        <span class="error-message" id="error-type-materiel">Veuillez sélectionner un type de matériel.</span>
    </div>
    <!-- État du produit -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="etat">État du produit</label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="etat">
            <option value="">Sélectionnez un état</option>
            <option value="en-attente">En attente</option>
            <option value="en-cours">En cours</option>
            <option value="arrive">Arrivé</option>
            <option value="recupere">Récupéré</option>
            <option value="perdu">Perdu</option>
            <option value="archive">Archivé</option>
        </select>
        <span class="error-message" id="error-etat">Veuillez sélectionner un état de produit.</span>
    </div>
    <!-- Client details -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="client-nom">Nom du client</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client-nom" type="text" placeholder="Entrez le nom du client">
        <span class="error-message" id="error-client-nom">Veuillez entrer un nom de client valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="client-prenom">Prénom du client</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client-prenom" type="text" placeholder="Entrez le prénom du client">
        <span class="error-message" id="error-client-prenom">Veuillez entrer un prénom de client valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="client-telephone">Téléphone du client</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client-telephone" type="text" placeholder="Entrez le téléphone du client">
        <span class="error-message" id="error-client-telephone">Veuillez entrer un téléphone de client valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="client-adresse">Adresse du client</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client-adresse" type="text" placeholder="Entrez l'adresse du client">
        <span class="error-message" id="error-client-adresse">Veuillez entrer une adresse de client valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="client-email">Email du client</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client-email" type="email" placeholder="Entrez l'email du client">
        <span class="error-message" id="error-client-email">Veuillez entrer un email de client valide.</span>
    </div>
    <!-- Destinataire details -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="destinataire-nom">Nom du destinataire</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="destinataire-nom" type="text" placeholder="Entrez le nom du destinataire">
        <span class="error-message" id="error-destinataire-nom">Veuillez entrer un nom de destinataire valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="destinataire-prenom">Prénom du destinataire</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="destinataire-prenom" type="text" placeholder="Entrez le prénom du destinataire">
        <span class="error-message" id="error-destinataire-prenom">Veuillez entrer un prénom de destinataire valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="destinataire-telephone">Téléphone du destinataire</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="destinataire-telephone" type="text" placeholder="Entrez le téléphone du destinataire">
        <span class="error-message" id="error-destinataire-telephone">Veuillez entrer un téléphone de destinataire valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="destinataire-adresse">Adresse du destinataire</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="destinataire-adresse" type="text" placeholder="Entrez l'adresse du destinataire">
        <span class="error-message" id="error-destinataire-adresse">Veuillez entrer une adresse de destinataire valide.</span>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="destinataire-email">Email du destinataire</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="destinataire-email" type="email" placeholder="Entrez l'email du destinataire">
        <span class="error-message" id="error-destinataire-email">Veuillez entrer un email de destinataire valide.</span>
    </div>
    <div class="col-span-2 flex items-center justify-between">
        <button id="btn-add-product" class="bg-teal-200 hover:bg-teal-600 text-teal-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Ajouter le produit</button>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Start Third Row -->
            
     <!-- Table with static cargo data -->
 
     <div class="grid grid-cols-1 md:grid-cols-5 items-start px-4 xl:p-0 gap-y-4 md:gap-6 mt-6">
    <div class="col-span-5 bg-white p-6 rounded-xl border border-gray-50">
        <h2 class="text-sm text-gray-600 font-bold tracking-wide mb-4">Filtrer les Cargaisons</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <input id="filter-numero" type="text" placeholder="Filtrer par Numéro" class="py-2 px-4 border rounded-lg">
            <input id="filter-statut" type="text" placeholder="Filtrer par statut" class="py-2 px-4 border rounded-lg">
            <input id="filter-depart" type="text" placeholder="Filtrer par Départ" class="py-2 px-4 border rounded-lg">
            <input id="filter-arrivee" type="text" placeholder="Filtrer par Arrivée" class="py-2 px-4 border rounded-lg">
        </div>
        <table class="min-w-full bg-white">
        <thead>
    <tr>
    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Numéro</th>
            <!-- <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poids Max (kg)</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Total (€)</th> -->
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Départ</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Arrivée</th>
            <!-- <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Distance (km)</th> -->
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Départ</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'Arrivée</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
        </tr>
    </thead>
    <tbody id="cargo-table-body" class="divide-y divide-gray-200">
        <!-- Data will be dynamically loaded here -->
    </tbody>
</table>
        <div id="pagination" class="flex justify-end mt-4"></div>
    </div>
</div>
            <!-- End Third Row -->
        </div>


        <!-- Modal pour les détails de la cargaison -->
<div id="detail-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-4 rounded-lg w-3/4 w-2xl">
        <div class="mt-4 flex justify-end">
            <button onclick="closeDetailModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">X</button>
        </div>
        <div class="mb-4">
            <h2 id="modal-detail-title" class="text-xl font-bold mb-2"></h2>
            <div id="cargo-details" class="p-4 bg-gray-100 rounded-lg"></div>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody id="product-table-body" class="bg-white divide-y divide-gray-200">
                <!-- Les produits seront insérés ici -->
            </tbody>
        </table>
        <div id="products-pagination" class="flex justify-end mt-4">
                    <!-- La pagination sera insérée ici -->
                </div>
    </div>
</div>

    </main>
    <!-- End Main -->
  <script src="../dist/app.js" type="module"></script>
  <script>

// formulaire
    document.addEventListener('DOMContentLoaded', function () {
        const poidsMaxContainer = document.getElementById('poids-max-container');
        const prixContainer = document.getElementById('prix-container');
        const radioPoids = document.getElementById('plein-poids');
        const radioNombre = document.getElementById('plein-nombre');

        // Initialement masquer les champs
        poidsMaxContainer.style.display = 'none';
        prixContainer.style.display = 'none';

        // Ajouter des écouteurs d'événements pour les boutons radio
        radioPoids.addEventListener('change', function () {
            if (this.checked) {
                poidsMaxContainer.style.display = 'block';
                prixContainer.style.display = 'none';
            }
        });

        radioNombre.addEventListener('change', function () {
            if (this.checked) {
                poidsMaxContainer.style.display = 'none';
                prixContainer.style.display = 'block';
            }
        });
    });


    // Sélectionner les éléments nécessaires
      // Sélectionner les éléments nécessaires
      const openModalBtn = document.getElementById('open-cargo-modal');
        const cargoModal = document.getElementById('cargo-modal');
        const cargoFormContainer = document.getElementById('cargo-form-container');
        
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
var map = L.map('map').setView([14.4974, -14.4524], 6);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

var departMarker;
var arriveeMarker;

// Custom icon
var customIcon = L.divIcon({
    className: 'custom-marker',
    html: '<i class="fas fa-map-marker-alt" style="color: #19d28b; text-shadow: 1px 1px 2px #484c4a;"></i>',
    iconSize: [24, 24],
    iconAnchor: [12, 24]
});

map.on('click', function(e) {
    if (!departMarker) {
        departMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        document.getElementById('depart').value = `${e.latlng.lat}, ${e.latlng.lng}`;
        reverseGeocode(e.latlng, 'depart');
    } else if (!arriveeMarker) {
        arriveeMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        document.getElementById('arrivee').value = `${e.latlng.lat}, ${e.latlng.lng}`;
        reverseGeocode(e.latlng, 'arrivee');
        calculateDistance();
    } else {
        map.removeLayer(departMarker);
        map.removeLayer(arriveeMarker);
        departMarker = L.marker(e.latlng, { icon: customIcon }).addTo(map);
        document.getElementById('depart').value = `${e.latlng.lat}, ${e.latlng.lng}`;
        document.getElementById('arrivee').value = '';
        document.getElementById('distance').value = '';
        arriveeMarker = null;
        reverseGeocode(e.latlng, 'depart');
    }
});

function calculateDistance() {
    if (departMarker && arriveeMarker) {
        var depart = departMarker.getLatLng();
        var arrivee = arriveeMarker.getLatLng();

        var from = turf.point([depart.lng, depart.lat]);
        var to = turf.point([arrivee.lng, arrivee.lat]);
        var options = { units: 'kilometers' };

        var distance = turf.distance(from, to, options);
        document.getElementById('distance').value = distance.toFixed(2);
    }
}

function reverseGeocode(latlng, inputId) {
    var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            var address = data.address;
            var placeName = '';

            if (address.city) {
                placeName += address.city + ', ';
            } else if (address.town) {
                placeName += address.town + ', ';
            } else if (address.village) {
                placeName += address.village + ', ';
            } else if (address.hamlet) {
                placeName += address.hamlet + ', ';
            }

            if (address.state) {
                placeName += address.state + ', ';
            }

            if (address.country) {
                placeName += address.country;
            }

            var locationInfo = placeName ? `${placeName} (${latlng.lat}, ${latlng.lng})` : `Coordinates: ${latlng.lat}, ${latlng.lng}`;
            document.getElementById(inputId).value = locationInfo || "Lieu non trouvé";
        })
        .catch(error => console.log('Error:', error));
}


        // Variable pour stocker les cargaisons
        let cargos = [];
        const pageSize = 4; // Nombre de cargaisons par page
        let currentPage = 1; // Page actuelle

        // Fonction pour charger les cargaisons depuis le fichier JSON
        function loadCargos() {
            fetch('cargo.php')
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
        function updateCargos() {
            const filterNumero = document.getElementById('filter-numero').value.toLowerCase();
            const filtreStatus = document.getElementById('filter-statut').value.toLowerCase();
            const filterDepart = document.getElementById('filter-depart').value.toLowerCase();
            const filterArrivee = document.getElementById('filter-arrivee').value.toLowerCase();

            // Filtrer les cargaisons selon les critères
            const filteredCargos = cargos.filter(cargo =>
                cargo.numero.toLowerCase().includes(filterNumero) &&
                (filtreStatus === 'filter-statut' || cargo.statut.toLowerCase().includes(filtreStatus)) &&
                cargo.depart.toLowerCase().includes(filterDepart) &&
                cargo.arrivee.toLowerCase().includes(filterArrivee)
            );

            // Paginer les cargaisons filtrées
            const start = (currentPage - 1) * pageSize;
            const end = start + pageSize;
            const paginatedCargos = filteredCargos.slice(start, end);

            // Afficher les cargaisons paginées
            displayCargos(paginatedCargos);

            // Afficher la pagination
            displayPagination(filteredCargos.length);
        }

        // Ajouter un écouteur d'événement pour les champs de recherche/filtrage
        const searchInputs = document.querySelectorAll('input[type="text"], input[type="number"]');
        searchInputs.forEach(input => {
            input.addEventListener('input', function() {
                currentPage = 1; // Réinitialiser la page actuelle lors de la modification des critères de recherche
                updateCargos();
            });
        });

        function displayCargos(cargos) {
    const tableBody = document.getElementById('cargo-table-body');
    tableBody.innerHTML = ''; // Effacer le contenu existant du tableau
    cargos.forEach(cargo => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.numero}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.depart}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.arrivee}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.type}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.statut}</td>
            <td class="py-2 px-4 text-sm text-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${cargo.etat === 'ouvert' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${cargo.etat}</span>
            </td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.date_depart}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.date_arrivee}</td>
            <td class="py-2 px-4 text-sm text-gray-500 text-center flex flex-wrap gap-2 justify-center">
                <button class="text-fleat-500 hover:text-fleat-700" onclick="openModalProduct('${cargo.numero}')">
                    <i class="fas fa-plus-circle"></i>
                </button>
                <button class="text-fleat-500 hover:text-fleat-700" onclick="afficherDetail('${cargo.numero}')">
                    <i class="fas fa-info-circle"></i>
                </button>
                <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-400" onclick="mettreEnCours('${cargo.numero}')">
                    En cours
                </button>
                <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500 text-white" onclick="marquerPerdu('${cargo.numero}')">
                    Perdu
                </button>
                <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-green-200 text-green-800" onclick="marquerArrive('${cargo.numero}')">
                    Arrivé
                </button>
                <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-green-200 text-green-800" onclick="marquerEtatOuvert('${cargo.numero}')">
                    Ouvert
                </button>
                <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-red-200 text-red-800" onclick="marquerEtatFermer('${cargo.numero}')">
                    Fermé
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

//         function displayCargos(cargos) {
//     const tableBody = document.getElementById('cargo-table-body');
//     tableBody.innerHTML = ''; // Effacer le contenu existant du tableau
//     cargos.forEach(cargo => {
//         const row = document.createElement('tr');
//         row.innerHTML = `
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.numero}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.depart}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.arrivee}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.type}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.statut}</td>
//             <td class="py-2 px-4 text-sm text-center">
//                 <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${cargo.etat === 'ouvert' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${cargo.etat}</span>
//             </td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.date_depart}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">${cargo.date_arrivee}</td>
//             <td class="py-2 px-4 text-sm text-gray-500 text-center">
//                 <button class="text-fleat-500 hover:text-fleat-700" onclick="openModalProduct('${cargo.numero}')">
//                     <i class="fas fa-plus-circle"></i>
//                 </button>
//                 <button class="text-fleat-500 hover:text-fleat-700 ml-2" onclick="afficherDetail('${cargo.numero}')">
//                     <i class="fas fa-info-circle"></i>
//                 </button>
//                 <button class="items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-400" onclick="mettreEnCours('${cargo.numero}')">
//                     En cours
//                 </button>
//                 <button class="items-center px-2 py-0.5 rounded text-xs font-medium hover:text-fleat-700 ml-2 bg-red-500 text-white bg-red-100 text-red-800" onclick="marquerPerdu('${cargo.numero}')">
//                     Perdu
//                 </button>
//                 <button class="items-center px-2 py-0.5 rounded text-xs font-medium ml-2 bg-green-200 text-green-800" onclick="marquerArrive('${cargo.numero}')">
//                     Arrivé
//                 </button>
//                 <button class="items-center px-2 py-0.5 rounded text-xs font-medium ml-2 bg-green-200 text-green-800" onclick="marquerEtatOuvert('${cargo.numero}')">
//                     Ouvert
//                 </button>
//                 <button class="items-center px-2 py-0.5 rounded text-xs font-medium ml-2 bg-red-200 text-red-800" onclick="marquerEtatFermer('${cargo.numero}')">
//                     Fermé
//                 </button>
//             </td>
//         `;
//         tableBody.appendChild(row);
//     });
// }

function marquerPerdu(numero) {
    updateStatus(numero, 'Perdu');
}

function marquerArrive(numero) {
    updateStatus(numero, 'Arrivé');
}

function mettreEnCours(numero) {
    updateStatus(numero, 'en-cours');
}

function marquerEtatOuvert(numero) {
    fetch(`cargo.php?numero=${numero}`)
        .then(response => response.json())
        .then(data => {
            const cargo = data.find(c => c.numero === numero);
            if (cargo.statut === 'Perdu') {
                alert('Une cargaison perdue ne peut pas être ouverte.');
                return;
            }
            updateEtat(numero, 'ouvert');
        })
        .catch(error => console.log('Error:', error));
}

function marquerEtatFermer(numero) {
    fetch(`cargo.php?numero=${numero}`)
        .then(response => response.json())
        .then(data => {
            const cargo = data.find(c => c.numero === numero);
            if (cargo.statut === 'Perdu') {
                alert('Une cargaison perdue ne peut pas être fermée.');
                return;
            }
            updateEtat(numero, 'ferme');
        })
        .catch(error => console.log('Error:', error));
}

function updateStatus(numero, statut) {
    const payload = {
        numero: numero,
        statut: statut
    };

    fetch('cargo.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadCargos(); // Mettre à jour la liste des cargaisons
    })
    .catch(error => console.log('Error:', error));
}

function updateEtat(numero, etat) {
    const payload = {
        numero: numero,
        etat: etat
    };

    fetch('cargo.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadCargos(); // Mettre à jour la liste des cargaisons
    })
    .catch(error => console.log('Error:', error));
}


let selectedCargoId = null;

// Fonction pour ouvrir le modal et enregistrer l'ID de la cargaison sélectionnée
function openModalProduct(cargoId) {
    selectedCargoId = cargoId;
    document.getElementById('modal-title').innerText = `Ajouter un produit dans la cargaison numéro : ${cargoId}`;
    document.getElementById('produit-modal').classList.remove('hidden');
}

// Fonction pour fermer le modal
function closeModal() {
    document.getElementById('produit-modal').classList.add('hidden');
}


//     const produit = {
//         code: document.getElementById('code').value,
//         poids: document.getElementById('poids').value,
//         type_produit: document.getElementById('type-produit').value,
//         degre_toxicite: document.getElementById('degre-toxicite').value,
//         type_materiel: document.getElementById('type-materiel').value,
//         etat: document.getElementById('etat').value,
//         client_nom: document.getElementById('client-nom').value,
//         client_prenom: document.getElementById('client-prenom').value,
//         client_telephone: document.getElementById('client-telephone').value,
//         client_adresse: document.getElementById('client-adresse').value,
//         client_email: document.getElementById('client-email').value,
//         destinataire_nom: document.getElementById('destinataire-nom').value,
//         destinataire_prenom: document.getElementById('destinataire-prenom').value,
//         destinataire_telephone: document.getElementById('destinataire-telephone').value,
//         destinataire_adresse: document.getElementById('destinataire-adresse').value,
//         destinataire_email: document.getElementById('destinataire-email').value,
//         cargo_id: selectedCargoId
//     };

//     fetch('ajouter_produit.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(produit)
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             alert('Produit ajouté avec succès');
//             closeModal();
//         } else {
//             alert('Erreur lors de l\'ajout du produit: ' + data.message);
//         }
//     })
//     .catch(error => {
//         alert('Erreur lors de l\'ajout du produit: ' + error.message);
//     });
// }

function ajouterProduit() {
    const produit = {
        code: document.getElementById('code').value,
        poids: document.getElementById('poids').value,
        type_produit: document.getElementById('type-produit').value,
        degre_toxicite: document.getElementById('degre-toxicite').value,
        type_materiel: document.getElementById('type-materiel').value,
        etat: document.getElementById('etat').value,
        client_nom: document.getElementById('client-nom').value,
        client_prenom: document.getElementById('client-prenom').value,
        client_telephone: document.getElementById('client-telephone').value,
        client_adresse: document.getElementById('client-adresse').value,
        client_email: document.getElementById('client-email').value,
        destinataire_nom: document.getElementById('destinataire-nom').value,
        destinataire_prenom: document.getElementById('destinataire-prenom').value,
        destinataire_telephone: document.getElementById('destinataire-telephone').value,
        destinataire_adresse: document.getElementById('destinataire-adresse').value,
        destinataire_email: document.getElementById('destinataire-email').value,
        cargo_id: selectedCargoId
    };

    fetch('ajouter_produit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(produit)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Produit ajouté avec succès');
            closeModal();
        } else {
            alert('Erreur lors de l\'ajout du produit: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erreur lors de l\'ajout du produit: ' + error.message);
    });
}


document.getElementById('type-produit').addEventListener('change', function() {
    const selectedType = this.value;
    document.getElementById('degre-toxicite-container').style.display = selectedType === 'chimique' ? 'block' : 'none';
    document.getElementById('type-materiel-container').style.display = selectedType === 'materiel' ? 'block' : 'none';
});

document.getElementById('btn-add-product').addEventListener('click', ajouterProduit);





// let selectedCargoId = null;

function openModalProduct(cargoId) {
    selectedCargoId = cargoId;
    document.getElementById('modal-title').innerText = `Ajouter un produit dans la cargaison numéro : ${cargoId}`;
    document.getElementById('produit-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('produit-modal').classList.add('hidden');
}

// let selectedCargoId = null;
let productsPageSize = 3; // Nombre de produits par page
let currentProductsPage = 1; // Page actuelle pour les produits

// Fonction pour afficher les détails de la cargaison avec pagination des produits
function afficherDetail(cargoId) {
    const cargo = cargos.find(c => c.numero === cargoId);
    if (!cargo) return;

    selectedCargoId = cargoId;
    document.getElementById('modal-detail-title').innerText = `Détails de la cargaison numéro : ${cargoId}`;
    document.getElementById('cargo-details').innerHTML = `
    <div class="bg-white shadow-md rounded-lg p-6">
    <h3 class="text-lg font-bold mb-4">Informations sur la cargaison</h3>
    <div class="flex justify-between">
        <div class="w-1/2">
            <p><strong>Numéro:</strong> ${cargo.numero}</p>
            <p><strong>Poids max:</strong> ${cargo.poids_max}</p>
            <p><strong>Prix:</strong> ${cargo.prix}</p>
            <p><strong>Départ:</strong> ${cargo.depart}</p>
            <p><strong>Arrivée:</strong> ${cargo.arrivee}</p>
            <p><strong>Distance:</strong> ${cargo.distance}</p>
        </div>
        <div class="w-1/2 text-right">
            <p><strong>Type:</strong> ${cargo.type}</p>
            <p><strong>Statut:</strong> ${cargo.statut}</p>
            <p><strong>État:</strong> ${cargo.etat}</p>
            <p><strong>Date de départ:</strong> ${cargo.date_depart}</p>
            <p><strong>Date d'arrivée:</strong> ${cargo.date_arrivee}</p>
        </div>
    </div>
</div>

    `;

    updateProductsPagination();
    document.getElementById('detail-modal').classList.remove('hidden');
}

// Fonction pour mettre à jour l'affichage des produits avec pagination
function updateProductsPagination() {
    const cargo = cargos.find(c => c.numero === selectedCargoId);
    if (!cargo || !cargo.produits) return;

    const products = cargo.produits;
    const start = (currentProductsPage - 1) * productsPageSize;
    const end = start + productsPageSize;
    const paginatedProducts = products.slice(start, end);

    displayProducts(paginatedProducts);
    displayProductsPagination(products.length);
}

// Fonction pour afficher les produits paginés
function displayProducts(products) {
    const productTableBody = document.getElementById('product-table-body');
    productTableBody.innerHTML = ''; // Effacer le contenu existant du tableau
    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="py-2 px-4 text-sm text-gray-500">${product.code}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${product.nom}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${product.quantite}</td>
            <td class="py-2 px-4 text-sm text-gray-500">${product.prix}</td>
            <td class="py-2 px-4 text-sm text-gray-500">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-700" onclick="toggleDropdown('${product.code}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div id="dropdown-${product.code}" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
                        <a href="#" onclick="marquerArrive('${selectedCargoId}', '${product.code}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Arrivé</a>
                        <a href="#" onclick="marquerPerdu('${selectedCargoId}', '${product.code}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Marquer Perdu</a>
                        <a href="#" onclick="retirerProduit('${selectedCargoId}', '${product.code}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Retirer</a>
                    </div>
                </div>
            </td>
        `;
        productTableBody.appendChild(row);
    });
}

// Fonction pour afficher la pagination des produits
function displayProductsPagination(totalProducts) {
    const totalPages = Math.ceil(totalProducts / productsPageSize);
    const paginationContainer = document.getElementById('products-pagination');
    paginationContainer.innerHTML = ''; // Effacer la pagination existante

    if (totalPages > 1) {
        for (let i = 1; i <= totalPages; i++) {
            const pageLink = document.createElement('button');
            pageLink.textContent = i;
            pageLink.classList.add('mx-1', 'px-3', 'py-1', 'bg-gray-200', 'text-gray-800', 'border', 'border-gray-300', 'rounded', 'hover:bg-gray-300', 'focus:outline-none', 'focus:bg-gray-300');
            if (i === currentProductsPage) {
                pageLink.classList.add('bg-gray-400', 'font-bold');
            }
            pageLink.addEventListener('click', function() {
                currentProductsPage = i;
                updateProductsPagination();
            });
            paginationContainer.appendChild(pageLink);
        }
    }
}

// Fonction pour fermer le modal de détail
function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
}

function toggleDropdown(productCode) {
    document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${productCode}`) {
            dropdown.classList.add('hidden');
        }
    });
    const dropdown = document.getElementById(`dropdown-${productCode}`);
    dropdown.classList.toggle('hidden');
}

function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
}

function retirerProduit(cargoId, productCode) {
    const cargoIndex = cargos.findIndex(c => c.numero === cargoId);
    if (cargoIndex === -1) return;

    const productIndex = cargos[cargoIndex].produits.findIndex(p => p.code === productCode);
    if (productIndex === -1) return;

    // Retirer le produit de la cargaison
    cargos[cargoIndex].produits.splice(productIndex, 1);

    // Actualiser les détails de la cargaison
    afficherDetail(cargoId);
}



function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
}
 
        // Fonction pour afficher la pagination
        function displayPagination(totalCargos) {
            const totalPages = Math.ceil(totalCargos / pageSize);
            const paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = ''; // Effacer la pagination existante

            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    const pageLink = document.createElement('button');
                    pageLink.textContent = i;
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

    
        document.getElementById('cargo-form-container').addEventListener('click', function(event) {
        if (event.target.id === 'btn-add-cargo') {
            var poidsMax = document.getElementById('poids-max');
            var prix = document.getElementById('prix');
            var depart = document.getElementById('depart');
            var arrivee = document.getElementById('arrivee');
            var distance = document.getElementById('distance');
            var type = document.getElementById('type');
            var statut = document.getElementById('statut');
            var etat = document.getElementById('etat');
            var dateDepart = document.getElementById('date-depart');
            var dateArrivee = document.getElementById('date-arrivee');
            var cargoPlein = document.querySelector('input[name="cargo-plein"]:checked');

            var valid = true;

            if (poidsMax.value === '' || isNaN(Number(poidsMax.value)) || parseFloat(poidsMax.value) <= 0) {
                document.getElementById('error-poids-max').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-poids-max').style.display = 'none';
            }

            if (prix.value === '' || isNaN(Number(prix.value)) || parseFloat(prix.value) <= 0) {
                document.getElementById('error-prix').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-prix').style.display = 'none';
            }

            if (depart.value === '') {
                document.getElementById('error-depart').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-depart').style.display = 'none';
            }

            if (arrivee.value === '') {
                document.getElementById('error-arrivee').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-arrivee').style.display = 'none';
            }

            if (distance.value === '' || isNaN(Number(distance.value)) || parseFloat(distance.value) <= 0) {
                document.getElementById('error-distance').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-distance').style.display = 'none';
            }

            if (type.value === '') {
                document.getElementById('error-type').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-type').style.display = 'none';
            }

            if (statut.value === '') {
                document.getElementById('error-statut').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-statut').style.display = 'none';
            }

            if (etat.value === '') {
                document.getElementById('error-etat').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-etat').style.display = 'none';
            }

            if (dateDepart.value === '') {
                document.getElementById('error-date-depart').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-date-depart').style.display = 'none';
            }

            if (dateArrivee.value === '') {
                document.getElementById('error-date-arrivee').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-date-arrivee').style.display = 'none';
            }

            // Vérification supplémentaire pour les dates
            var departDate = new Date(dateDepart.value);
            var arriveeDate = new Date(dateArrivee.value);

            if (departDate > arriveeDate) {
                document.getElementById('error-date-arrivee').textContent = 'La date d\'arrivée ne peut pas être antérieure à la date de départ.';
                document.getElementById('error-date-arrivee').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-date-arrivee').style.display = 'none';
            }

            if (!cargoPlein) {
                document.getElementById('error-cargo-plein').style.display = 'inline';
                valid = false;
            } else {
                document.getElementById('error-cargo-plein').style.display = 'none';
            }

            if (valid) {
                var numero = 'CGN' + Math.floor(Math.random() * 1000);  // Génération d'un numéro de cargaison unique
                var cargo = {
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
                };  fetch('cargo.php', {
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
                        var jsonData = JSON.parse(data);
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

    // FILTRE CARD
</script>
</body>
</html>