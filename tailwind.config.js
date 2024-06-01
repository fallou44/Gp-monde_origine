/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.php',
    './src/**/*.{ts,js}',  // Assurez-vous que vos fichiers TypeScript sont dans le dossier src
    './classes/**/*.{ts,js}', // Inclure les fichiers dans le dossier classes si nécessaire
    'node_modules/preline/dist/*.js',
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    
    require('preline/plugin'),
    require('flowbite/plugin')
  ],
}
