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
            
            <?php if ($exito): ?>            
            <p style="color:green;"><b> <?php echo $exito ?></b> </p>            
            <?php endif; ?> 
            <?php if ($error): ?>            
            <p style="color:red;"> <b><?php echo $error ?> </b></p>                
            <?php endif; ?>
        </table>
    </div>
    <div class="container col-sm-4 text-left" >
        <form method="post" id="id_auto" action="<?php echo base_url();?>auto/eliminar/" class="form-signin">
            <input type="hidden" name="id_auto" value="<?php echo $auto['id_auto']; ?>">    
                
            <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Eliminar auto</button>
                
                
        </form>    
    </div> 