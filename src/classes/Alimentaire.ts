import { Produit } from './Produit.js';

export class Alimentaire extends Produit {
  getMontant(): number {
    return this.poids * 5; // Exemple de calcul spécifique pour Alimentaire
  }
}
