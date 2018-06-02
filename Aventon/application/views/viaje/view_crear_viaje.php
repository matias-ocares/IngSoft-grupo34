<div class="col-sm-8 text-left"> 
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
echo $hoy;
?>" max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
                </td>
            </tr>


            <tr>
                <td><p> Hora:  </p></td>
                <td>
                    <label for="hora" class="sr-only">Hora</label>
                    <input type="time" id= "hora" name="hora" class="form-control" placeholder="Hora de inicio" 
                           value="<?php
                           if ($this->session->flashdata('hora')) {
                               echo $this->session->flashdata('patente');
                           } else {
                               echo "00:00";
                           }
                           ?>" >
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
                   
                    
           
                    
            <select class="form-control">
    <?php foreach($groups as $each){ ?>
        <option value="<?php echo $each->num_patente ?>"><?php echo $each-> num_patente ?></option>';
    <?php } ?> 
</select>        
                    
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
</div>


<script>
    document.getElementById('#fecha').value = new Date().toDateInputValue();

    function validacion() {
        origen = document.getElementById("origen").value;
        destino = document.getElementById("destino").value;
        fecha = document.getElementById("fecha").value;
        hora = document.getElementById("hora").value;
        duracion = document.getElementById("duracion").value;
        costo = document.getElementById("costo").value;
        auto = document.getElementById("auto").value;
        plazas = document.getElementById("plazas").value;
        
        var expresion_regular_texto = /^[A-Za-z\s]+$/;
      
        if (origen === ""|| origen.length === 0 || /^\s+$/.test(origen)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (destino === ""|| destino.length === 0 || /^\s+$/.test(destino)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (fecha === ""|| fecha.length === 0 || /^\s+$/.test(fecha)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 

        if (hora === ""|| hora.length === 0 || /^\s+$/.test(hora)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (duracion === ""|| duracion.length === 0 || /^\s+$/.test(duracion)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (costo === ""|| costo.length === 0 || /^\s+$/.test(costo)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (auto === ""|| auto.length === 0 || /^\s+$/.test(auto)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 

        if (plazas === ""|| plazas.length === 0 || /^\s+$/.test(plazas)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        } 
        if (!expresion_regular_texto.test(origen)) {
            alert("[!] El campo origen contiene caracteres no permitidos");
            return false;
	}
        if (!expresion_regular_texto.test(destino)) {
            alert("[!] El campo destino contiene caracteres no permitidos");
            return false;
	}
        
      
       
    }

</script>            