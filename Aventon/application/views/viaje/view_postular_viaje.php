<div class="col-sm-8 text-left"> 
          <h1>Detalles de viaje</h1>
          <hr>
            <div class="container">    
                <table class="table table-striped">
                <thead>
                <tr>
                <th style="text-align:center;" height=45 width=100>Viaje N°</th>
                <th style="text-align:center;" height=45 width=100>Origen</th>
                <th style="text-align:center;" height=45 width=100>Destino</th>
                <th style="text-align:center;" height=45 width=100>Fecha</th>
                <th style="text-align:center;" height=45 width=100>Hora salida</th>
                <th style="text-align:center;" height=45 width=100>Duracion</th>
                <th style="text-align:center;" height=45 width=100>Costo</th>
                <th style="text-align:center;" height=45 width=100>Plazas totales</th>
                <th style="text-align:center;" height=45 width=100>Plazas libres</th>
                <th style="text-align:center;" height=45 width=100>Chofer N°</th>                
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><?php echo $viaje->id_viaje; ?></td>  
                  <td><?php echo $viaje->origen; ?></td>
                  <td><?php echo $viaje->destino; ?></td>
                  <td><?php echo $viaje->fecha; ?></td>
                  <td><?php echo $viaje->hora_inicio; ?></td>
                  <td><?php echo $viaje->duracion_horas; ?></td>
                  <td><?php echo $viaje->costo; ?></td>
                  <td><?php echo $viaje->plazas_total; ?></td>
                  <td><?php echo $viaje->plazas_libre; ?></td>
                  <td><?php echo $viaje->id_chofer; ?></td>
                  
                  
                </tr>
                </tbody>
                </table>
                
                
        
            </div>
          <?php if ($error): ?>

            <p style="color:red;"> <?php echo $error ?> </p>

        <?php endif; ?>
          
          <form method="post" action="<?php echo base_url();?>viaje/postularse/" class="form-signin">
              <input type="hidden" id="id_viaje" name="id_viaje" value="<?php echo $viaje->id_viaje; ?>">
              <input type="hidden" id="fecha" name="fecha" value="<?php echo $viaje->fecha; ?>">
              <input type="hidden" id="hora" name="hora" value="<?php echo $viaje->hora_inicio; ?>">
              <input type="hidden" id="duracion" name="duracion" value="<?php echo $viaje->duracion_horas; ?>">
              <input type="hidden" id="id_chofer" name="id_chofer" value="<?php echo $viaje->id_chofer; ?>">
                 
          <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Postularse</button>
          </form>
        </div> 

