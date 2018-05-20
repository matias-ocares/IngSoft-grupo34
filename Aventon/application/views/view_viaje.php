<?php echo validation_errors(); ?>
    
    <form method = "post" action="register/validar"  enctype="multipart/form-data">
	
	<legend>Datos Personales</legend>
	Email (*) <br>
	<input type="text" name = "email" value=""><br/>
        Nombre (*)<br/>
	<input type="text" name = "name" value=""><br/> 
	Apellido(s) (*)<br/>
	<input type="text" name = "surname" value=""><br/>
	Contraseña: (*) <br />
	<input type="password" name = "password" value=""><br />
	Contraseña: (vuelva a ingresarla) <br />
        <input type="password" name = "passwordRepeat" id="passwordRepeats" value=""><br />
        <input type="submit" value="submit">
    </form>

