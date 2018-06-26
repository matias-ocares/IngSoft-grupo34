<div class="col-sm-8 text-left">

    <h1 class="h11">Listado de solicitudes pendientes</h1>
    <div class="container">  
        <?php if ($this->session->flashdata('notifico')): ?>

            <p style="color:red;"> <?php echo $this->session->flashdata('notifico') ?></p>

        <?php endif; ?>
        <div class="table-responsive">   
            <?php echo $this->table->generate(); ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>

    </div>  

</div> 
