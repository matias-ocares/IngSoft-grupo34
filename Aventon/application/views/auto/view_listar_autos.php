
<?php if ($this->session->flashdata('notifico')): ?>

    <p> <?php echo $this->session->flashdata('notifico') ?></p>

<?php endif; ?>

<div class="col-sm-8 text-left"> 
    <h1>Listado de autos</h1>
    <div class="container">    
        <div class="table-responsive">   
            <?php echo $this->table->generate(); ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>

    </div>    
</div> 

