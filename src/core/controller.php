<?php

class Controller
{
    /**
     * view
     * charge un template
     * @return void
     */
    public function view($path, $data = []){
        extract($data);

        if (file_exists("../templates/" . $path . ".php")) {
            include "../templates/" . $path . ".php";
        }else {
            include "../templates/404.php";
        }
    }

    /**
     * loadModel
     * Charge un Modèle
     * @return object
     */
    public function loadModel($model){
        if (file_exists("../src/models/" . strtolower($model) . ".php")) {
            include "../src/models/" . strtolower($model) . ".php";
            return $a = new $model();
        }
        return false;
    }
}