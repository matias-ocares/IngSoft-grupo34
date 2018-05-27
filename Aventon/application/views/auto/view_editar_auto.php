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


    <form id="formAuto" name="formAuto" method="post" action="editar_auto/editar_auto" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Editar datos de auto</h1>

        <table>
            <tr>
                <td>
                    <p> Marca  </p> </td>

                <td> <label for="marca" class="sr-only">Marca</label>         
                    <input type="text" id="marca" name="marca" class="form-control" placeholder="Marca"  required autofocus value="<?php echo $this->session->flashdata('marca'); ?>">        
                </td>
            </tr>
            <tr>
                <td> <p> Modelo  </p></td>
                <td>
                    <label for="modelo" class="sr-only">Modelo</label>           
                    <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Modelo"  required autofocus value="<?php echo $this->session->flashdata('modelo'); ?>">        
                </td>
            </tr>
            <tr>
                <td><p> Patente  </p></td>
                <td> <label for="patente" class="sr-only">Patente</label>                       
                    <input type="text" id="patente" name="patente" class="form-control" placeholder="Patente"  required autofocus 
                           value="<?php if($this->session->flashdata('patente')){echo $this->session->flashdata('patente');} else{ echo $this-> session->flashdata('num_patente') ; }?>">
                </td>
            </tr>
            <tr>
                <td>  <p> Color  </p></td>
                <td>  <label for="color" class="sr-only">Color</label>                       
                    <input type="text" id="color" name="color" class="form-control" placeholder="Color"  required autofocus value="<?php echo $this->session->flashdata('color'); ?>">
                </td>
            </tr>
        </table>
        </br>
        </br>


        <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" onClick="return validacion();">Cargar auto</button>
        <button class="btn btn-lg btn-primary btn-block" type="reset">Limpiar</button>


        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</body>
<script>
    function validacion() {
        marca = document.getElementById("marca");
        modelo = document.getElementById("modelo");
        patente = document.getElementById("patente");
        color = document.getElementById("color");
        var expresion_regular_texto = /[A-Za-z\s]+$/;
        var expresion_regular_Mayus = /[A-Z]/;
        var expresion_regular_Min = /[a-z]/;
        var expresion_regular_patente = /[0-9|A-Za-z\s]/;
        if (marca.value === "" || marca.length === 0 || /^\s+$/.test(marca.value)) {
            alert('[ERROR] El campo Marca es obligatorio.');
            return false;
        } else

        if (modelo.value === "" || modelo.length === 0 || /^\s+$/.test(modelo.value)) {
            alert('[ERROR] El campo Modelo es obligatorio.');
            return false;
        } else
        if (patente.value === "" || patente.length === 0 || /^\s+$/.test(patente.value)) {
            alert('[ERROR] El campo Patente es obligatorio.');
            return false;
        } else

        if (color.value === "" || color.length === 0 || /^\s+$/.test(color.value)) {
            alert('[ERROR] El campo Color es obligatorio.');
            return false;
        } else
            // Si el script ha llegado a este punto, todas las condiciones
            // se han cumplido, por lo que se devuelve el valor true
            return true;
    }
</script>