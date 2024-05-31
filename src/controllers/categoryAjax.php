<?php

require_once('../src/core/controller.php');

class CategoryAjax extends Controller
{
    public $category;

    public function __construct()
    {
        $this->category = $this->loadModel('Category');
    }

    /**
     * index
     * récupère les données du js et le transmet en sql
     * @return void
     */
    public function index()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        if (is_object($data) && isset($data->dataType)) {

            if ($data->dataType == "addCategory") {
                $this->createCategory($data);
            } elseif ($data->dataType == "deleteCategory") {
                $this->deleteCategory($data);
            } elseif ($data->dataType == "updateCategory") {
                $this->updateCategory($data->idCategory, $data->nameCategory);
            }
        }
    }

    /*
     * createCategory
     * insère la categ dans la bdd et renvoit le msg de succès ou d'erreur
     * @param  mixed $data
     * @return void
     */
    private function createCategory($data)
    {
        $result = $this->category->create($data);
        if ($result) {
            $arr['message'] = "Insertion OK";
            $arr['messageType'] = "info";
            $categories = $this->category->getAll();
            $arr['data'] = $this->category->makeTable($categories);
            $arr['dataType'] = "addCategory";
            echo json_encode($arr);
        } else {
            $arr['message'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $arr['messageType'] = "error";
            $arr['data'] = "";
            $arr['dataType'] = "addCategory";
            echo json_encode($arr);
        }
    }

    /**
     * deleteCategory
     * supprime une categ dans la BDD
     * @param  object $data
     * @return void
     */
    private function deleteCategory($data)
    {
        $result = $this->category->delete($data->data);
        if ($result) {
            $arr['message'] = "Supression de la catégorie OK";
            $arr['messageType'] = "info";
            $categories = $this->category->getAll();
            $arr['data'] = $this->category->makeTable($categories);
            $arr['dataType'] = "deleteCategory";
            echo json_encode($arr);
        } else {
            $arr['message'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $arr['messageType'] = "error";
            $arr['data'] = "";
            $arr['dataType'] = "deleteCategory";
            echo json_encode($arr);
        }
    }

     /**
     * updateCategory
     * modifie le nom d'une categ dans la BDD
     * @param  int $idCategory
     * @param  string $nameCategory
     * @return void
     */
    private function updateCategory($idCategory, $nameCategory)
    {
        $result = $this->category->updateCategory($idCategory, $nameCategory);

        if ($result) {
            $arr['message'] = "Modification de la catégorie OK";
            $arr['messageType'] = "info";
            $categories = $this->category->getAll();
            $arr['data'] = $this->category->makeTable($categories);
            $arr['dataType'] = "updateCategory";
            echo json_encode($arr);
        } else {
            $arr['message'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $arr['messageType'] = "error";
            $arr['data'] = "";
            $arr['dataType'] = "updateCategory";
            echo json_encode($arr);
        }
    }
}