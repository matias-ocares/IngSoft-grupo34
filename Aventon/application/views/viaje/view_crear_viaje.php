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


    <form id="formAuto" name="formAuto" method="post" action="viaje/crear_viaje" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Crear viaje</h1>


        <table>
            <tr>
                <td>
                    <p> Desde:  </p> </td>
                <td>  <label for="origen" class="sr-only">Origen</label> 
                    <input type="text" id="origen" name="origen" class="form-control" placeholder="Origen"  required autofocus value="<?php echo $this->session->flashdata('origen'); ?>">        
                </td>
            </tr>
                    

            <tr>
                <td> <p> Hasta:  </p></td>
                <td>
                    <label for="destino" class="sr-only">Destino</label>           
                    <input type="text" id="destino" name="destino" class="form-control" placeholder="Destino"  required autofocus value="<?php echo $this->session->flashdata('destino'); ?>">        
                </td>
            </tr>
                    

            <tr>
                <td><p> Fecha:  </p></td>
                <td>
                    <label for="fecha" class="sr-only">Fecha</label>  
                    <input type="date" id= "fecha" name="fecha" class="form-control" placeholder="Fecha: dd/mm/aaaa" required autofocus 
                           min="<?php $hoy = date("Y-m-d");
echo $hoy; ?>" max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
                </td>
            </tr>
                    

            <tr>
                <td><p> Hora:  </p></td>
                <td>
                    <label for="hora" class="sr-only">Hora</label>
                    <input type="time" id= "hora" name="hora" class="form-control" placeholder="Hora de inicio" 
                           value="<?php if ($this->session->flashdata('hora')) {
    echo $this->session->flashdata('patente');
} else {
    echo "00:00";
} ?>" >
                </td>
            </tr>
                    

            <tr>
                <td><p> Duración:  </p></td>
                <td>
                    <label for="duracion" class="sr-only">Duracion</label>                       
                    <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Duracion"  required autofocus 
                           min="1" value="<?php echo $this->session->flashdata('duracion'); ?>">
                </td>
            </tr>
                    

            <tr>
                <td><p> Costo:  </p></td>
                <td>
                    <label for="costo" class="sr-only">Costo</label> 
                    <div class="input-group"> 
                        <span class="input-group-addon">$</span>
                        <input type="number" id="costo" name="costo" class="form-control currency" placeholder="Costo"  required autofocus  min="0.00" max="10000.00" step="10.00" value="<?php echo $this->session->flashdata('costo'); ?>">
                    </div>       
                </td>
            </tr>
                    

            <tr>
                <td><p> Mi auto:  </p></td>
                <td>
                    <input list="auto" class="form-control" placeholder="Mi auto">
                    <datalist id="auto">
                        <option value="Internet Explorer">
                        <option value="Firefox">
                        <option value="Google Chrome">
                        <option value="Opera">
                        <option value="Safari">
                    </datalist> 
                </td>
            </tr>
                    

            <tr>
                <td><p> Plazas disponibles:  </p></td>
                <td>
                    <label for="plazas" class="sr-only">Plazas</label>                       
                    <input type="number" id="plazas" name="plazas" class="form-control" placeholder="Plazas"  required autofocus 
                           min="1" max="10" value="<?php echo $this->session->flashdata('plazas'); ?>">
                </td>
            </tr>
        </table>
        </br>
        </br>


<?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

<?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" onClick="return validacion();">Crear viaje</button>
        <button class="btn btn-lg btn-primary btn-block" type="reset">Limpiar</button>


        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</body>


<script>
    document.getElementById('#fecha').value = new Date().toDateInputValue();



</script>            