


<div class="col-sm-8 text-left">
    
    <h1 class="h11">Listado de viajes</h1>
    <div class="container">  
        <?php if ($this->session->flashdata('notifico')): ?>

    <p style="color:green;"><b>  <?php echo $this->session->flashdata('notifico') ?></b></p>

<?php endif; ?>
    <?php if ($exito): ?>

            <p style="color:green;"><b> <?php echo $exito ?></b> </p>

        <?php endif; ?> 
          <?php if ($error): ?>

            <p style="color:red;"> <b><?php echo $error ?> </b></p>

        <?php endif; ?>
        <div class="table-responsive">   
            <?php echo $this->table->generate(); ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>

    </div>  
    
</div> 
    






