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
                  <td><?php echo $newDate = date("d-m-Y", strtotime($viaje->fecha)); ?></td> 
                  <td><?php echo substr("$viaje->hora_inicio", 0, -3); ?></td>
                  <td><?php echo $viaje->duracion_horas; ?></td>
                  <td><?php echo $viaje->costo; ?></td>
                  <td><?php echo $viaje->plazas_total; ?></td>
                  <td><?php echo $viaje->plazas_libre; ?></td>
                  <td><?php echo $viaje->id_chofer; ?></td>
                  
                  
                </tr>
                </tbody>
                <?php if ($exito): ?>

            <p style="color:green;"><b> <?php echo $exito ?></b> </p>

        <?php endif; ?> 
          <?php if ($error): ?>

            <p style="color:red;"> <b><?php echo $error ?> </b></p>

        <?php endif; ?>
            
                </table>
            </div>  
          
        </div> 

 

