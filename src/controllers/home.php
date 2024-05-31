<?php

require_once('../src/core/controller.php');

class Home extends Controller{
    /**
     * index
     * charge le model user et le template home.php
     * @return view home
     */
    public function index(){
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if(is_object($userData)) {
            $data['userData'] = $userData;
        }
        $product = $this->loadModel('Product');
        $allProducts = $product->getAllProducts();
        $htmlProducts = $product->makeFrontProducts($allProducts);

        $data['htmlProducts'] = $htmlProducts;

        if(strlen($htmlProducts) == 0){
            $data['htmlProducts'] = "Nous sommes actuellement en rupture de stock. Revenez plus tard ! ";
        }

        $data['pageTitle'] = "Home";
        $this->view("home", $data);
    }
}