<?php

/**
 * show
 * affiche les données dans un format lisible
 * @return void
 */
function show($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * checkError
 * vérifie si il y a une erreur et l'affiche
 * @return void
 */
function checkError()
{
    $msgError = "";
    if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
        $msgError .= '<div class="bg-danger p-3">
                            <span style="font-size:24px" >' . $_SESSION['error'] . '</span>
                    </div>';
    }
    unset($_SESSION['error']);
    echo $msgError;
}

/**
 * validateData
 * valide $data avant de l'insérer dans la BDD
 * @param  mixed $data
 * @return mixed
 */
function validateData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}
