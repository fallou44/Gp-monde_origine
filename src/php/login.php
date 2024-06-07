<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        #map {
            height: 200px;
            width: 90%;
            border-radius: 20px;
            margin-left: 12px;
        }
    </style>
</head>
<body class="relative antialiased bg-teal-800">
    <div class="min-h-screen sm:flex sm:flex-row mx-0 justify-center gap-12">
        <div class="flex-col flex self-center mt-[75px] pr-[180px] sm:max-w-5xl xl:max-w-2xl z-10">
            <div class="justify-start hidden lg:flex flex-col text-teal-50 mt-1">
                <img src="" class="mb-3">
                <h1 class="mb-3 font-bold text-5xl">Salut et bienvenue sur GP-MONDE !</h1>
                <p class="pr-3">Que puis-je faire pour vous aider ? Saisissez votre code de suivi si vous avez des questions sur votre colis.</p>
            </div>
            <br>
            <div class="space-y-2">
                <label class="mb-5 text-sm font-medium text-white tracking-wide">VOTRE CODE !</label>
                <br>
                <form action="search_cargo.php" method="GET">
    <input name="cargo_code" class="w-11/12 content-center text-base px-16 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-400" type="text" placeholder="Enter your code">
    <button type="submit" class="mt-4 w-11/12 flex justify-center bg-teal-400 hover:bg-teal-900 text-gray-100 p-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">Rechercher</button>
</form>

            </div>
            <div class="flex justify-center mt-8">
                <div id="map" class="w-full h-96"></div>
            </div>
        </div>
        <div class="flex justify-center self-center z-10">
            <div class="p-12 bg-white mx-auto rounded-2xl w-100 ">
                <div class="mb-4">
                    <h3 class="font-semibold text-2xl text-gray-800">Connexion</h3>
                    <p class="text-gray-500">Connectez-vous à votre compte s'il vous plaît.</p>
                </div>
                <div class="space-y-5">
                    <form action="auth.php" method="POST">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 tracking-wide">Email</label>
                            <input class="w-full text-base px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-500" type="email" name="email" placeholder="mail@gmail.com">
                        </div>
                        <div class="space-y-2">
                            <label class="mb-5 text-sm font-medium text-gray-700 tracking-wide">Password</label>
                            <input class="w-full content-center text-base px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-400" type="password" name="password" placeholder="Enter your password">
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 bg-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-800">Remember me</label>
                            </div>
                            <div class="text-sm">
                                <a href="#" class="text-teal-400 hover:text-teal-400">Forgot your password?</a>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-full flex justify-center bg-teal-400 hover:bg-teal-900 text-gray-100 p-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">Sign in</button>
                        </div>
                    </form>
                </div>
                <div class="pt-5 text-center text-gray-400 text-xs">
                    <span>Copyright © Sonatel Academy <a href="https://github.com/fallou44/" rel="" target="_blank" title="fadildev" class="text-green hover:text-teal-600">Fadildev</a></span>
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([51.505, -0.09], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker([51.5, -0.09]).addTo(map)
                .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                .openPopup();
        });
    </script> -->
</body>
</html>
