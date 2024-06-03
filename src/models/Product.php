<?php

class Product
{
    private $error = "";

    /**
     * create
     * insère un produit dans la BDD
     * @return void
     */
    public function create()
    {
        $db = Database::getInstance();
        $data = array();

        $data['nomProduit'] = validateData($_POST['name']);
        $data['descProduit'] = validateData($_POST['description']);
        $data['prixUnit'] = validateData($_POST['price']);
        $data['prixUnit'] = (int)$data['prixUnit'];
        $data['qteStock'] = validateData($_POST['stock']);
        $data['qteStock'] = (int)$data['qteStock'];
        $data['codeCateg'] = validateData($_POST['category']);
        $data['codeCateg'] = (int)$data['codeCateg'];

        $data['pathImg'] = $_FILES['image']['name'];

        if (empty($data['nomProduit'])) {
            $this->error .= "Veuillez entrez un nom de produit valide. <br>";
        }

        if (empty($data['descProduit'])) {
            $this->error .= "Veuillez entrez une description de produit. <br>";
        }

        if (empty($data['prixUnit'])) {
            $this->error .= "Veuillez entrez un prix de produit valide. <br>";
        }

        if (empty($data['qteStock'])) {
            $this->error .= "Veuillez entrez un stock de produit valide. <br>";
        }

        if (empty($data['codeCateg'])) {
            $this->error .= "Veuillez entrez une catégorie de produit. <br>";
        }

        if (empty($data['pathImg'])) {
            $this->error .= "Veuillez choisir une image de produit. <br>";
        }

        if ($this->error == "") {
            $nameImage = $this->getRandomString(5) . '_' . $data['pathImg'];
            $data['pathImg'] = $nameImage;

            $directory = $_SERVER['DOCUMENT_ROOT'] . ROOT_PATH . "public/assets/img/" . $nameImage;
            copy($_FILES['image']['tmp_name'], $directory);
            $query = "INSERT INTO product (nomProduit, descProduit, pathImg, prixUnit, qteStock, codeCateg) 
            VALUES (:nomProduit, :descProduit, :pathImg, :prixUnit, :qteStock, :codeCateg)";

            $result = $db->write($query, $data);
            if ($result) {
                echo "OK";
            } else {
                echo "pas ok";
            }
        }
        $_SESSION['error'] = $this->error;
    }

