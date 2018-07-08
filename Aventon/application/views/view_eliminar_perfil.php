<div class="col-sm-8 text-center"> 
          <h1 class="h10 mb-3 font-weight-normal">Eliminar mi perfil</h1>
          
          <hr>
            <div class="container">    
                <table class="table table-striped">
                <thead>
                <tr>
                <th style="text-align:center;" height=45 width=100>Nombre</th>
                <th style="text-align:center;" height=45 width=100>Apellido</th>
                <th style="text-align:center;" height=45 width=100>Calificacion como chofer</th>
                <th style="text-align:center;" height=45 width=100>Calificacion como pasajero</th>
                  
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><?php echo $this->session->flashdata('nom'); ?></td>
                  <td><?php echo $this->session->flashdata('ap'); ?></td>
                  <td><?php echo $this->session->flashdata('calif_chofer'); ?></td>
                  <td><?php echo $this->session->flashdata('calif_pasajero'); ?></td>
                      
                </tr>
                </tbody>
                
                </table>
            </div> 
          <form method="post" id="miformulario" action="<?php echo base_url(); ?>eliminar_perfil/" class="form-signin">
          <button class="btn btn-default btn-sm" name="eliminar" type="submit" value="eliminar">
                <a href="#" class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-trash"></span> Eliminar perfil
                </a>        </button> 
          </form>
        </div> 

 
