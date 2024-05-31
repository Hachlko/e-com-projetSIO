<?php $this->view("inc/header", $data); ?>
<div class="row justify-content-center">
    <div class="col-6 text-center">
        <h1>PoolTime !</h1>
        <h2>Les produits</h2>
    </div>
</div>
<div class="container">
    <div class="row my-5 justify-content-center">
        <h3 class="text-center">Nouveaux produits</h3>
        <?php
        echo $htmlProducts;
        ?>
    </div>
</div>
<?php $this->view("inc/footer", $data); ?>