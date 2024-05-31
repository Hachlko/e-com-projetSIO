<?php
//ligne 32 et 215 mettre uNom en cas de problème
class User
{
    private $error = "";

    /**
     * signUp
     * verifie les données de l'inscription et l'enregistre si il n'y a pas d'erreur
     * @return void
     */
    public function signUp()
    {
        // $db = Database::newInstance();
        $db = Database::getInstance();

        $data = array();
        $data['uNom'] = validateData($_POST['name']);
        $data['uPrenom'] = validateData($_POST['firstname']);
        $data['uMail'] = validateData($_POST['email']);
        $data['uVille'] = validateData($_POST['city']);
        $data['uCp'] = validateData($_POST['postalCode']);
        $data['uAdr'] = validateData($_POST['adress']);
        $data['uPassword'] = $_POST['password'];
        $password2 = $_POST['password2'];

        // vérifie les données
        if (empty($data['uNom']) || !preg_match("/^[a-zA-Z-' ]*$/", $data['uNom'])) {
            $this->error .= "Veuillez entrez un nom valide. <br>";
        }

        if (empty($data['uPrenom']) || !preg_match("/^[a-zA-Z-' ]*$/", $data['uPrenom'])) {
            $this->error .= "Veuillez entrez un prénom valide. <br>";
        }

        if (empty($data['uMail']) || (!filter_var($data['uMail'], FILTER_VALIDATE_EMAIL))) {
            $this->error .= "Veuillez entrez un email valide. <br>";
        }

        if (empty($data['uCp']) || !preg_match("/^[0-9]{5}$/", $data['uCp'])) {
            $this->error .= "Veuillez entrez un code postal valide. <br>";
        }

        if (empty($data['uVille'])) {
            $this->error .= "Veuillez entrez une ville valide. <br>";
        }

        if (empty($data['uAdr'])) {
            $this->error .= "Veuillez entrez une adresse valide. <br>";
        }

        if ($data['uPassword'] !== $password2) {
            $this->error .= "Les mots de passes ne correspondent pas. <br>";
        }

        if (strlen($data['uPassword']) < 6) {
            $this->error .= "Le mot de passe doit être long de 6 caractères au minimun. <br>";
        }

        $checkEmail = $this->checkEmail($data);

        if (is_array($checkEmail)) {
            $this->error .= "L'email existe déjà, veuillez en renseigner un autre. <br>";
        }


        if ($this->error == "") {
            $data['uPassword'] = hash('sha1', $data['uPassword']);

            $query = "INSERT INTO utilisateur (uPassword, uNom, uPrenom, uMail, uVille, uCp, uAdr) 
            VALUES ( :uPassword, :uNom, :uPrenom, :uMail, :uVille, :uCp, :uAdr)";

            $result = $db->write($query, $data);
            if ($result) {
                header("Location: " . "login");
                die;
            }
        }
        $_SESSION['error'] = $this->error;
    }

    /**
     * login
     * verifie les données de connexion et connecte l'utilisateur si elles sont valides
     * @return void
     */
    public function login()
    {
        // $db = Database::newInstance();
        $db = Database::getInstance();
        $data = array();
        $data['uMail'] = validateData($_POST['email']);
        $data['uPassword'] = validateData($_POST['password']);

        if (empty($data['uMail'])) {
            $this->error .= "Veuillez entrez un email valide. <br>";
        }

        if (empty($data['uPassword'])) {
            $this->error .= "Veuillez renseigner votre mot de passe. <br>";
        }

        if ($this->error == "") {
            $data['uPassword'] = hash('sha1', $data['uPassword']);

            $sql = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword FROM utilisateur WHERE uMail = :uMail && uPassword = :uPassword limit 1";
            $result = $db->read($sql, $data);

            if (is_array($result)) {
                
                $_SESSION['idUser'] = $result[0]->idUser;
                header("Location: " . "home");
                die;
            }
            $this->error .= "Email ou mot de passe incorrect. <br>";
        }
        $_SESSION['error'] = $this->error;
    }

    /**
     * checkLogin
     * verifie si l'utilisateur est connecté (pour l'admin aussi)
     * @return object
     */
    public function checkLogin($allowed = array())
    {
        $db = Database::getInstance();
        if (count($allowed) > 0) {
            
            $arr['idUser'] = $_SESSION['idUser'];
            $query = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur  WHERE idUser = :idUser limit 1";
            $result = $db->read($query, $arr);
            
            if (is_array($result)) {
                $result = $result[0];

                if ($result->isAdmin && $allowed[0] === 'admin') {
                    return $result;
                } elseif ($allowed[1] === "customer") {
                    return $result;
                } else {
                    header("Location: " . "login");
                    die;
                }
            } else {
                header("Location: " . "login");
                die;
            }
        } else {
            if (isset($_SESSION['idUser'])) {
                $arr['idUser'] = $_SESSION['idUser'];
                $query = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur  WHERE idUser = :idUser limit 1";
                $result = $db->read($query, $arr);
                if (is_array($result)) {
                    return $result[0];
                }
            }
        }
        return false;
    }

