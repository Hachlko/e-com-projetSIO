<?php $this->view("inc/header", $data); ?>
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-8 text-center">
            <h1 class="">Détails Commandes </h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Numéro de commande</th>
                        <th scope="col">Nom du produit</th>
                        <th scope="col">Quantité commander</th>
                    </tr>
                </thead>
                <tbody id="tableCategories">
                    <?php
                    echo $details;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    echo $noCommand;
    ?>
</div>
<?php $this->view("inc/footer", $data); ?>