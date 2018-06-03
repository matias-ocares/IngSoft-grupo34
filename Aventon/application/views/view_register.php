<link href="../assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">

    <form method="post" action="register/register" onsubmit="return validar();" class="form-signin" >
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Regístrate en Aventon</h1> 
        
        <input type="text" id="name" name="nombre" class="form-control" placeholder="Nombre"  required autofocus 
               value="<?php echo $this->session->flashdata('name'); ?>">
        
        <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido"  required autofocus 
               value="<?php echo $this->session->flashdata('apellido'); ?>"  
        
        <label for="inputEmail" class="sr-only"></label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico"  required autofocus 
               value="<?php echo $this->session->flashdata('email'); ?>"  >
        
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>

        <label for="inputPassword" class="sr-only">Reingrese Contraseña</label>
        <input type="password" id="passwordRepeat" name="passwordRepeat" class="form-control" placeholder="Repetir Contraseña" onkeyup="checkPass(); return false;" required>
        
        <?php if ($error): ?>

            <p> <?php echo $error ?> </p>

        <?php endif; ?>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrarse</button>
        
    </form>
</body>
<script>
    function validar() {
	nombre = document.getElementById("nombre").value; 
	apellido = document.getElementById("apellido").value;
	email = document.getElementById("email").value;
	password = document.getElementById("password").value;
	passwordRepeat = document.getElementById("passwordRepeat").value;

	var expresion_regular_mail =  /^(.+\@.+\..+)$/;
	var expresion_regular_onlyLetter = /^[A-Za-z\s]+$/;
	var expresion_regular_password = /[A-Za-z0-9]/; 

	if (nombre === "" || apellido === "" || email === "" || password === "" || passwordRepeat === "") {
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

	if(password != passwordRepeat) {
            alert("[!] Las contraseñas no coinciden");
            return false;
	}
	if ( (password.length < 8) || (expresion_regular_password.test(password)===false)) {
            alert("[!] La contraseña debe tener al menos 8 caracteres y ser alfanumerica. Pruebe con otra");
            return false;
	}



}
    
    
    
</script>