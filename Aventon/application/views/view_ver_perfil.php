<div class="col-sm-8 text-center"> 

    
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h10 mb-3 font-weight-normal">Perfil</h1> 

        <p>Nombre</p>
        <?php echo $this->session->flashdata('nom'); ?>
        <br>
        <p>Apellido</p>
        <label for="apellido" class="sr-only">Apellido</label>
        <?php echo $this->session->flashdata('ap'); ?>
        <br>
      

        <?php if ($this->session->flashdata('notifico')): ?>

            <p> <?php echo $this->session->flashdata('notifico') ?></p>

        <?php endif; ?>

        <br>
       



   
</div>
