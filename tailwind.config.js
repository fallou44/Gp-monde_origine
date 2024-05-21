/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.html',
    './src/**/*.{ts,js}',  // Assurez-vous que vos fichiers TypeScript sont dans le dossier src
    './classes/**/*.{ts,js}', // Inclure les fichiers dans le dossier classes si nécessaire
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