     /**
     * getRandomString
     * retourne un string aléatoire
     * @param  int $length
     * @return string
     */
    private function getRandomString($length)
    {
        $array = range('a', 'z');
        $text = "";
        $length = rand(4, $length);

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, count($array) - 1);
            $text .= $array[$random];
        }
        return $text;
    }

    /**
     * getAllProducts
     * selectionne tout les produits dans la BDD
     * @return array
     */
    public function getAllProducts()
    {
        $db = Database::getInstance();
        $query = "SELECT idProduit, nomProduit, descProduit, pathImg, prixUnit, qteStock, codeCateg FROM produits INNER JOIN categorie ON produits.codeCateg = categorie.idCateg";
        $data = $db->read($query);
        return $data;
    }

    /**
     * getOneProduct
     * selectionne un produit donner
     * @param  int $idProduct
     * @return object
     */
    public function getOneProduct($idProduct)
    {
        $arr['idProduit'] = $idProduct;
        $db = Database::getInstance();
        $query = "SELECT idProduit, nomProduit, descProduit, pathImg, prixUnit, qteStock, codeCateg FROM produits INNER JOIN categorie ON produits.codeCateg = categorie.idCateg WHERE idProduit = :idProduit";
        $data = $db->read($query, $arr);
        return $data;
    }

    /**
     * makeSelectCategories
     * crée l'élément html pour l'ajout de produit
     * @param  arrays $categories
     * @return string HTML
     */
    public function makeSelectCategories($categories)
    {
        $selectHTML = "";
        foreach ($categories as $category) {
            $selectHTML .= '<option value="' . $category->idCateg . '">' . $category->nomCateg . '</option>';
        }
        return $selectHTML;
    }

    /**
     * makeTable
     * crée un tableau pour la vue admin
     * @param  array $products
     * @return string HTML elements
     */
    public function makeTable($products)
    {
        $tableHTML = "";
        if (is_array($products)) {
            foreach ($products as $product) {
                $tableHTML .= '<tr>
                            <th scope="row">' . $product->idProduit . '</th>
                            <td>' . $product->nomProduit . '</td>
                            <td>' . $product->descProduit . '</td>
                            <td>' . $product->prixUnit . ' </td>
                            <td>' . $product->qteStock . '</td>
                          
                            
                            <td>' . $product->codeCateg . '</td>
                            <td><button class="btn btn-primary"><a href=products/update/' . $product->idProduit . '>Modifier</a></button></td>
                            <td><button class="btn btn-warning"><a href=deleteProduct/' . $product->idProduit . '>Supprimer</a></button></td>
                        </tr>';
            }
        }
        return $tableHTML;
    }


    /**
     * makeFrontProducts
     * retourne des elements HTML pour la page produit
     * @param  array $products
     * @return string HTML
     */
    public function makeFrontProducts($products)
    {
        $html = "";

        if (is_array($products)) {
            foreach ($products as $product) {
                $html .= '<div class="col-12 col-sm-6 col-lg-4 my-3">
                            <div class="card">
                                <img width=90% src="' . ASSETS . 'img/' . $product->pathImg . '"  style="height:200px; width:100%;object-fit: cover;">
                               
                                <div class="card-body">
                                    <h5 class="card-title">' . $product->nomProduit . '</h5>
                                    <p class="card-text"' . $product->descProduit . '</p>
                                    <a href="' . ROOT . 'products/details/' . $product->idProduit . '" class="btn btn-info">Voir plus</a>
                                </div>
                            </div>
                        </div>';
            }
        }
        return $html;
    }

    /**
     * deleteProduct
     * supprimer un produit de la BDD
     * @param  int $idProduct
     * @return void
     */
    public function deleteProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->write("DELETE FROM produits WHERE idProduit = $idProduct");
        header("Location: " . ROOT . "admin/products");
    }

    /**
     * updateProduct
     * update one product in the BDD
     * @param  int $idProduct
     * @return void
     */
    public function updateProduct($idProduct)
    {
        $db = Database::getInstance();
        $data = array();

        $data['nomProduit'] = validateData($_POST['name']);
        $data['descProduit'] = validateData($_POST['description']);
        $data['prixUnit'] = validateData($_POST['price']);
        $data['prixUnit'] = (int)$data['prixUnit'];
        $data['qteStock'] = validateData($_POST['stock']);
        $data['qteStock'] = (int)$data['qteStock'];
        $data['codeCateg'] = validateData($_POST['category']);
        $data['codeCateg'] = (int)$data['codeCateg'];

        $data['pathImg'] = $_FILES['image']['name'];

        if (empty($data['nomProduit'])) {
            $this->error .= "Veuillez entrez un nom de produit valide. <br>";
        }

        if (empty($data['descProduit'])) {
            $this->error .= "Veuillez entrez une description de produit. <br>";
        }

        if (empty($data['prixUnit'])) {
            $this->error .= "Veuillez entrez un prix de produit valide. <br>";
        }

        if (empty($data['qteStock'])) {
            $this->error .= "Veuillez entrez un stock de produit valide. <br>";
        }

        if (empty($data['codeCateg'])) {
            $this->error .= "Veuillez entrez une catégorie de produit. <br>";
        }

        if (empty($data['pathImg'])) {
            $this->error .= "Veuillez choisir une image de produit. <br>";
        }

        if ($this->error == "") {
            $nameImage = $this->getRandomString(5) . '_' . $data['pathImg'];
            $data['pathImg'] = $nameImage;
            $data['idProduit'] =  (int)$idProduct;

            $directory = $_SERVER['DOCUMENT_ROOT'] . ROOT_PATH . "public/assets/img/" . $nameImage;
            copy($_FILES['image']['tmp_name'], $directory);

            $query = "UPDATE produits SET nomProduit = :nomProduit, descProduit = :descProduit, pathImg = :pathImg, qteStock = :qteStock, prixUnit = :prixUnit, codeCateg = :codeCateg WHERE idProduit = :idProduit";
            $result = $db->write($query, $data);
            if ($result) {
                header("Location: " . ROOT . "admin/products");
                die;
            }
        }
        $_SESSION['error'] = $this->error;
    }
}