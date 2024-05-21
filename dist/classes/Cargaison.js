export class Cargaison {
    distance;
    produits = [];
    constructor(distance) {
        this.distance = distance;
    }
    ajouterProduit(produit) {
        this.produits.push(produit);
    }
    nbProduit() {
        return this.produits.length;
    }
    sommetotaleC() {
        return this.produits.reduce((total, produit) => total + produit.getMontant(), 0);
    }
}
