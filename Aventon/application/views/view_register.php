<html>
<head>
	<meta charset="UTF-8">
</head>
<body>	

<?php echo validation_errors(); ?>

<?php echo form_open('form'); ?>
    
    <form method = "post"   enctype="multipart/form-data">
	
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

</body>
</html>