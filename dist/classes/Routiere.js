import { Cargaison } from './Cargaison.js';
export class Routiere extends Cargaison {
    getMontant() {
        return this.distance * 2; // Exemple de calcul spécifique pour Routiere
    }
}
