<link href="../assets/css/signin.css" rel="stylesheet"> 
</head>
<body class="text-center">


    <form id="formAuto" name="formAuto" method="post" action="<?php echo base_url();?>auto/guardar_post/<?php echo $id_auto;?>" class="form-signin">
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
                           value="<?php if($this->session->flashdata('patente')){echo $this->session->flashdata('num_patente');} else{ echo $this-> session->flashdata('num_patente') ; }?>">
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

        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</body>
<script>
    function validacion() {
        marca = document.getElementById("marca").value;
        modelo = document.getElementById("modelo").value;
        patente = document.getElementById("patente").value;
        color = document.getElementById("color").value;
        
        var expresion_regular_texto = /^[A-Za-z\s]+$/;
        var expresion_regular_patente = /[A-Za-z0-9]/;
        if (marca === ""|| marca.length === 0 || /^\s+$/.test(marca)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (modelo === ""|| modelo.length === 0 || /^\s+$/.test(modelo)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (patente === ""|| patente.length === 0 || /^\s+$/.test(patente)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 

        if (color === ""|| color.length === 0 || /^\s+$/.test(color)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (!expresion_regular_texto.test(marca)) {
            alert("[!] El campo marca contiene caracteres no permitidos");
            return false;
	}
        if (!expresion_regular_texto.test(modelo)) {
            alert("[!] El campo modelo contiene caracteres no permitidos");
            return false;
	}
        
        if ( (patente.length < 6) || (expresion_regular_patente.test(patente)===false)) {
            alert("[!] La patente debe tener al menos 6 caracteres y ser alfanumerica. Vuelva a ingresarla");
            return false;
	}
        if (!expresion_regular_texto.test(color)) {
            alert("[!] El campo color contiene caracteres no permitidos");
            return false;
	}
    }
</script>