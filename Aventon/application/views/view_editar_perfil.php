<div class="col-sm-8 text-left"> 

    <form id="formulario1" method="post" action="../editar_perfil/update_user" onsubmit="return validar();" class=" div form-signin form_perfil" >
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h10 mb-3 font-weight-normal">Modificacion de datos personales</h1> 

        <p>Nombre</p>
        <label for="nombre" class="sr-only">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre"  required autofocus 
               value="<?php echo $this->session->flashdata('nombre'); ?>">
        <br>
        <p>Apellido</p>
        <label for="apellido" class="sr-only">Apellido</label>
        <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido"  required autofocus 
               value="<?php echo $this->session->flashdata('apellido'); ?>"> 
        <br>
        <p>Email</p>
        <label for="email" class="sr-only">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email"  required autofocus 
               value="<?php echo $this->session->flashdata('email'); ?>">

        <?php if ($this->session->flashdata('notifico')): ?>

            <p> <?php echo $this->session->flashdata('notifico') ?></p>

        <?php endif; ?>

        <br>
        <button class="btn btn-lg btn-primary btn-block btn_perfil"   type="submit">Modificar</button>



    </form>
</div>
<script>
    function validar() {
        nombre = document.getElementById("nombre").value;
        apellido = document.getElementById("apellido").value;
        email = document.getElementById("email").value;



        var expresion_regular_mail = /^(.+\@.+\..+)$/;
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
