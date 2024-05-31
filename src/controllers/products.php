<?php

require_once('../src/core/controller.php');

class Products extends Controller
{
    /**
     * index
     * charge le model user et la vue
     * @return view home
     */
    public function index()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $product = $this->loadModel('Product');
        $allProducts = $product->getAllProducts();
        $htmlProducts = $product->makeFrontProducts($allProducts);
        $data['htmlProducts'] = $htmlProducts;

        if (strlen($htmlProducts) == 0) {
            $data['htmlProducts'] = "Il n'y a aucun produit pour l'instant sur notre site. Revenez plus tard ! ";
        }

        $data['pageTitle'] = "Produits";
        $this->view("products", $data);
    }

    /**
     * details
     * recupere les données du produit et charge la fiche produit
     * @param  int $idProduct
     * @return view detailsProduct
     */
    public function details($idProduit)
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        //recupere les données du produit
        $product = $this->loadModel('Product');
        $unProduct = $product->getOneProduct($idProduit);

        $data['product'] = $unProduct[0];
        $data['pageTitle'] = "Details Produit";
        $this->view("detailsProduct", $data);
    }
}