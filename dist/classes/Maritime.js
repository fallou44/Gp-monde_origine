import { Cargaison } from './Cargaison.js';
export class Maritime extends Cargaison {
    getMontant() {
        return this.distance * 5; // Exemple de calcul spécifique pour Maritime
    }
}
