<div class="col-sm-8 text-left"> 
    
    <form method="post" action="modificar_clave/change"  class="form-signin form_perfil" >
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Modificacion de clave</h1> 
        
        <label for="nombre" class="sr-only">Marca</label>
        <input type="password" id="nombre" name="old_password" class="form-control" placeholder="Current Password:"  required autofocus 
               value="<?php echo $this->session->userdata('nombre'); ?>">
        <br>
        <label for="apellido" class="sr-only">Marca</label>
        <input type="password" id="apellido" name="newpassword" class="form-control" placeholder="New Password:"  required autofocus 
               value="<?php echo $this->session->userdata('apellido'); ?>">  
        <br>
        <label for="email" class="sr-only"></label>
        <input type="password" id="email" name="re_password" class="form-control" placeholder="Retype New Password:"  required autofocus 
               value="<?php echo $this->session->userdata('email'); ?>"  >
        
        <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

        <?php endif; ?>
            <br>
        <button class="btn btn-lg btn-primary btn-block btn_perfil"   type="submit">Modificar</button>



        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</div>

