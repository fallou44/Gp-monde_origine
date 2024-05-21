import { Produit } from './Produit.js';

export class Materiel extends Produit {
  getMontant(): number {
    return this.poids * 10; // Exemple de calcul spécifique pour Materiel
  }
}
