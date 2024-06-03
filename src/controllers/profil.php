<?php

require_once('../src/core/controller.php');

class Profil extends Controller
{
    /**
     * index
     * charge le model user et la vue profil
     * @return view profil
     */
    public function index()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin', 'customer']);
        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $data['pageTitle'] = "Profil";
        $this->view('profil', $data);
    }

    /**
     * update
     * modifie les données de l'user dans la BDD
     * @return void
     */
    public function update()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin', 'customer']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            show($_POST);
            $user->updateUser($userData->idUser);
        }

        $data['pageTitle'] = "Modifier Profil";
        $this->view('updateProfil', $data);
    }

    /**
     * delete
     * supprime l'user de la BDD
     * @return void
     */
    public function delete()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin', 'customer']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $user->deleteUser($userData->idUser);
    }

    /**
     * commands
     * charge les commandes de l'user
     * @return void
     */
    public function commands()
    {
        $user = $this->loadModel('User');
        $userData = $user->checkLogin(['admin', 'customer']);

        if (is_object($userData)) {
            $data['userData'] = $userData;
        }

        $command = $this->loadModel('CommandModel');
        $allCommandsUser = $command->getAllCommandsUser($userData->idUser);
        $commandsHTML =  $command->makeTableUser($allCommandsUser);
        $noCommand = "";

        if (strlen($commandsHTML == "")) {

            $noCommand =  "<p class='text-center'>Vous n'avez aucune commande</p>";
        }

        $data['noCommand'] = $noCommand;
        $data['commands'] = $commandsHTML;
        $data['pageTitle'] = "Mes commandes";
        $this->view('commands', $data);
    }
    
    /**
     * details
     * charge le details des commandes
     * @return void
     */
    public function details(){
        $user = $this->loadModel('User');
        $userData = $user->checkLogin();

        if(is_object($userData)){
            $data['userData'] = $userData;
        }

        $command = $this->loadModel('CommandModel');
        $allDetails = $command->getAllDetailsCommand();
        $detailsHTML = $command->makeTableAllDetails($allDetails);
        $noCommand = "";

        if (strlen($detailsHTML == "")) {

            $noCommand =  "<p class='text-center'>Vous n'avez aucune commande</p>";
        }

        $data['noCommand'] = $noCommand;
        $data['details'] = $detailsHTML;
        $data['pageTitle'] = "Détails de mes Commandes";
        $this->view('detailsCommand', $data);
    }
}