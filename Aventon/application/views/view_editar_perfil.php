<div class="col-sm-8 text-left"> 
    
    <form method="post" action="editar_perfil/update_user" onsubmit="return validar();" class="form-signin form_perfil" >
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Modificacion de datos personales</h1> 
        
        <label for="nombre" class="sr-only">Marca</label>
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre"  required autofocus 
               value="<?php echo $this->session->userdata('nombre'); ?>">
        <br>
        <label for="apellido" class="sr-only">Marca</label>
        <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido"  required autofocus 
               value="<?php echo $this->session->userdata('apellido'); ?>">  
        <br>
        <label for="email" class="sr-only"></label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email"  required autofocus 
               value="<?php echo $this->session->userdata('email'); ?>"  >
        
        <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

        <?php endif; ?>
            <br>
        <button class="btn btn-lg btn-primary btn-block btn_perfil"   type="submit">Modificar</button>



        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</div>
<script>
    function validar() {
	nombre = document.getElementById("nombre").value; 
	apellido = document.getElementById("apellido").value;
	email = document.getElementById("email").value;



	var expresion_regular_mail =  /^(.+\@.+\..+)$/;
	var expresion_regular_onlyLetter = /^[A-Za-z\s]+$/;



	if (nombre === "" || apellido === "" || email === "") {
            alert("[!] Todos los campos con son obligatorios");
            return false;
	}

	if (!expresion_regular_mail.test(email)) {
            alert("[!] El correo ingresado no es valido");
            return false;
	}
	if (!expresion_regular_onlyLetter.test(nombre)) {
            alert("[!] El nombre contiene caracteres no permitidos");
            return false;
	}
	if (!expresion_regular_onlyLetter.test(apellido)) {
            alert("[!] El apellido contiene caracteres no permitidos");
            return false;
	}
}
    
    
    
</script>
