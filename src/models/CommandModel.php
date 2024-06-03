<?php

require_once('../src/models/Product.php');
class CommandModel
{
    /**
     * create
     * insère une commande dans la BDD
     */
    public function create()
    {
        $db = Database::getInstance();
        $montant = 0;

        for ($i = 0; $i < count($_SESSION['cart']['price']); $i++) {
            $montant += $_SESSION['cart']['price'][$i] * $_SESSION['cart']['quantity'][$i];
        }

        $arr['userId'] = $_SESSION['idUser'];
        $arr['montantCmd'] = $montant;

        $query = "INSERT INTO commandes (userId, montantCmd, dateCmd) 
             VALUES (:userId, :montantCmd, NOW())";
        $db->write($query, $arr);

        $idCommand =  $db->getLastInsertId();
        $this->createDetailsCommand($idCommand);
        return $idCommand;
    }

    /**
     * createDetailsCommand
     * insère les detailscmd dans la BDD
     * @param  int $idCommand
     */
    public function createDetailsCommand($idCommand)
    {
        $db = Database::getInstance();

        for ($i = 0; $i < count($_SESSION['cart']['idProduct']); $i++) {
            $arr['numCmd'] = $idCommand;
            $arr['idProduit'] = $_SESSION['cart']['idProduct'][$i];
            $arr['qteCmd'] = $_SESSION['cart']['quantity'][$i];

            $query = "INSERT INTO detailsCmd (numCmd, idProduit, qteCmd)
            VALUES (:numCmd, :idProduit, :qteCmd)";

            $db->write($query, $arr);
        }
    }

    /**
     * getDetailsCommand
     * recupere un detailsCmd de la BDD
     */
    public function getAllDetailsCommand(){
        $db = Database::getInstance();

        $result = $db->read("SELECT numCmd, idProduit, qteCmd FROM detailscmd ORDER BY numCmd");
        return $result;
    }

    /**
     * getUnDetailsCommand
     * recupere un detailsCmd de la BDD
     */
    public function getUnDetailsCommand($idCommand){
        $db = Database::getInstance();

        $result = $db->read("SELECT numCmd, idProduit, qteCmd FROM detailscmd WHERE numCmd = $idCommand ORDER BY numCmd");
        return $result;
    }

    /**
     * getAllCommands
     * selectionne toutes les cmd de la BDD
     * @return array
     */
    public function getAllCommands()
    {
        $db = Database::getInstance();
        $result = $db->read("SELECT numCmd, dateCmd, userId, montantCmd FROM commandes ORDER BY numCmd DESC");
        return $result;
    }

     /**
     * getAllCommandsUser
     * selectionne toutes les cmd de la BDD d'un user 
     * @return array
     */
    public function getAllCommandsUser($idMember)
    {
        $db = Database::getInstance();
        $result = $db->read("SELECT numCmd, dateCmd, userId, montantCmd FROM commandes WHERE userId = $idMember");
        return $result;
    }

    /**
     * makeTable
     * affichage des commandes
     * @param  array $commands
     * @return string elements
     */
    public function makeTable($commands)
    {
        $tableHTML = "";
        if (is_array($commands)) {
            foreach ($commands as $command) {
                $date = date("d/m/Y H:i:s", strtotime($command->dateCmd));
                $tableHTML .= '<tr>
                            <th scope="row">' . $command->numCmd . '</th>
                            <td>' . $command->userId . '</td>
                            <td>' . $command->montantCmd . '</td>
                            <td>' . $date . '</td>
                        </tr>';
            }
        }
        return $tableHTML;
    }

    public function makeTableUser($commands)
    {
        $tableHTML = "";
        if (is_array($commands)) {
            foreach ($commands as $command) {
                $date = date("d/m/Y H:i:s", strtotime($command->dateCmd));
                $tableHTML .= '<tr>
                <td>' . $date . '</td>
                            <td>' . $command->montantCmd . '</td>
                        </tr>';
            }
        }
        return $tableHTML;
    }

    /**
     * makeTableUnDetails
     * Affiche un tableau html du details d'une commande donnée
     * @param object $dtsCommand
     * @return string
     */
    public function makeTableUnDetails($dtsCommand){
        $tableHTML = "";
        if(is_object($dtsCommand)){
            $Prod = new Product;
            $unProd = $Prod->getOneProduct($dtsCommand->idProduit);
            foreach($unProd as $leProd){
                $tableHTML .= '<tr>
                            <td>' . $dtsCommand->numCmd . '</td>
                            <td>' . $leProd->nomProduit . '</td>
                            <td>' . $dtsCommand->qteCmd . '</td>
                            </tr>';
            }
        }
        return $tableHTML;
    }

    /**
     * Undocumented function
     * affiche un tableau html des details de tout les commandes
     * @param array $dtsCommands
     * @return string
     */
    public function makeTableAllDetails($dtsCommands){
        $tableHTML = "";
        if(is_array($dtsCommands)){
            foreach($dtsCommands as $dtsCommand){
                $tableHTML .= $this->makeTableUnDetails($dtsCommand);
            }
        }
        return $tableHTML;
    }
}