<?php 
    include("../../bd.php");
    if($_POST){
        $correo=(isset($_POST['correo']))?$_POST['correo']:"";
        $usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
        $password=(isset($_POST['password']))?$_POST['password']:"";

        $password=md5($password);

        $sentencia=$conexion->prepare("INSERT INTO `tbl_usuarios` (`id`, `nombre`, `password`, `correo`) VALUES (NULL, :usuario, :password, :correo);");
    
        $sentencia->bindParam(":correo", $correo);
        $sentencia->bindParam(":usuario", $usuario);
        $sentencia->bindParam(":password", $password);
    
        $sentencia->execute();
    
        header("Location:index.php");
    }
    include("../../templates/header.php"); 
?>
<br>

<div class="card">
    <div class="card-header">Usuarios</div>
    <div class="card-body">
        <form action="" method="post">

            <div class="mb-3">
                <label for="" class="form-label">Nombre de usuario</label>
                <input
                    type="text"
                    class="form-control"
                    name="usuario"
                    id="usuario"
                    aria-describedby="helpId"
                    placeholder="Usuario.."
                />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    placeholder="Escribe tu password..."
                />
            </div>
            
            <div class="mb-3">
                <label for="" class="form-label">Correo</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id="correo"
                    aria-describedby="emailHelpId"
                    placeholder="Escribe tu correo..."
                />

            </div>

            <!-- boton de crear -->
            <button type="submit" class="btn btn-success">Agregar Usuario</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="index.php"
                role="button"
                >Cancelar</a
            >
            
        </form>
    </div>
</div>


<?php include("../../templates/footer.php");  ?>