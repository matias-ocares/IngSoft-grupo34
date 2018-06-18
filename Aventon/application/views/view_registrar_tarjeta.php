<div class="col-sm-8 text-left"> 
    <form id="formulario2" name="formAuto" method="post" action="<?php echo base_url();?>tarjeta_credito/crear_tarjeta" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Registrar tarjeta</h1>


        <p>Tipo de tarjeta</p>
        <label for="tipo" class="sr-only">Tipo de tarjeta</label> 
        <input type="text" id="tipo" name="tipo" class="form-control" placeholder="Tipo"  required autofocus value="<?php echo $this->session->flashdata('tipo'); ?>">        
        <br>        
            
        <p>Titular</p>
        <label for="titular" class="sr-only">Titular</label>           
        <input type="text" id="titular" name="titular" class="form-control" placeholder="Titular de la tarjeta"  required autofocus value="<?php echo $this->session->flashdata('titular'); ?>">        
        <br>
        
        <p>Numero de tarjeta</p>
        <label for="numero" class="sr-only">Numero de tarjeta</label> 
        <input type="text" id="numero" name="numero" class="form-control" placeholder="Numero de tarjeta"  required autofocus value="<?php echo $this->session->flashdata('numero'); ?>">        
        <br> 
        
        <p>Fecha de Vencimiento</p>
        <label for="fecha" class="sr-only">Fecha</label>  
        <input type="date" id= "fecha" name="fecha" class="form-control" placeholder="Fecha: dd/mm/aaaa" required autofocus 
               min="<?php $hoy = date("Y-m-d");
               echo $hoy;?>">
        <br>
        
        <p>Codigo de seguridad</p>
        <label for="codigo" class="sr-only">Codigo de seguridad</label> 
        <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Codigo de seguridad"  required autofocus value="<?php echo $this->session->flashdata('codigo'); ?>">        
        <br>


        <?php if ($error): ?>

            <p> <?php echo $error ?> </p>

        <?php endif; ?>
            
        <button class="btn btn-lg btn-primary btn-block btn_perfil" type="submit">Registrar tarjeta</button>

    </form>
</div>
 