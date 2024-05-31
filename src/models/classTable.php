<?php
class Produits{
    private int $idP;
    private string $nom;
    private float $prixU;
    private int $qteRayon;
    private string $descP;
    private string $pathImg;
    private int $codeCateg;

    public function __construct(string $nom, int $codeCateg ,float $prixU, int $qteRayon , string $descP, string $pathImg){

        $this->nom=$nom;
        $this->prixU=$prixU;
        $this->qteRayon=$qteRayon;
        $this->descP=$descP;
        $this->pathImg=$pathImg;
        $this->codeCateg=$codeCateg;
    }

    public function GetIdProduit(){
        return $this->idP;
    }

    public function GetNomProduit(){
        return $this->nom;
    }
    
    public function GetPrixProduit(){
        return $this->prixU;
    }

    public function GetQteProduit(){
        return $this->qteRayon;
    }

    public function GetDescProduit(){
        return $this->descP;
    }

    public function GetImgProduit(){
        return $this->pathImg;
    }

    public function GetCategProduit(){
        return $this->codeCateg;
    }
}

class Categorie{
    private int $idC;
    private string $nomC;
    private string $descCateg;

    public function __construct(string $nomC, string $descCateg){

        $this->nomC=$nomC;
        $this->descCateg=$descCateg;
    }

    public function GetIdCateg(){
        return $this->idC;
    }
}

class Commandes{
    private int $numCmd;
    private DateTime $dateCmd;
    private int $idUser;
    private DateTime $dateLiv;
    private string $adr;
    private string $ville;
    private int $cp;

    public function __construct(DateTime $dateCmd, Utilisateur $idUser, string $adr, string $ville, int $cp){

        $this->dateCmd=$dateCmd;
        $this->idUser=$idUser;
        $this->adr=$adr;
        $this->ville=$ville;
        $this->cp =$cp;
    }


    public function GetNumCmd(){
        return $this->numCmd;
    }
}

class detailsCmd{
    private int $idP;
    private int $numCmd;
    private int $qteCmd;

    public function __construct(Produits $idP, Commandes $numCmd, int $qteCmd){

        $this->idP=$idP;
        $this->numCmd=$numCmd;
        $this->qteCmd=$qteCmd;
    }

    public function GetQteCmd(){
        return $this->qteCmd;
    }
}

class Utilisateur{
    private int $idUser;
    private string $uNom;
    private string $uPrenom;
    private string $adr;
    private string $ville;
    private int $cp;
    private string $mail;
    private string $password;

    public function __construct(string $nom, string $prenom, string $adr, string $ville, int $cp, string $mail, string $pswd){

        $this->uNom= $nom;
        $this->uPrenom =$prenom;
        $this->adr=$adr;
        $this->ville=$ville;
        $this->cp=$cp;
        $this->mail=$mail;
        $this->password=$pswd;
    }

    public function GetIdUser(){
        return $this->idUser;
    }
}