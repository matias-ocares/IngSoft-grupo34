<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>

</head>
<body>
    
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Aventon</a>
            </div>
            <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Perfil
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url() ?>editar_perfil">Editar perfil</a></li>
                    <li><a href="<?php echo base_url() ?>cargar_auto">Cargar auto</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mis viajes
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="">Crear viaje</a></li>
                    <li><a href="">Cancelar viaje</a></li>
                </ul>
            </li>            
            </ul> 
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url() ?>login/cerrar_sesion"><span class="glyphicon glyphicon-log-in"></span>Cerrar sesion -> <?php echo $nombre ?></a></li>
            </ul>
        </div>
    </nav>     
    <div class="container-fluid text-center">    
      <div class="row content">
        <div class="col-sm-2 sidenav">
          <p><a href="#">Link</a></p>
          <p><a href="#">Link</a></p>
          <p><a href="#">Link</a></p>
        </div>  
        <?php if ($this->session->flashdata('notifico')): ?>

            <p> <?php echo $this->session->flashdata('notifico') ?> </p>

        <?php endif; ?>
      
        <div class="col-sm-8 text-left"> 
          <h1>Listado de viajes</h1>
          <hr>
            <div class="container">    
                <table class="table table-striped">
                <thead>
                <tr>
                <th>Columna A</th>
                <th>Columna B</th>
                <th>Columna C</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Viaje 1</td>
                  <td>Viaje 1</td>
                  <td>Viaje 1</td>
                </tr>
                <tr>
                  <td>Viaje 2</td>
                  <td>Viaje 2</td>
                  <td>Viaje 2</td>
                </tr>
                <tr>
                  <td>Viaje 3</td>
                  <td>Viaje 3</td>
                  <td>Viaje 3</td>
                </tr>
                </tbody>
                </table>
            </div>    
        </div> 
      
        <div class="col-sm-2 sidenav">
          <div class="well">
            <p>ADS</p>
          </div>
          <div class="well">
            <p>ADS</p>
          </div>
        </div>
      </div>
    </div>
<footer class="container-fluid text-center">
  <p>© 2018</p>
</footer>
           
        </p>
</body>
</html>
