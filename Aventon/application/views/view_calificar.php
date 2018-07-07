<div class="col-sm-4 text-left"> 
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
                <th style="text-align:center;" height=45 width=100>Califica a</th>
                
                </tr>
                </thead>
                <tbody>
                <tr>
                  
                  <td><?php echo $viaje->origen; ?></td>
                  <td><?php echo $viaje->destino; ?></td>
                  <td><?php echo $newDate = date("d-m-Y", strtotime($viaje->fecha)); ?></td>
                  <td><?php echo substr("$viaje->hora_inicio", 0, -3); ?></td>
                  <td><?php echo $minombre.", ".$miapellido;?></td>
                  <td><?php echo $sunombre.", ".$suapellido;?></td>
                  
                  
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
          <form method="post" action="<?php echo base_url();?>viaje/postularse/" class="form-signin">
              <input type="hidden" id="id_viaje" name="id_viaje" value="<?php echo $viaje->id_viaje; ?>">
              <input type="hidden" id="fecha" name="fecha" value="<?php echo $viaje->fecha; ?>">
              <input type="hidden" id="hora" name="hora" value="<?php echo $viaje->hora_inicio; ?>">
              <input type="hidden" id="duracion" name="duracion" value="<?php echo $viaje->duracion_horas; ?>">
              <input type="hidden" id="id_chofer" name="id_chofer" value="<?php echo $viaje->id_chofer; ?>"> 
              <input type="hidden" id="nombre" name="nombre" value="<?php echo $minombre; ?>"> 
              <input type="hidden" id="apellido" name="apellido" value="<?php echo $miapellido; ?>"> 
              
              
              <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Postularse</button>
            

          </form>
      
</div>
   </div>