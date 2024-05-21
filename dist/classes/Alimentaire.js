import { Produit } from './Produit.js';
export class Alimentaire extends Produit {
    getMontant() {
        return this.poids * 5; // Exemple de calcul spécifique pour Alimentaire
    }
}
