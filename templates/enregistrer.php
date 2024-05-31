<?php
require_once 'header.php';
echo headers();
echo navbar();
?>
        </div>
        <div class="bd-form row">
            <h1 class="text-center titre-site divB">Connexion</h1>
            <form action="POST" get="">
                <div class="container-md border-form c-width">

                    <div class="row justify-content-md-center divH">
                        
                        <label for="email" class="offset-md-3 col-1 col-form-label">Email</label>
                        <div class="col-4">
                            <input type="email" class="form-control" name="inputemail" id="inputemail" aria-describedby="emailHelpId" placeholder="Ex: patrickdefontane@gmail.com">
                            <small id="emailHelpId" class="form-text text-muted"></small>
                        </div>
                        <div class="col-3"></div>
                    </div>
                    
                    <div class="row justify-content-md-center divH">
                        <label for="password" class="offset-md-3 col-1 col-form-label">Mot de passe</label>
                        <div class="col-4">
                            <input type="password" class="form-control" name="inputpassword" id="inputpassword" placeholder="Min. 8 caractères">
                        </div>
                        <div class="col-3"></div>
                    </div>

                    <div class="row justify-content-md-center divB">
                        <div class="divH text-center">
                            <button type="submit" class="btn btn-warning">Se Connecter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="bd-form row">
            <h1 class="text-center titre-site">Inscription</h1>
            <form action="./traitement-form.php" method="POST">
                <div class="container-md border-form i-width divH">
                    <!--nom form-->
                    <div class="row justify-content-md-center">
                        <label for="nom" class="col-1 col-form-label">Nom</label>
                        <div class="col-3">
                            <input type="text" class="form-control" name="inputnom" id="inputnom" placeholder="Nom">
                        </div>
                    
                    <!--prenom form-->
                    
                        <label for="prenom" class="col-1 col-form-label">Prénom</label>
                        <div class="col-3">
                            <input type="text" class="form-control" name="inputprenom" id="inputprenom" placeholder="Prénom">
                        </div>
                    </div>
                    
                    <!--email form-->
                    <div class="row justify-content-md-center divH">
                        <label for="email" class="col-1 col-form-label">Email</label>
                        <div class="col-3">
                            <input type="email" class="form-control" name="inputemail" id="inputemail" aria-describedby="emailHelpId" placeholder="Ex :patrickdefontane@gmail.com">
                            <small id="emailHelpId" class="form-text text-muted"></small>
                        </div>
                        <div class="col-4"></div>
                    </div>

                    <!--Ville-->
                    <div class="row justify-content-md-center divH">
                        <label for="ville" class="col-1 col-form-label">Ville</label>
                        <div class="col-3">
                            <input type="text" class="form-control" name="inputVille" id="inputVille" placeholder="Montpellier...">
                        </div>
                        <!--Code Postal-->
                        <label for="cp" class="col-1 col-form-label">Code Postal</label>
                        <div class="col-3">
                            <input type="tel" class="form-control" name="inputCP" id="inputCP" placeholder="34000..." maxlength="5">
                        </div>
                    </div>

                    <!--Adresse-->
                    <div class="row justify-content-md-center divH">
                        <label for="adress" class="col-1 col-form-label">Adresse</label>
                        <div class="col-7">
                            <input type="text" class="form-control" name="inputadress" id="inputadress" placeholder="2 rue des Oisillons...">
                        </div>
                    </div>

                    

                    <!--password form-->
                    <div class="row justify-content-md-center divH">
                        <label for="password" class="col-1 col-form-label">Mot de passe</label>
                        <div class="col-3">
                            <input type="password" class="form-control" name="inputpassword" id="inputpassword" placeholder="Min. 8 caractères">
                        </div>                        

                        <label for="confpassword" class="col-1  col-form-label">Confirmation mot de passe</label>
                        <div class="col-3">
                            <input type="password" class="form-control" name="confpassword" id="confpassword" placeholder="Réécrire mot de passe">
                        </div>
                    </div>
                    
                    <!--bouton form-->
                    <div class="row justify-content-md-center divB">
                        <div class="col-md-3 offset-md-3 divH">
                            <button type="submit" class="btn btn-warning">Soumettre</button>
                        </div>
                        <div class="col-md-3 offset-md-1 divH">
                            <button type="submit" class="btn btn-secondary">Annuler</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        echo footer();
        ?>
    </body>
</html>