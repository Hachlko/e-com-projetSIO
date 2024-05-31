<?php

class Category
{
    /**
     * create
     * insere une nouvelle categ dans la BDD
     * @param  object $data
     * @return bool
     */
    public function create($data)
    {
        $db = Database::getInstance();
        $arr['nomCateg'] = $data->data;

        if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['nomCateg']))) {
            $_SESSION['error'] = "Veuillez entrer un nom de categorie valide.";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO categorie (nomCateg) VALUES (:nomCateg)";
            $check = $db->write($query, $arr);

            if ($check) {
                return true;
            }
        }
        return false;
    }

    /**
     * delete
     * supprime une catégorie dans la BDD
     * @param  int $idCategory
     * @return void
     */
    public function delete($idCategory)
    {
        $db = Database::getInstance();

        if (isset($idCategory)) {
            $check = $db->write("DELETE FROM categorie WHERE idCateg = $idCategory");

            if ($check) {
                return true;
            } else {
                $_SESSION['error'] = "Une erreur est survenue.";
            }
            return false;
        }
    }

    /**
     * updateCategory
     * maj d'une categ dans la BDD
     * @param  int $idCategory
     * @param  string $nameCategory
     * @return void
     */
    public function updateCategory($idCategory, $nameCategory)
    {
        $db = Database::getInstance();

        if (isset($idCategory) && isset($nameCategory)) {
            $query = "UPDATE  categorie SET nomCateg = :nomCateg WHERE idCateg = :idCateg";
            $arr['idCateg'] = $idCategory;
            $arr['nomCateg'] = $nameCategory;

            $check = $db->write($query, $arr);

            if ($check) {
                return true;
            } else {
                $_SESSION['error'] = "Une erreur est survenue.";
            }
            return false;
        }
    }

    /**
     * getAll
     * selectionne toutes les categories dans la BDD
     * @return array
     */
    public function getAll()
    {
        $db = Database::getInstance();
        $data = $db->read("SELECT idCateg, nomCateg FROM categorie ORDER BY idCateg DESC");
        return $data;
    }

    /**
     * makeTable
     * tableau pour la vue admin
     * @param  array $categories
     * @return string HTML elements
     */
    public function makeTable($categories)
    {
        $tableHTML = "";
        if (is_array($categories)) {
            foreach ($categories as $category) {
                $args = $category->idCateg . ",'" . $category->nomCateg . "'";

                $tableHTML .= '<tr>
                            <th scope="row">' . $category->idCateg . '</th>
                            <td>' . $category->nomCateg . '</td>
                            <td><button class="btn btn-primary" onclick="displayEditForm(' . $args . ')">Modifier</button></td>
                            <td><button class="btn btn-warning" onclick="deleteCategory(' . $category->idCateg . ')">Supprimer</button></td>
                        </tr>';
            }
        }
        return $tableHTML;
    }
}