<link href="../assets/css/signin.css" rel="stylesheet"> 
</head>
<body class="text-center">
    <form id="formulario3" name="formAuto" method="post" action="<?php echo base_url();?>auto/guardar_post/<?php echo $id_auto;?>" class="form-signin">
      <div class="col-sm-8 text-left">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h13 mb-3 font-weight-normal">Configuracion del auto</h1>

       
            <p>Marca</p>
            <label for="marca" class="sr-only">Marca</label>         
            <input type="text" id="marca" name="marca" class="form-control" placeholder="Marca"  required autofocus value="<?php echo $this->session->flashdata('marca'); ?>">        
            <br>
            
            <p> Modelo  </p>
            <label for="modelo" class="sr-only">Modelo</label>           
            <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Modelo"  required autofocus value="<?php echo $this->session->flashdata('modelo'); ?>">        
            <br>
            
            <p> Patente  </p>
            <label for="patente" class="sr-only">Patente</label>                       
            <input type="text" id="patente" name="patente" class="form-control" placeholder="Patente"  required autofocus 
                   value="<?php if($this->session->flashdata('patente')){echo $this->session->flashdata('num_patente');} else{ echo $this-> session->flashdata('num_patente') ; }?>">
            <br>
            
            <p>Color</p>
            <label for="color" class="sr-only">Color</label>                       
            <input type="text" id="color" name="color" class="form-control" placeholder="Color"  required autofocus value="<?php echo $this->session->flashdata('color'); ?>">

        </br>
        </br>
   
       <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block btn_perfil" type="submit" onClick="return validacion();">Guardar</button>

    </form>
</body>
   </div>
<script>
    function validacion() {
        marca = document.getElementById("marca").value;
        modelo = document.getElementById("modelo").value;
        patente = document.getElementById("patente").value;
        color = document.getElementById("color").value;
        
        var expresion_regular_texto = /^[A-Za-z\s]+$/;
        var expresion_regular_patenteLetter = /[A-Za-z0-9]/;
        var expresion_regular_patenteNumber = /[0-9]/;
        
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
        
        if ( (patente.length < 6) || (expresion_regular_patenteLetter.test(patente)===false) || (expresion_regular_patenteNumber.test(patente)===false)) {
            alert("[!] La patente debe tener al menos 6 caracteres y ser alfanumerica. Vuelva a ingresarla");
            return false;
	}
        if (!expresion_regular_texto.test(color)) {
            alert("[!] El campo color contiene caracteres no permitidos");
            return false;
	}
    }
</script>