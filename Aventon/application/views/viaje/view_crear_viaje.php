<div class="col-sm-8 text-left"> 
    <form id="formulario2" name="formAuto" method="post" action="<?php echo base_url(); ?>crear_viaje/crear_viaje" class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Crear viaje</h1>


        <p>Desde</p>
        <label for="origen" class="sr-only">Origen</label> 
        <input type="text" id="origen" name="origen" class="form-control" placeholder="Origen"  required autofocus value="<?php echo $this->session->flashdata('origen'); ?>">        
        <br>        

        <p> Hasta</p>
        <label for="destino" class="sr-only">Destino</label>           
        <input type="text" id="destino" name="destino" class="form-control" placeholder="Destino"  required autofocus value="<?php echo $this->session->flashdata('destino'); ?>">        
        <br>

        <p> Fecha</p>
        <label for="fecha" class="sr-only">Fecha</label>  
        <input type="date" id= "fecha" name="fecha" class="form-control" placeholder="Fecha: dd/mm/aaaa" required autofocus 
               min="<?php $hoy = date("Y-m-d");
echo $hoy;
?>" max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
        <br>

        <p> Hora</p>     
        <label for="hora" class="sr-only">Hora</label>
        <input type="time" id= "hora" name="hora" class="form-control" placeholder="Hora de inicio" 
               value="<?php
               if ($this->session->flashdata('hora')) {
                   echo $this->session->flashdata('hora');
               } else {
                   echo "00:00";
               }
               ?>" >
        <br>

        <p> Duración</p>
        <label for="duracion" class="sr-only">Duracion</label>                       
        <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Duracion"  required autofocus 
               min="1" value="<?php echo $this->session->flashdata('duracion'); ?>">
        <br>

        <p>Costo</p>
        <label for="costo" class="sr-only">Costo</label> 
        <div class="input-group"> 
            <span class="input-group-addon">$</span>
            <input type="number" id="costo" name="costo" class="form-control currency" placeholder="Costo"  required autofocus  min="0.00" max="10000.00" step="10.00" value="<?php echo $this->session->flashdata('costo'); ?>">
        </div> 
        <br>

        <p> Mi auto</p>                 
        <select class="form-control" name="auto" id="auto">
            <option value="">Elija un auto</option>';
            <?php foreach ($groups as $each) { ?>
                <option value="<?php echo $each->id_auto ?>"> <?php echo $each->marca ?> <?php echo $each->modelo ?> - <?php echo $each->num_patente ?> </option>;
            <?php } ?> 
        </select>
        <br>

        <p>Plazas disponibles</p>
        <label for="plazas" class="sr-only">Plazas</label>                       
        <input type="number" id="plazas" name="plazas" class="form-control" placeholder="Plazas"  required autofocus 
               min="1" max="10" value="<?php echo $this->session->flashdata('plazas'); ?>">

        <p><u> Repetir Viaje</u>: </p>
        <input type="radio" name="frequencia" value="unico"> Solo una vez<br>
        <input type="radio" name="frequencia" value="diario"> Diario<br>
        <input type="radio" name="frequencia" value="semanal"> Semanal

         <p> Repetir Hasta </p>
        <label for="fecha" class="sr-only">Fecha</label>  
        <input type="date" id= "fecha_hasta" name="fecha_hasta" class="form-control" placeholder="Fecha: dd/mm/aaaa" required autofocus 
               min="<?php $hoy = date("Y-m-d");echo $hoy;?>" max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
        <br>

        </br>
        </br>


        <?php if ($notifico): ?>

            <p> <?php echo $notifico ?> </p>

<?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block btn_perfil" type="submit" onClick="return validacionViaje();">Crear viaje</button>
        <button class="btn btn-lg btn-primary btn-block btn_perfil" type="reset">Limpiar</button>

    </form>
</div>




<script>

    function validacionViaje() {
        origen = document.getElementById("origen").value;
        destino = document.getElementById("destino").value;
        fecha = document.getElementById("fecha").value;
        hora = document.getElementById("hora").value;
        duracion = document.getElementById("duracion").value;
        costo = document.getElementById("costo").value;
        auto = document.getElementById("auto").value;
        plazas = document.getElementById("plazas").value;

        var expresion_regular_texto = /^[A-Za-z\s]+$/;

        if (origen === "" || origen.length === 0 || /^\s+$/.test(origen)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (destino === "" || destino.length === 0 || /^\s+$/.test(destino)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }
        if (fecha === "" || fecha.length === 0 || /^\s+$/.test(fecha)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (hora === "" || hora.length === 0 || /^\s+$/.test(hora)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }
        if (duracion === "" || duracion.length === 0 || /^\s+$/.test(duracion)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (costo === "" || costo.length === 0 || /^\s+$/.test(costo)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }
        if (auto === "" || auto.length === 0 || /^\s+$/.test(auto)) {
            alert('[!] Todos los campos con son obligatorios.');
            return false;
        }

        if (plazas === "" || plazas.length === 0 || /^\s+$/.test(plazas)) {
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
    document.getElementById('#fecha').value = new Date().toDateInputValue();

</script>            