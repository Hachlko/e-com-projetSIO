<?php

require_once('../src/core/controller.php');

class Login extends Controller
{
    /**
     * index
     * charge le model user et la vue login
     * @return view login
     */
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $user = $this->loadModel("User");
            $user->login();
        }

        $data['pageTitle'] = "Login";
        $this->view("login", $data);
    }
}