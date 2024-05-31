<?php

require_once('../src/core/controller.php');

class Logout extends Controller
{
    /**
     * index
     * charge le model user et la methode logout
     * @return void
     */
    public function index()
    {
        $user = $this->loadModel('User');
        $user->logout();
    }
}