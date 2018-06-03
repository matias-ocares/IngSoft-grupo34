<!DOCTYPE html>
<html lang="en">
<head>
  <title>Compartir coche para llegar directamente a donde quieras ir | Aventon</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
        font-family:Arial;
        margin-bottom: 0;
        border-radius: 0;
         position: fixed;
        /*overflow: hidden;*/
        background-color: #333;
        top:0px;
        width:100%;
        height: 48px;
        left: 0;
        /* background-color: #007BFF;
         color: black;*/
        }
    .logo{
        margin-left: -10px;
        margin-top:-10px;   
        }
        .abc{
            margin-left:-20px;
        }

    
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
          <li><a class="logo" href="<?php echo base_url() ?>login"><img src="https://image.ibb.co/de39Y8/Logo.jpg" alt="Aventon logo" width="40px" height="40px"></img></a></li>
          <li><a class="abc">Aventon</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url() ?>register"><span class="glyphicon glyphicon-log-in"></span> Registrarse </a></li>
        <li><a href="<?php echo base_url() ?>login"><span class="glyphicon glyphicon-log-in"></span> Iniciar sesion </a></li>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>