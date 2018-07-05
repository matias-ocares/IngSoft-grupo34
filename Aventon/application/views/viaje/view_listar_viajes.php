


<div class="col-sm-8 text-left">

    <form id="formulario2" name="formAuto" method="post" action="<?php echo base_url(); ?>viaje/verificar_search" class="form-signin">
        <p>Desde</p>
        <input type="text" id="search_origen" name="search_origen" class="form-control" placeholder="Origen"  required autofocus value="<?php echo $this->session->userdata('origen'); ?>">        

        <p> Hasta</p>         
        <input type="text" id="search_destino" name="search_destino" class="form-control" placeholder="Destino"  required autofocus value="<?php echo $this->session->userdata('destino'); ?>">        

        <p> Fecha</p>
        <input type="date" id= "search_fecha" name="search_fecha" value="<?php echo $this->session->userdata('fecha'); ?>" class="form-control" placeholder="Fecha: dd/mm/aaaa"  autofocus 
               min="<?php $hoy = date("Y-m-d");
echo $hoy; ?>" 
               max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
        <button class="btn btn-lg btn-primary btn-block btn_perfil" type="submit"> Buscar </button>

    </form>  
    <a href="../viaje/mostrar_todos"> Mostrar todos </a>

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







