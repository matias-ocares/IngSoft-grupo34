<div class="col-sm-8 text-left"> 

    <?php
    $form_attr = array('class' => 'email', 'id' => 'formulario2', 'name' => "formAuto", 'method' => 'post', 'class' => 'form-signin');
    echo form_open('crear_viaje/crear_viaje', $form_attr);

    // LABELS

    //Labels campos origen, destino, fecha
    $label_origen = array('class' => 'sr-only', 'for' => 'origen');
    $label_destino = array('class' => 'sr-only', 'for' => 'destino');
    $label_fecha = array('class' => 'sr-only', 'for' => 'fecha');
    //Label tipo de frequencia
    $label_unica = array('class' => 'sr-only', 'for' => 'frequencia_unica');
    $label_diaria = array('class' => 'sr-only', 'for' => 'frequencia_diaria');
    $label_semanal = array('class' => 'sr-only', 'for' => 'frequencia_semanal');

    //PROPIEDADES DE LOS CAMPOS
    $input_origen = array(
        'type' => 'text',
        'id' => 'origen',
        'name' => 'origen',
        'class' => 'form-control',
        'placeholder' => 'Origen',
        'autofocus' => 'true',
        'required' => 'true',
        'value' => $this->session->flashdata('origen'),
        'maxlength' => '100',
        'size' => '50',
        'style' => 'width:50%; margin-bottom:15px'
    );

    $input_destino = array(
        'type' => 'text',
        'id' => 'destino',
        'name' => 'destino',
        'class' => 'form-control',
        'placeholder' => 'Destino',
        'autofocus' => 'true',
        'required' => 'true',
        'value' => $this->session->flashdata('destino'),
        'maxlength' => '100',
        'size' => '50',
        'style' => 'width:50%; margin-bottom:15px'
    );
    
    $input_fecha = array(
        'type' => 'date',
        'id' => 'fecha',
        'name' => 'fecha',
        'class' => 'form-control',
        'placeholder' => 'Fecha: dd/mm/aaaa',
        'autofocus' => 'true',
        'required' => 'true',
        'min' => date("Y-m-d"),
        'max' => date("Y-m-d", strtotime("+30 days")),
        'value' => $this->session->flashdata('fecha'),
        'maxlength' => '100',
        'size' => '50',
        'style' => 'width:50%; margin-bottom:15px'
    );

    // DIAS DE LA SEMANA - CHECKBOXS
    $dia_domingo = array('name' => 'domingo', 'id' => 'domingo', 'value' => 'Domingo', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_lunes = array('name' => 'lunes', 'id' => 'lunes', 'value' => 'Lunes', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_martes = array('name' => 'martes', 'id' => 'martes', 'value' => 'Martes', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_miercoles = array('name' => 'miercoles', 'id' => 'miercoles', 'value' => 'Miercoles', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_jueves = array('name' => 'jueves', 'id' => 'jueves', 'value' => 'Jueves', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_viernes = array('name' => 'viernes', 'id' => 'viernes', 'value' => 'Viernes', 'checked' => FALSE, 'style' => 'margin:10px');
    $dia_sabado = array('name' => 'sabado', 'id' => 'sabado', 'value' => 'Sabado', 'checked' => FALSE, 'style' => 'margin:10px');
    
    // TIPO DE FRECUENCIA - RADIO BUTTONS
    $frequencia_unica = array('name' => 'frequencia_unica','id' => 'frequencia_unica','value' => 'unica','checked' => FALSE,'style' => 'margin:10px');
    $frequencia_diaria = array('name' => 'frequencia_diaria','id' => 'frequencia_diaria','value' => 'diaria','checked' => FALSE,'style' => 'margin:10px');
    $frequencia_semanal = array('name' => 'frequencia_semanal','id' => 'frequencia_semanal','value' => 'semanal','checked' => FALSE,'style' => 'margin:10px');
    
    
    echo form_label('Ciudad Origen', 'label_origen', 'label_origen');
    echo form_input($input_origen);
    echo form_label('Ciudad Origen', 'label_destino', 'label_destino');
    echo form_input($input_destino);

    // Tipo de frequencia
    echo form_label('Única vez', 'label_unica', 'label_unica');
    echo form_radio($frequencia_unica);
    echo form_label('Diario', 'label_diaria', 'label_diaria');
    echo form_radio($frequencia_diaria);
    echo form_label('Semanal', 'label_mensual', 'label_mensual');
    echo form_radio($frequencia_semanal);
    ?>
    
    <br>
    
    <?php
    
    // Checkboxs días de la semana
    echo form_label('Dom', 'dia_domingo');
    echo form_checkbox($dia_domingo);
    echo form_label('Lun', 'dia_lunes');
    echo form_checkbox($dia_lunes);
    echo form_label('Mar', 'dia_martes');
    echo form_checkbox($dia_martes);
    echo form_label('Mier', 'dia_miercoles');
    echo form_checkbox($dia_miercoles);
    echo form_label('Jue', 'dia_jueves');
    echo form_checkbox($dia_jueves);
    echo form_label('Vier', 'dia_viernes');
    echo form_checkbox($dia_viernes);
    echo form_label('Sab', 'dia_sabado');
    echo form_checkbox($dia_sabado);
    
    echo form_label('Fecha Viaje', 'label_fecha', 'label_fecha');
    echo form_input($input_fecha);

    echo form_close();
    ?>




    <p> Hora</p>     
    <label for="hora" class="sr-only">Hora</label>
    <input type="time" id= "hora" name="hora" class="form-control" placeholder="Hora de inicio" 
           value="<?php
           if ($this->session->flashdata('hora')) {
               echo $this->session->flashdata('patente');
           } else {
               echo "00:00";
           }
           ?>" >
    <br>

    <p> Duración</p>
    <label for="duracion" class="sr-only">Duracion</label>                       
    <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Duracion"  required autofocus 
           min="1" value="<?php echo $this->session->flashdata('duracion'); ?>">
    <br>

    <p>Costo</p>
    <label for="costo" class="sr-only">Costo</label> 
    <div class="input-group"> 
        <span class="input-group-addon">$</span>
        <input type="number" id="costo" name="costo" class="form-control currency" placeholder="Costo"  required autofocus  min="0.00" max="10000.00" step="10.00" value="<?php echo $this->session->flashdata('costo'); ?>">
    </div> 
    <br>

    <p> Mi auto</p>                 
    <select class="form-control" name="auto" id="auto">
        <option value="">Elija un auto</option>';
        <?php foreach ($groups as $each) { ?>
            <option value="<?php echo $each->id_auto ?>"> <?php echo $each->marca ?> <?php echo $each->modelo ?> - <?php echo $each->num_patente ?> </option>;
        <?php } ?> 
    </select>
    <br>

    <p>Plazas disponibles</p>
    <label for="plazas" class="sr-only">Plazas</label>                       
    <input type="number" id="plazas" name="plazas" class="form-control" placeholder="Plazas"  required autofocus 
           min="1" max="10" value="<?php echo $this->session->flashdata('plazas'); ?>">



    </br>
    </br>




</div>