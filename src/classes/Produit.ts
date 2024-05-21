export abstract class Produit {
    libelle: string;
    poids: number;
  
    constructor(libelle: string, poids: number) {
      this.libelle = libelle;
      this.poids = poids;
    }
  
    abstract getMontant(): number;
  }
  