import { Produit } from './Produit.js';
export class Chimique extends Produit {
    degreToxicite;
    constructor(libelle, poids, degreToxicite) {
        super(libelle, poids);
        this.degreToxicite = degreToxicite;
    }
    getMontant() {
        return this.poids * 15 * this.degreToxicite; // Exemple de calcul spécifique pour Chimique
    }
}
