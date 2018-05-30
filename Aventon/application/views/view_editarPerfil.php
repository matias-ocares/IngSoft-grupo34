    <html>
        <head>
            <title>user registration</title>
        </head>
        <body>
            <form  action="editar_perfil/edit"  method="POST">
                <input type="hidden" name="id" value="<?php set_value('id', (isset($form['id_user'])) ? $form['id_user'] : '') ?>">
                username :<input type="text" name="name" value="<?php set_value('nombre', (isset($form['nombre'])) ? $form['nombre'] : '') ?>"></br>
                age      :<input type="text" name="surname" value="<?php set_value('apellido', (isset($form['apellido'])) ? $form['apellido'] : '') ?>"></br>
                Address  :<input type="text" name="email" value="<?php set_value('email', (isset($form['email'])) ? $form['email'] : '') ?>"></br>

                <input type="submit" value="Actualizar" name="submit">

            </form>
        </body>

    </html>