<div class="col-sm-4 text-center"> 
    <h1>Detalles de viaje a calificar</h1>
    <hr>
    <div class="container">    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="text-align:center;" height=45 width=100>Origen</th>
                    <th style="text-align:center;" height=45 width=100>Destino</th>
                    <th style="text-align:center;" height=45 width=100>Fecha</th>
                    <th style="text-align:center;" height=45 width=100>Hora salida</th>
                    <th style="text-align:center;" height=45 width=100>¿Quién califica?</th>
                    <th style="text-align:center;" height=45 width=100>Califica a pasajero:</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                    <td><?php echo $viaje->origen; ?></td>
                    <td><?php echo $viaje->destino; ?></td>
                    <td><?php echo $newDate = date("d-m-Y", strtotime($viaje->fecha)); ?></td>
                    <td><?php echo substr("$viaje->hora_inicio", 0, -3); ?></td>
                    <td><?php echo $minombre . ", " . $miapellido; ?></td>
                    <td><?php echo $sunombre . ", " . $suapellido; ?></td>


                </tr>
            </tbody>
        </table>



    </div>
    <?php if ($exito): ?>

        <p style="color:green;"><b> <?php echo $exito ?></b> </p>

    <?php endif; ?> 
    <?php if ($error): ?>

        <p style="color:red;"> <b><?php echo $error ?> </b></p>

    <?php endif; ?>


    <div class="container col-sm-4 text-left" >
        <form method="post" id="miformulario" action="<?php echo base_url(); ?>calificacion/calificar_como_chofer/" class="form-signin">
            <input type="hidden" id="id_viaje" name="id_viaje" value="<?php echo $viaje->id_viaje; ?>">
            <input type="hidden" id="fecha" name="fecha" value="<?php echo $viaje->fecha; ?>">
            <input type="hidden" id="hora" name="hora" value="<?php echo $viaje->hora_inicio; ?>">
            <input type="hidden" id="duracion" name="duracion" value="<?php echo $viaje->duracion_horas; ?>">
            <input type="hidden" id="id_chofer" name="id_chofer" value="<?php echo $viaje->id_chofer; ?>"> 
            <input type="hidden" id="nombre" name="nombre" value="<?php echo $minombre; ?>"> 
            <input type="hidden" id="apellido" name="apellido" value="<?php echo $miapellido; ?>"> 
             <input type="hidden" id="id_postulante" name="id_postulante" value="<?php echo $id_postulante; ?>"> 
          

             <div>
<textarea rows="4" cols="50" name="comentario" form="miformulario" maxlength="150" placeholder="Realice un comentario..."></textarea>
             </div>     <button class="btn btn-default btn-sm" name="califica" type="submit" value="positivo">
                <a href="#" class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-thumbs-up"></span> Positivo
                </a>        </button> 
            
             <button  class="btn btn-default btn-sm"  name="califica" type="submit" value="neutro">
                <a href="#" class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-hand-right"></span> Neutro
                </a>        </button>  
            <button class="btn btn-default btn-sm" name="califica"  type="submit" value="negativo">
                <a href="#" class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-thumbs-down"></span> Negativo
                </a>        </button>   

            

        </form>

    </div>
</div>

