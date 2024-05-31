<?php

require_once('../src/core/controller.php');

class Signup extends Controller
{
    /**
     * index
     * charge le model user et la vue 
     * @return view signup
     */
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $user = $this->loadModel("User");
            $user->signup();
        }

        $data['pageTitle'] = "Signup";
        $this->view("signUp", $data);
    }
}