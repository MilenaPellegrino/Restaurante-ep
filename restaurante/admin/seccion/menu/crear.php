<?php 
include("../../bd.php");

if($_POST){

    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    $ingredientes=(isset($_POST['ingredientes']))?$_POST['ingredientes']:"";
    $precio=(isset($_POST['precio']))?$_POST['precio']:"";
    
    
    $sentencia=$conexion->prepare("INSERT INTO `tbl_menu` (`id`, `nombre`, `ingredientes`, `precio`, `imagen`) VALUES (NULL, :nombre, :ingredientes, :precio, :imagen);");

    // Insercion de la imagen en la tabla

        // Aquí obtenemos el nombre de la imagen
        $imagen = (isset($_FILES['imagen']["name"])) ? $_FILES['imagen']["name"] : "";
    
        // Verificamos si el archivo se ha subido sin errores
        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Renombramos el archivo con la fecha de subida para evitar conflictos de nombre
            $Fecha_imagen = new DateTime();
            $nombre_imagen = $Fecha_imagen->getTimestamp() . "_" . $imagen;
            
            // Ruta temporal donde está almacenada la imagen
            $tmp_imagen = $_FILES["imagen"]["tmp_name"];
            // Verificamos si el archivo temporal existe
            if (file_exists($tmp_imagen)) {
                // Movemos el archivo a la carpeta deseada
                move_uploaded_file($tmp_imagen, "../../../images/menu/" . $nombre_imagen);
                $sentencia->bindParam(':imagen', $nombre_imagen);
            } else {
                echo "El archivo temporal no existe.";
            }
        } else {
            // errores 
            echo "Error al subir el archivo. Código de error: " . $_FILES['imagen']['error'];
            // Puedes agregar un switch para manejar los diferentes códigos de error
            switch ($_FILES['imagen']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "El archivo es demasiado grande.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "El archivo solo se subió parcialmente.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No se subió ningún archivo.";
                    break;
                default:
                    echo "Error desconocido.";
                    break;
            }
        }
    
    
    // fin insercion de la imagen en la table
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':ingredientes', $ingredientes);
    $sentencia->bindParam(':precio', $precio);
    

    $sentencia->execute(); 

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

            <!-- nombre -->
            <div class="mb-3">
                <label for="" class="form-label">Nombre:</label>
                <input
                    type="text"
                    class="form-control"
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
                    name="ingredientes"
                    id="ingredientes"
                    aria-describedby="helpId"
                    placeholder="Escriba informacion sobre los ingredientes del menu..."
                />
            </div>    

            <!-- precio -->
            <div class="mb-3">
                <label for="" class="form-label">Precio:</label>
                <input
                    type="text"
                    class="form-control"
                    name="precio"
                    id="precio"
                    aria-describedby="helpId"
                    placeholder="Escriba el precio del menu..."
                />
            </div>    

            <!-- imagen -->
            <div class="mb-3">
                <div class="mb-3">
                    <label for="" class="form-label">Seleccionar imagen:</label>
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
            <button type="submit" class="btn btn-success">Crear Menu</button>
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