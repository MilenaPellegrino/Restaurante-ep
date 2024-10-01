<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE ID= :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $nombre=$registro['nombre'];
    $ingredientes=$registro['ingredientes'];
    $pecio=$registro['precio'];
    $imagen = $registro['imagen']; 

    
}

if($_POST){
    $txtID = (isset($_POST["txtID"]))?$_POST['txtID']:"";
    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    $ingredientes=(isset($_POST['ingredientes']))?$_POST['ingredientes']:"";
    $precio=(isset($_POST['precio']))?$_POST['precio']:"";
    $imagen=(isset($_POST['imagen']))?$_POST['imagen']:"";
    
    $sentencia=$conexion->prepare("UPDATE `tbl_menu` SET nombre=:nombre, ingredientes=:ingredientes, precio=:precio WHERE ID=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ingredientes", $ingredientes);
    $sentencia->bindParam(":precio", $precio);

    $sentencia->execute();

    // Proceso de actualizacion de la imagen
    // Recepcionamos la imagen 
    $imagen = (isset($_FILES['imagen']["name"])) ? $_FILES['imagen']["name"] : "";
    $tmp_imagen = $_FILES['imagen']["tmp_name"];

    if($imagen != ""){
        $Fecha_imagen = new DateTime();
        $nombre_imagen = $Fecha_imagen->getTimestamp() . "_" . $imagen;

        move_uploaded_file($tmp_imagen,  '../../../images/menu/' . $nombre_imagen);

        // Borrado fisicamente
        // Proceso de borrado que busque la imagen y la pueda borrar
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($registro_imagen["imagen"])){  // vemos que exista la imagen
            // Borramos los datos si esta el archivo 
            if(file_exists("../../../images/menu/".$registro_imagen["imagen"])){
                unlink("../../../images/menu/".$registro_imagen["imagen"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_menu` SET imagen=:imagen WHERE ID=:id");
        $sentencia->bindParam(":imagen", $nombre_imagen);  // Usar el nuevo nombre de imagen
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    
    }

  
    header("Location:index.php");
}

include("../../templates/header.php"); 
?>  

<br>
<div class="card">
    <div class="card-header">
        Menu
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <!-- recepcionamos el id -->
            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $txtID; ?>"
                    name="txtID"
                    id="txtID"
                    aria-describedby="helpId"
                />

            </div>

            <!--  nombre -->
            <div class="mb-3">
                <label for="" class="form-label">Nombre del menu</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $nombre; ?>"
                    name="nombre"
                    id="nombre"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre del menu..."
                />

            </div>

            <!-- ingredientes -->
            <div class="mb-3">
                <label for="" class="form-label">Ingredientes:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $ingredientes; ?>"
                    name="ingredientes"
                    id="ingredientes"
                    aria-describedby="helpId"
                    placeholder="Escriba los ingredientes del menu..."
                />
            </div>    

            <!-- precio -->
            <div class="mb-3">
                <label for="" class="form-label">Precio:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $precio; ?>"
                    name="precio"
                    id="precio"
                    aria-describedby="helpId"
                    placeholder="Escriba el precio del menu..."
                />
            </div>   

            <!-- imagen -->
            <div class="mb-3">
                <div class="mb-3">
                    
                    <label for="" class="form-label">Seleccionar imagen:</label> <br>
                    <img src="../../../images/menu/<?php echo $nombre_imagen; ?>" width="50"/>
                    <input
                        type="file"
                        class="form-control"
                        name="imagen"
                        id="imagen"
                        placeholder="Elige un archivo"
                        aria-describedby="fileHelpId"
                    />
                </div>
            </div>    

            <br>
            <!-- boton de crear -->
            <button type="submit" class="btn btn-success">Editar Menu</button>
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
    <div class="card-footer text-muted"></div>
</div>
<?php include("../../templates/footer.php"); ?>