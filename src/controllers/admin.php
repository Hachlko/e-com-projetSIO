<?php

require_once('../src/core/controller.php');

class Admin extends Controller
{
    /**
     * index
     * charge le model user et l'index admin
     * @return admin/index view
     */
    public function index()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin']);
        if (is_object($userData)) {
            $data['userData'] = $userData;
        }
        $data['pageTitle'] = "Admin - Home";
        $this->view("admin/index", $data);
    }

     /**
     * categories
     * model user et categ admin
     * @return admin/categories view
     */
    public function categories()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        // recupere toutes les categ pour le tableau html
        $category = $this->loadModel('Category');
        $allCategories = $category->getAll();
        $tableHTML = $category->makeTable($allCategories);
        $noCat = "";

        if (strlen($tableHTML == "")) {
            $noCat =  "<p class='text-center'>Vous n'avez aucune categorie. Vous devez en ajouter au moins une pour créer un produit !</p>";
        }

        $data['noCat'] = $noCat;
        $data['tableHTML'] = $tableHTML;
        $data['pageTitle'] = "Admin - Categories";
        $this->view("admin/categories", $data);
    }

     /**
     * categories
     * model user et produit admin
     * @return admin/categories view
     */
    public function products($method = false, $arg = "")
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $product = $this->loadModel('Product');

        if ($method === "add") {
            $this->addProduct($data, $product);
        } elseif ($method === "update") {
            $this->updateProduct($data, $product,  $arg);
        } elseif ($method === "home") {
            // récupère tout les produits pour le tableau html
            $allProducts = $product->getAllProducts();
            $tableHTML = $product->makeTable($allProducts);
            $noProd = "";

            if (strlen($tableHTML == "")) {
                $noProd =  "<p class='text-center'>Vous n'avez aucun produit. Vous devez avoir au moins une catégorie pour créer un produit !</p>";
            }

            $data['noProd'] = $noProd;
            $data['tableHTML'] = $tableHTML;
            $data['pageTitle'] = "Admin - Products";
            $this->view("admin/products", $data);
        }
    }

      /**
     * commands
     * affiche les commandes utilisateurs
     * @return view admin/commands
     */
    public function commands()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $commandModel = $this->loadModel("CommandModel");
        $allCommands = $commandModel->getAllCommands();
        $commandsHTML = $commandModel->makeTable($allCommands);
        $noCom = "";

        if (strlen($commandsHTML == "")) {
            $noCom =  "<p class='text-center'>Aucun client n'a passé de commande !</p>";
        }

        $data['noCom'] = $noCom;
        $data['commandsHTML'] = $commandsHTML;
        $data['pageTitle'] = "Admin - Commandes";
        $this->view("admin/commands", $data);
    }

    /**
     * addProduct
     * charge la page admin addproduit
     * @param  array $data
     * @return admin/products/add view
     */
    public function addProduct($data, $productModel)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $productModel->create();
            header("Location: " . ROOT . "admin/products");
        }

        // récupère les categ pour le formulaire
        $category = $this->loadModel('Category');
        $allCategories = $category->getAll();
        $selectHTML = $productModel->makeSelectCategories($allCategories);

        if ($selectHTML == "") {
            header("Location: " . ROOT . "admin/categories");
        }

        $data['selectHTML'] = $selectHTML;
        $data['categories'] = $allCategories;
        $data['pageTitle'] = "Admin - Add Product";
        $this->view("admin/addProduct", $data);
    }

    /**
     * deleteProduct
     * supprime un produit dans la BDD  
     * @param  int $idProduct
     * @return void
     */
    public function deleteProduct($idProduct)
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }
        //recupere les données du produit
        $product = $this->loadModel('Product');
        $product->deleteProduct($idProduct);
    }

    /**
     * updateProduct
     * met à jour un produit dans la BDD
     * @param  arrays $data
     * @param  object $product
     * @param  int $idProduct
     * @return view admin/updateProduct
     */
    public function updateProduct($data, $product, $idProduct)
    {
        $singleProduct  = $product->getOneProduct($idProduct);

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $singleProduct  = $product->getOneProduct($idProduct);
            $product->updateProduct($singleProduct[0]->idProduct);
        }

        // récupère les données du produit
        $category = $this->loadModel('Category');
        $allCategories = $category->getAll();
        $selectHTML = $product->makeSelectCategories($allCategories);
        $data['selectHTML'] = $selectHTML;
        $data['categories'] = $allCategories;
        $data['product'] = $singleProduct[0];
        $data['pageTitle'] = "Admin - update Product";
        $this->view("admin/updateProduct", $data);
    }

    /**
     * users
     * lis et affiche tout les users
     * @return view admin/users
     */
    public function users($method = false, $arg = "")
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        if ($method === "viewAdmins") {
            $this->viewAdmins($data, $user);
        } elseif ($method === "viewCustomers") {
            $this->viewCustomers($data, $user);
        } elseif ($method === "home") {
            $allUsers = $user->getAllUsers();
            $usersHTML = $user->makeTableUsers($allUsers);
            $noCus = "";
            $data['noCus'] = $noCus;
            $data['users'] = $usersHTML;
            $data['pageTitle'] = "Admin - Users";
            $this->view("admin/users", $data);
        }
    }

    /**
     * viewAdmins
     * affiche tout les admins users
     * @param  array $data
     * @param  object $user
     * @return view admin/users
     */
    public function viewAdmins($data, $user)
    {
        $allAdmins = $user->getAllAdmins();
        $adminsHTML = $user->makeTableUsers($allAdmins);
        $data['users'] = $adminsHTML;
        $data['pageTitle'] = "Admin - Views Admins";
        $noCus = "";

        $data['noCus'] = $noCus;
        $this->view("admin/users", $data);
    }

    /**
     * viewCustomers
     * affiche tout les clients
     * @param  array $data
     * @param  object $user
     * @return view admin/users
     */
    public function viewCustomers($data, $user)
    {
        $allCustomers = $user->getAllCustomers();
        $customersHTML = $user->makeTableUsers($allCustomers);

        $noCus = "";

        if (strlen($customersHTML == "")) {
            $noCus =  "<p class='text-center'>Vous n'avez aucun client inscrit dans votre site ! </p>";
        }

        $data['noCus'] = $noCus;
        $data['users'] = $customersHTML;
        $data['pageTitle'] = "Admin - Views Customers";
        $this->view("admin/users", $data);
    }
}