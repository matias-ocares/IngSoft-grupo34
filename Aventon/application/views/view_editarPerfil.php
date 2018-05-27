    <html>
        <head>
            <title>user registration</title>
        </head>
        <body>
            <form  action="edit"  method="POST" name="myform">
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                username :<input type="text" name="name" value="<?php echo $result['name'] ?>"></br>
                age      :<input type="text" name="age" value="<?php echo $result['age'] ?>"></br>
                Address  :<input type="text" name="address" value="<?php echo $result['address'] ?>"></br>

                <input type="submit" value="update" name="submit">
            </form>
        </body>

    </html>