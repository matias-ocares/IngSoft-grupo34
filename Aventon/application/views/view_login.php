<!--<div class="container">
    <h1>  What is Lorem Ipsum? </h1>
    <p clas="lead">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
        when an unknown printer took a galley of type and scrambled it to make a type 
        specimen book. It has survived not only five centuries, but also the leap into
        electronic typesetting, remaining essentially unchanged. It was popularised in
        the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
        and more recently with desktop publishing software like Aldus PageMaker
        including versions of Lorem Ipsum.
    </p>
</div>
-->  
<!--Custom styles for this template --> 
<link href="../assets/css/signin.css" rel="stylesheet">

</head>
<body class="text-center">

    <form method="post" action="login/login" onsubmit="return validateForm()" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Ingresar a Aventon</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Correo electrónico"  required autofocus 
              value="<?php echo $this->session->flashdata('email'); ?>"  >
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>


    <!-- php error-->

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Recordarme
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Iniciar sesión</button>
        <button class="btn btn-lg btn-primary btn-block" type="reset">Limpiar</button>
        <button class="btn btn-lg btn-primary btn-block" onclick="location.href='http://localhost:1234/IngSoft-grupo34/Aventon/index.php/register'" type="button">Registrate</button>
    

        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>



