<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../assets/css/signin.css" rel="stylesheet">


        <meta charset="utf-8" />
        <title> Usuarios </title>
    </head>
    <body class="text-center">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">

        <h1 class="h3 mb-3 font-weight-normal">Bienvenido/a <?php echo $nombre ?> </h1>
        <?php if ($this->session->flashdata('notifico')): ?>

            <p> <?php echo $this->session->flashdata('notifico') ?> </p>

        <?php endif; ?>
        <p>
            <a href="<?php echo base_url() ?>login/cerrar_sesion" > Cerrar sesión</a>
            <a href="<?php echo base_url() ?>cargar_auto"> Cargar auto </a>
           
        </p>
    </body>
</html>

