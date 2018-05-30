<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>

        marca = document.getElementById("marca").value;
        modelo = document.getElementById("modelo").value;
        patente = document.getElementById("patente").value;
        color = document.getElementById("color").value;
        
        var expresion_regular_texto = /^[A-Za-z\s]+$/;
        var expresion_regular_patente = /[A-Za-z0-9]/;
        if (marca === ""|| marca.length === 0 || /^\s+$/.test(marca)) {
            alert('[!] Todos los campos con son obligatorios.');
        }
        if (modelo === ""|| modelo.length === 0 || /^\s+$/.test(modelo)) {
            alert('[!] Todos los campos con son obligatorios.');
        } 
        if (patente === ""|| patente.length === 0 || /^\s+$/.test(patente)) {
            alert('[!] Todos los campos con son obligatorios.');
        } 
        if (color === ""|| color.length === 0 || /^\s+$/.test(color)) {
            alert('[!] Todos los campos con son obligatorios.');
        } 
        if (!expresion_regular_texto.test(marca)) {
            alert("[!] El campo marca contiene caracteres no permitidos");
            return false;
	}
        if (!expresion_regular_texto.test(modelo)) {
            alert("[!] El campo modelo contiene caracteres no permitidos");
            return false;
	}
        
        if ( (patente.length < 6) || (expresion_regular_patente.test(patente)===false)) {
            alert("[!] La patente debe tener al menos 6 caracteres y ser alfanumerica. Vuelva a ingresarla");
            return false;
	}
        if (!expresion_regular_texto.test(color)) {
            alert("[!] El campo color contiene caracteres no permitidos");
            return false;
	}