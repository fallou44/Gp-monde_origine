import { Produit } from './Produit.js';

export abstract class Cargaison {
  distance: number;
  produits: Produit[] = [];

  constructor(distance: number) {
    this.distance = distance;
  }

  ajouterProduit(produit: Produit) {
    this.produits.push(produit);
  }

  nbProduit(): number {
    return this.produits.length;
  }

  sommetotaleC(): number {
    return this.produits.reduce((total, produit) => total + produit.getMontant(), 0);
  }

  abstract getMontant(): number;
}
