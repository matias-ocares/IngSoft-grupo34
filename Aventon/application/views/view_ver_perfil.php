<div class="col-sm-8 text-center"> 


    <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h10 mb-3 font-weight-normal">Perfil</h1> 
    <table >
        <tr>    
            <Td> <b>Nombre</b></td>
            <td><?php echo $this->session->flashdata('nom'); ?></td>
        </tr>
        <tr>
            <Td><b>Apellido</b></td>
            <td><?php echo $this->session->flashdata('ap'); ?></td>
        </tr>
        <tr>
            <Td><b>Calificacion como chofer</b></td>
            <td><?php echo $this->session->flashdata('calif_chofer'); ?></td>
        </tr>
        <tr>
            <Td><b>Calificacion como pasajero</b></td>
            <td><?php echo $this->session->flashdata('calif_pasajero'); ?></td>
        </tr>
        <tr>


    </table>


    <?php if ($this->session->flashdata('notifico')): ?>

    <p style="color:green;"><b><?php echo $this->session->flashdata('notifico') ?> </b></p>

    <?php endif; ?>

    <br>





</div>
