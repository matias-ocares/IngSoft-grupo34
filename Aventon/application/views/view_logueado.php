<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Aventon</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>


            /* Add a gray background color and some padding to the footer */
            footer {
                background-color: #f5f5f5;
                padding: 25px;
            }
            .well{
                text-decoration: none;
                padding: 10px;
                font-weight: 600;
                font-size: 20px;
                color: #ffffff;
                background-color: #9D9D9D;
               /* border-radius: 6px;*/
                border: 2px ;
            }
            .well:hover{
                color: #1883ba;
                background-color: #ffffff;
            }
            .carousel-inner img {
                width: 100%; /* Set width to 100% */
                margin: auto;
                min-height:200px;
            }

            /* Hide the carousel text when the screen is less than 600 pixels wide */
            @media (max-width: 600px) {
                .carousel-caption {
                    display: none; 
                }
            }
        </style>
    </head>
    <body>




        <div class="container text-center">    
            <h3>What We Do</h3><br>
            <?php if ($this->session->flashdata('notifico')): ?>

            <p> <?php echo $this->session->flashdata('notifico') ?></p>

        <?php endif; ?>
            <a href="<?php echo base_url() ?>editar_perfil"> Editar perfil </a>

            <div class="row">
                <div class="col-sm-4">
                    <img src="https://image.ibb.co/de39Y8/Logo.jpg" class="img-responsive" style="width:auto" alt="Image">
                    <p>Current Project</p>
                </div>
                <div class="col-sm-4"> 
                    <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
                    <p>Project 2</p>    
                </div>
                <div class="col-sm-4">

                    <a href="<?php echo base_url() ?>cargar_auto" class="boton"> 
                        <div class="well" >

                            Cargar auto
                        </div>
                    </a>
                    <a href="<?php echo base_url() ?>editar_auto" class="boton"> 
                        <div class="well" >

                            Editar auto
                        </div>
                    </a>
                </div>
            </div>
        </div><br>

        <footer class="container-fluid text-center">
            <p>Footer Text</p>
        </footer>

    </body>
</html>
