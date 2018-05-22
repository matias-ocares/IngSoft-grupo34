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

    <form method="post" action="cargar_auto/cargar_auto" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Cargar auto</h1>



        <label for="inputMarca" class="sr-only">Marca</label>            
        <input type="text" id="inputMarca" name="marca" class="form-control" placeholder="Marca"  required autofocus value="<?php echo $this->session->flashdata('marca'); ?>">        
        <label for="inputModelo" class="sr-only">Modelo</label>           
        <input type="text" id="inputModelo" name="modelo" class="form-control" placeholder="Modelo"  required autofocus value="<?php echo $this->session->flashdata('modelo'); ?>">        
        <label for="inputPatente" class="sr-only">Patente</label>                       
        <input type="text" id="inputPatente" name="patente" class="form-control" placeholder="Patente"  required autofocus value="<?php echo $this->session->flashdata('patente'); ?>">
        <label for="inputPlazas" class="sr-only">Plazas</label>                       
        <input type="number" id="inputPlazas" name="plazas" class="form-control" placeholder="Plazas disponibles"  required autofocus value="">
        <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Cargar auto</button>
        <button class="btn btn-lg btn-primary btn-block" type="reset">Limpiar</button>


        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
