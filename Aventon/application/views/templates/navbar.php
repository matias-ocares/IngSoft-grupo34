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
                    <li><a href="<?php echo base_url() ?>editar_perfil/">Editar perfil</a></li>
                    <li><a href="<?php echo base_url() ?>cargar_auto/">Cargar auto</a></li>
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
            <li><a href="<?php echo base_url() ?>login/cerrar_sesion"><span class="glyphicon glyphicon-log-in"></span> Cerrar sesion -> <?php echo $this->session->userdata('nombre'); ?> </a></li>
        </ul>
    </div>
</nav>  