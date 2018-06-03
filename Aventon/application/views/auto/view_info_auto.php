
<div class="col-sm-8 text-left"> 
    <h1 class="h11">Datos del auto</h1>
       
            <div class="container">    
                <table class="table table-striped">
                <thead>
                <tr>
                <th style="text-align:center;" height=15 width=30>Auto N°</th>
                <th style="text-align:center;" height=15 width=30>Chofer N°</th>
                <th style="text-align:center;" height=15 width=30>Marca</th>
                <th style="text-align:center;" height=15 width=30>Modelo</th>
                <th style="text-align:center;" height=15 width=30>Patente</th>
                <th style="text-align:center;" height=15 width=30>Color</th>               
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><?php echo $auto['id_auto']; ?></td>
                  <td><?php echo $auto['id_user']; ?></td>
                  <td><?php echo $auto['marca']; ?></td>
                  <td><?php echo $auto['modelo'] ?></td>
                  <td><?php echo $auto['num_patente']; ?></td>
                  <td><?php echo $auto['color']; ?></td>              
                  
                </tr>
                </tbody>
                </table>
            </div>    
        </div> 