    /**
     * logout
     * déconnecte l'utilisateur et affiche la page d'accueil
     * @return void
     */
    public function logout()
    {
        if (isset($_SESSION['idUser'])) {
            unset($_SESSION['idUser']);
        }
        header("Location: " . ROOT . "home");
    }


    /**
     * checkEmail
     * vérifie si le mail existe déjà
     * @param array $data
     * @return array
     */
    private function checkEmail($data)
    {
        $db = Database::getInstance();
        $query = "SELECT  idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur WHERE uMail = :uMail limit 1";
        $arr['uMail'] = $data['uMail'];
        return $db->read($query, $arr);
    }

    /**
     * updateUser
     * modifie l'user dans la BDD
     * @param  int $idMember
     * @return void
     */
    public function updateUser($idMember)
    {
        $db = Database::getInstance();

        $data = array();
        $data['uNom'] = validateData($_POST['name']);
        $data['uPrenom'] = validateData($_POST['firstname']);
        $data['uMail'] = validateData($_POST['email']);
        $data['uVille'] = validateData($_POST['city']);
        $data['uCp'] = validateData($_POST['postalCode']);
        $data['uAdr'] = validateData($_POST['adress']);
        $data['uPassword'] = $_POST['password'];
        $data['idUser'] = $idMember;
        $password2 = $_POST['password2'];

        // vérifie les données 
        if (empty($data['uNom']) || !preg_match("/^[a-zA-Z-' ]*$/", $data['uNom'])) {
            $this->error .= "Veuillez entrez un nom valide. <br>";
        }

        if (empty($data['uPrenom']) || !preg_match("/^[a-zA-Z-' ]*$/", $data['uPrenom'])) {
            $this->error .= "Veuillez entrez un prénom valide. <br>";
        }

        if (empty($data['uMail']) || (!filter_var($data['uMail'], FILTER_VALIDATE_EMAIL))) {
            $this->error .= "Veuillez entrez un email valide. <br>";
        }

        if (empty($data['uCp']) || !preg_match("/^[0-9]{5}$/", $data['uCp'])) {
            $this->error .= "Veuillez entrez un code postal valide. <br>";
        }

        if (empty($data['uVille'])) {
            $this->error .= "Veuillez entrez une ville valide. <br>";
        }

        if (empty($data['uAdr'])) {
            $this->error .= "Veuillez entrez une adresse valide. <br>";
        }

        if ($data['uPassword'] !== $password2) {
            $this->error .= "Les mots de passes ne correspondent pas. <br>";
        }

        if (strlen($data['uPassword']) < 6) {
            $this->error .= "Le mot de passe doit être long de 6 caractères au minimun. <br>";
        }

        if ($this->error == "") {
            $data['uPassword'] = hash('sha1', $data['uPassword']);

            $query = "UPDATE utilisateur SET uNom = :uNom, uPrenom = :uPrenom, uMail = :uMail, uCp = :uCp, uVille = :uVille, uAdr = :uAdr, uPassword = :uPassword WHERE idUser = :idUser";
            $result = $db->write($query, $data);
            if ($result) {
                header("Location: " . ROOT . "profil");
                die;
            }
        }
        $_SESSION['error'] = $this->error;
    }

    
    /**
     * deleteUser
     * supprime un user dans la BDD
     * @param  int $idMember
     * @return void
     */
    public function deleteUser($idMember)
    {
        $db = Database::getInstance();
        $db->write("DELETE FROM utilisateur WHERE idUser = $idMember");
        header("Location: " . ROOT . "login");
    }

    /**
     * getAllUsers
     * selectionne tout les users dans la BDD
     * @return array
     */
    public function getAllUsers()
    {
        $db = Database::getInstance();
        $query = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur ORDER BY isAdmin DESC";
        $data = $db->read($query);
        return $data;
    }

     /**
     * getAllCustomers
     * selectionne tout les utilisateur non-admin de la BDD
     * @return array
     */
    public function getAllCustomers()
    {
        $db = Database::getInstance();
        $query = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur WHERE isAdmin = 0";
        $data = $db->read($query);
        return $data;
    }

    /**
     * getAllAdmins
     * selectionne tout les utilisateur admin de la BDD
     * @return array
     */
    public function getAllAdmins()
    {
        $db = Database::getInstance();
        $query = "SELECT idUser, uNom, uPrenom, uMail, uVille, uCp, uAdr, uPassword, isAdmin FROM utilisateur WHERE isAdmin = 1";
        $data = $db->read($query);
        return $data;
    }

     /**
     * makeTableUsers
     * tableau qui affiche les users dans la partie admin
     * @param  arrays $members
     * @return HTML 
     */
    public function makeTableUsers($members)
    {
        $tableHTML = "";
        if (is_array($members)) {
            foreach ($members as $member) {
                $statut =  $member->isAdmin ? "Admin" : "Customer";
                $tableHTML .= '<tr>
                            <th scope="row">' . $member->idUser . '</th>
                            <td>' . $statut . '</td>
                            <td>' . $member->uNom . '</td>
                            <td>' . $member->uPrenom . '</td>
                            <td>' . $member->uMail . '</td>
                            <td>' . $member->uVille . '</td>
                            <td>' . $member->uCp . '</td>
                            <td>' . $member->uAdr . '</td>
                        </tr>';
            }
        }
        return $tableHTML;
    }
}