<div class="col-sm-8 text-left"> 
    
    
    <button class="bottm btn btn-lg btn-primary btn-block btn_perfil"   type="submit">Eliminar tarjeta</button>
    
</div>
<div class="container col-sm-4 text-left" >
    <form method="post" id="id_tarjeta" action="<?php echo base_url();?>tarjeta/eliminar/" class="form-signin">
        <input type="hidden" name="id_tarjeta" value="<?php echo $tarjeta->id_tarjeta; ?>">    
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Eliminar tarjeta</button>
        
        
    </form>
</div>

