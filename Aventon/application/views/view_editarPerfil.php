    <html>
        <head>
            <title>user registration</title>
        </head>
        <body>
            <form  action="editar_perfil/edit"  method="POST" name="myform">
                <input type="hidden" name="id" value="<?php echo $user['id_user'] ?>">
                username :<input type="text" name="name" value="<?php echo $user['name'] ?>"></br>
                age      :<input type="text" name="surname" value="<?php echo $user['surname'] ?>"></br>
                Address  :<input type="text" name="email" value="<?php echo $user['email'] ?>"></br>

                <input type="submit" value="update" name="submit">
            </form>
        </body>

    </html>