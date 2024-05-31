<?php 
require_once './bdd/DbManager.php';
require_once 'classTable.php';
class ProduitsManager{
    private static ?\PDO $cnx = NULL;

    public static function getUnProduitParId(int $idProduit): Produits{
        try{
            //vérifie la connexion à la base de données et se connecte
            if(self::$cnx == null){
                self::$cnx = DbManager::getBddConnexion();
            }

            $sql = "select nomProduit, codeCateg, prixUnit, qteStock, descProduit, pathImg";
            $sql .= " from produits";
            $sql.= " where idProduit = :idProduit";

            /*
            * Prépare la requête =
            * - les valeurs sont échappées
            * - les valeurs remplacent les paramètres
            */
            $stmt = self::$cnx->prepare($sql);
            $stmt->bindParam('idProduit', $idProduit);

            //exécute la requête 
            $stmt->execute();

            //définit le format de lecture "tableau associatif"
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            //boucle de parcours du résultat
            while ($row = $stmt->fetch()){
                // transforme la ligne résultat en un objet
                // récupère l'objet Bateau correspondant à l'idBateau
                $unProduit = new Produits ( $row['nomProduit'], $row['codeCateg'], $row['prixUnit'], $row['qteStock'], $row['descProduit'], $row['pathImg']);
            }

        }catch(PDOException $e){
            die('Erreur: ' .$e->getMessage());
        }

        //retourne l'objet produit en résultat
        return $unProduit;
    }

    /**
     * getLesProduits
     * recupère un tableau d'objet produit
     */

     public static function getLesProduitsFiltre(int $idCateg): array{

        $lesProduits = array();
        try{
            if(self::$cnx == null)
            {
                self::$cnx = DbManager::getBddConnexion();
            }

            $sql = 'select idProduit, nomProduit, codeCateg, prixUnit, qteStock, descProduit, pathImg';
            $sql .= ' from produits';
            $sql.= ' where codeCateg = :idCateg';

            $stmt = self::$cnx->prepare($sql);
            $stmt->bindParam('idCateg', $idCateg);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while($row = $stmt->fetch()){

                $unProduit = new Produits(ProduitsManager::getUnProduitParId($row['idProduit']));
                $lesProduits[] = $unProduit;
            }
        }catch(PDOException $e){
            die('Erreur: ' .$e->getMessage());
        }
        return $lesProduits;
     }

     public static function AfficherListeProduit(): string{
        $lesProduits= ProduitsManager::getLesProduitsFiltre(1);

        foreach($lesProduits as $unProduit){
        $html= '<div class="card col-md-2 cartdep" style="width: 18rem;">';
        $html.= '<img src='.$unProduit->GetImgProduit().' class="card-img-top">';
        $html .='<div class="card-body">';
        $html.='<h5 class="card-title">Tuyau Piscine <br>6 mètres</h5>';
        $html.='<a href="#" class="btn">En savoir plus</a>';
        $html.='</div>
            </div>';

        echo $html;
        }
     }

     public static function GetLaCategNom(string $lib): int{

        try{
            if(self::$cnx == null)
            {
                self::$cnx = DbManager::getBddConnexion();
            }

            $sql = 'select idCateg';
            $sql .= ' from categorie';
            $sql .= ' where nomCateg = :lib';
            

            $stmt = self::$cnx->prepare($sql);
            $stmt->bindParam('lib', $lib);
            

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($row = $stmt->fetch()){

               $id = $row['idCateg'];
            }
        }catch(PDOException $e){
            die('Erreur: ' .$e->getMessage());
        }
        return $id;
     }
}

?>