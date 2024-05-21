import { Cargaison } from './Cargaison.js';
export class Aerienne extends Cargaison {
    getMontant() {
        return this.distance * 10; // Exemple de calcul spécifique pour Aerienne
    }
}
