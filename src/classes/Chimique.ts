import { Produit } from './Produit.js';

export class Chimique extends Produit {
  degreToxicite: number;

  constructor(libelle: string, poids: number, degreToxicite: number) {
    super(libelle, poids);
    this.degreToxicite = degreToxicite;
  }

  getMontant(): number {
    return this.poids * 15 * this.degreToxicite; // Exemple de calcul spécifique pour Chimique
  }
}
