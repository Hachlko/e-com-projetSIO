<?php

require_once('../src/core/controller.php');

class Command extends Controller
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

        $command = $this->loadModel('CommandModel');
        $idCommand = $command->create();
        unset($_SESSION['cart']);
        $_SESSION['idCommand'] = $idCommand;
        header("location:" . ROOT . "cart");
    }
}