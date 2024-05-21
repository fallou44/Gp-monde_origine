import { Cargaison } from './Cargaison.js';

export class Maritime extends Cargaison {
  getMontant(): number {
    return this.distance * 5; // Exemple de calcul spécifique pour Maritime
  }
}
