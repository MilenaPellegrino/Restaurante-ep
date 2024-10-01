
<?php 
    include("admin/bd.php");

    // Banners 
    $sentencia=$conexion->prepare("SELECT * FROM tbl_banners ORDER BY id DESC limit 1");
    $sentencia->execute();
    $lista_banners=$sentencia->fetchall(PDO::FETCH_ASSOC);

    // Colaboradores
    $sentencia=$conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY id DESC limit 3");
    $sentencia->execute();
    $lista_colaboradores=$sentencia->fetchall(PDO::FETCH_ASSOC);

    // Testimonios
    $sentencia=$conexion->prepare("SELECT * FROM tbl_testimonios ORDER BY id DESC limit 2");
    $sentencia->execute();
    $lista_testimonios=$sentencia->fetchall(PDO::FETCH_ASSOC);

    // Menu
    $sentencia=$conexion->prepare("SELECT * FROM tbl_menu ORDER BY id DESC limit 4");
    $sentencia->execute();
    $lista_menu=$sentencia->fetchall(PDO::FETCH_ASSOC);

    // Contacto / comentarios 
    if($_POST){

        // Sanitizamos los datos 
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
        $mensaje = filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);

        if($nombre && $correo && $mensaje){
            $sql= "INSERT INTO `tbl_comentarios` (`id`, `nombre`, `correo`, `mensaje`) VALUES (NULL, :nombre, :correo, :mensaje);";
            $sentencia=$conexion->prepare($sql);
            $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(':correo', $correo,  PDO::PARAM_STR);
            $sentencia->bindParam(':mensaje', $mensaje,  PDO::PARAM_STR);
    
            $sentencia->execute();
        }
        header("Location:index.php");

    }

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Restaurante</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <!-- Iconos-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        
    </head>

    <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">
    <a class="navbar-brand" href="#"> <i class="fas fa-utensils"></i>RESTAURANTE "EL PELE"</a>

    <!-- El button es para hacerlo responsive el nav-->
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expandedad="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#banner" aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#menu">Menu del dia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#chefs">Chefs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonios">Testimonios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#horarios">Horarios</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <!-- slide de bienvenida -->
    <section id="banner" class="containar-fluid p-o">
        <div class="banner-img" style="position:relative; background:url('images/slider-image1.jpg') center/cover no-repeat; height:400px">
            <div class="banner-text" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); text-align:center; color:#fff; ">
            <?php foreach($lista_banners as $value){?>
            <h1><?php echo $value['titulo'];?></h1>
                <p><?php echo $value['descripcion'];?></p>
                <a href="<?php echo $value['link'];?>" class="btn  btn-primary">Ver Menu</a>
            </div>
            <?php }   ?>
        </div>
    </section>

    <!-- Mensaje de bienvenida -->
    <section class="container mt-4 text-center">
            <div class="jumbotron b bg-dark text-white">
                <br>
                    <h2>Bienvenido/a al restaurante El Pele!</h2>
                    <p>
                        Va a ser un antes y un despues en tu vida.
                    </p>
                </br>
            </div>    
    </section>
    
     <!-- Seccion de chefs -->
     <section id="chefs" class="container mt-4 text-center">
        <h2>Nuestros Colaboradores</h2>
       
        <div class="row">


             <!-- Chefs -->
            <?php   foreach ($lista_colaboradores as $colaborador) { ?>
            <div class="col-md-4">
                <div class="card">

                    <img src="images/colaboradores/<?php echo $colaborador["imagen"];?>" class="card-img-top" alt="chef 1"/>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $colaborador["titulo"]?></h5>
                        <p class="card-text"><?php echo $colaborador["descripcion"]?></p>
                        <div class="social-icons mt-3">
                            <a href="<?php echo $colaborador["linkfacebook"]?>" class="text-dark me-2"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo $colaborador["linkinstagram"]?>" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                            <a href="<?php echo $colaborador["linklinkedin"]?>" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
     </section>

     
    <!-- Seccion de testimonios -->
    <section id="testimonios" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Testimonios</h2>
            <div class="row">

                <!-- Testimonios -->
                <?php foreach ($lista_testimonios as $testimonio) { ?>

                <div class="col-md-6 d-flex">
                    <div class="card mb-4 w-100">
                        <div class="card-body">
                            <p class="card-text"> <?php echo $testimonio['opinion']; ?></p>
                        </div>
                        <div class="card-footer text-muted">
                            <?php echo $testimonio['nombre']; ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

    </section>

    <!-- Seccion de Menu -->
    <section id="menu" class="container mt-4">
        <h2 class="text-center"> Menu (nuestra recomendacion) </h2>
        <br/>
        <div class="row row-cols-1 row-cols-md-4 g-4">

            <!-- Menu 1 -->
            <?php foreach ($lista_menu as $value) { ?>
            
            <div class="col d-flex">
                <div class="card">
                    <img src="images/menu/<?php echo $value["imagen"];?>" class="card-img-top" alt="Imagen del menu">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $value["nombre"];?></h5>
                        <p class="card-text small">
                            <strong>Ingredientes:</strong> <?php echo $value["ingredientes"];?>
                        </p>
                        <p class="card-text"><strong>Precio: </strong><?php echo $value["precio"];?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- Seccion de Contacto -->
    <section id="contacto" class="container mt-4">
        <h2>Contacto</h2>
        <p> Estamos aqui  para ayudarte </p>
        <form action="?" method="post">
            <div class ="mb-3">
                <label for="name">Nombre completo: </label>
                <input type="text" class="form-control" name="nombre"  placeholder="Escribe tu nombre completo..." required>
                <br/>
            </div>

            <div class ="mb-3">
                <label for="Email">Correo Electronico: </label>
                <input type="correo" class="form-control" name="correo"  placeholder="Escribe tu correo electronico..." required>
                <br/>
            </div>

            <div class ="mb-3">
                <label for="message">Mensaje: </label>
                <input type="message" class="form-control" name="mensaje" rows="6" id="message" cols="50" placeholder="Escribe el mensaje... "></textarea> 
                <br/>
            </div>
            <input type="submit" class="btn btn-primary" name="" id="">
        </form>
    </section>
    <br/>
    <br/>

    <!-- Seccion de Horarios -->
    <div id="horarios" class="text-center bg-light p-4">
        <h3 clss="mb-4"> Horarios de atencion </h3>
        <div>
            <p class=""> <strong>Lunes a Viernes:</strong>  9:00am - 22:00pm </p>
            <p class=""> <strong>Sabado, domingos y feriados:</strong>  10:00am -  18:00pm </p>
        </div>
    </div>

    
     <!-- Seccion del footer -->
    <footer class="bg-dark text-light text-center py-3">
        <p>&copy; 2024 STANDARD, todos los derechos reservados. </p>
    </footer>


        <!-- Bootstrap JavaScript Libraries -->

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

    </body>
</html>
