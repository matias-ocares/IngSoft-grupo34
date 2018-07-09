


<div class="col-sm-8 text-left">

    <form id="formBuscarViaje" name="formBuscarViaje" method="post" action="<?php echo base_url(); ?>viaje/verificar_search" class="form-signin">
        <div style="display:inline">
            <label class="search_viaje_label"> Desde <input type="text" id="search_origen" name="search_origen" class="form-control" placeholder="Origen"  required autofocus value="<?php echo $this->session->userdata('origen'); ?>"> </label>      

            <label class="search_viaje_label"> Hasta <input type="text" id="search_destino" name="search_destino" class="form-control" placeholder="Destino"  required autofocus value="<?php echo $this->session->userdata('destino'); ?>"> </label>   

            <label class="search_viaje_label"> Fecha <input type="date" id= "search_fecha" name="search_fecha" value="<?php echo $this->session->userdata('fecha'); ?>" class="form-control" placeholder="Fecha: dd/mm/aaaa"  autofocus 
                                                            min="<?php
                                                            $hoy = date("Y-m-d");
                                                            echo $hoy;
                                                            ?>" 
                                                            max="<?php echo date("Y-m-d", strtotime("+30 days")); ?>">
            </label>

            <button class="btn btn-lg btn-primary btn_search_viaje" type="submit" onClick="return validacionBusqueda();"> Buscar </button>
            <a id="mostrar_todos" href="../viaje/mostrar_todos"> Mostrar todos </a>
        </div>
    </form>  
    
    
    <?php if ($this->session->flashdata('notifico')): ?>

        <p style="color:red;"> <b> <?php echo $this->session->flashdata('notifico') ?> </b> </p>
    <?php endif; ?>
    <?php if ($exito): ?>

        <p style="color:green;"><b> <?php echo $exito ?></b> </p>

    <?php endif; ?> 
    <?php if ($error): ?>

        <p style="color:red;"> <b><?php echo $error ?> </b></p>

    <?php endif; ?>


    <h1 class="h11">Listado de viajes</h1>    
    
      <?php
            $cant_resultados = $this->session->userdata('total');
            if ($this->session->userdata('busqueda'))
            { 
                $si_hubo = "Hay ".$cant_resultados." coincidencia con tu búsqueda"; 
                $no_hubo = "No hubo ninguna coincidencia con tu búsqueda";       
                echo ($cant_resultados > 0) ? $si_hubo : $no_hubo;
            }
            else{
                echo "Total de Viajes: ".$cant_resultados;
            } 
                
        ?>


    <div class="container">  

        <div class="table-responsive">   
            <?php echo $this->table->generate(); ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>  


</div> 

<script>
    function validacionBusqueda() {
        origen = document.getElementById("search_origen").value;
        destino = document.getElementById("search_destino").value;
        fecha = document.getElementById("search_fecha").value;

        //var expresion_regular_texto = /^[A-Za-z\s]+$/;
        var expresion_regular_texto = new RegExp(/^[a-zA-Z\s0-9]*$/);

        if (origen === "" || origen.length === 0 || /^\s+$/.test(origen)) {
            alert('[!] Orígen y Destino, son obligatorios.');
            return false;
        }

        if (destino === "" || destino.length === 0 || /^\s+$/.test(destino)) {
            alert('[!] Orígen y Destino, son obligatorios.');
            return false;
        }

        if (!expresion_regular_texto.test(origen)) {
            alert("[!] El campo Orígen contiene caracteres no permitidos");
            return false;
        }
        if (!expresion_regular_texto.test(destino)) {
            alert("[!] El campo Destino contiene caracteres no permitidos");
            return false;
        }

        if ((origen.trim()).toUpperCase() == (destino.trim()).toUpperCase()) {
            //remuevo los espacios delante y detrás
            document.getElementById("search_origen").value = origen.trim();
            document.getElementById("search_destino").value = destino.trim();
            alert("[!] Origen y Destino deben ser diferentes");
            return false;
        }
    }

</script> 







