<?php 
include("../../bd.php");

if($_POST){

    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $linkinstagram=(isset($_POST['linkinstagram']))?$_POST['linkinstagram']:"";
    $linkfacebook=(isset($_POST['linkfacebook']))?$_POST['linkfacebook']:"";
    $linklinkedin=(isset($_POST['linklinkedin']))?$_POST['linklinkedin']:"";

    
    
    $sentencia=$conexion->prepare("INSERT INTO `tbl_colaboradores` (`id`, `titulo`, `descripcion`, `linkfacebook`, `linkinstagram`, `linklinkedin`, `imagen`) VALUES (NULL, :titulo, :descripcion, :linkfacebook, :linkinstagram, :linklinkedin, :imagen);");

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
                move_uploaded_file($tmp_imagen, "../../../images/colaboradores/" . $nombre_imagen);
                $sentencia->bindParam(':imagen', $nombre_imagen);
            } else {
                echo "El archivo temporal no existe.";
            }
        } else {
            // Si hubo un error al subir el archivo, puedes manejarlo aquí
            echo "Error al subir el archivo. Código de error: " . $_FILES['imagen']['error'];
            $nombre_imagen = ""; // En caso de error, el campo de la imagen quedará vacío
            $sentencia->bindParam(':imagen', $nombre_imagen);
        }
    
    
    // fin insercion de la imagen en la table
    $sentencia->bindParam(':titulo', $titulo);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':linkfacebook', $linkfacebook);
    $sentencia->bindParam(':linkinstagram', $linkinstagram);
    $sentencia->bindParam(':linklinkedin', $linklinkedin);
    

    $sentencia->execute(); 

    header("Location:index.php"); 
}

include("../../templates/header.php"); 
?> 
<br>
<div class="card">
    <div class="card-header">
        Colaboradores
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <!-- titulo -->
            <div class="mb-3">
                <label for="" class="form-label">Nombre del colaborador:</label>
                <input
                    type="text"
                    class="form-control"
                    name="titulo"
                    id="titulo"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre del colaborador..."
                />

            </div>

            <!-- descripcion -->
            <div class="mb-3">
                <label for="" class="form-label">Descripcion:</label>
                <input
                    type="text"
                    class="form-control"
                    name="descripcion"
                    id="descripcion"
                    aria-describedby="helpId"
                    placeholder="Escriba informacion sobre el colaborador..."
                />
            </div>    

            <!-- Instagram -->
            <div class="mb-3">
                <label for="" class="form-label">Instagram:</label>
                <input
                    type="text"
                    class="form-control"
                    name="linkinstagram"
                    id="linkinstagram"
                    aria-describedby="helpId"
                    placeholder="Escriba el link de la cuenta de instagram..."
                />
            </div>   

            <!-- facebook -->
            <div class="mb-3">
                <label for="" class="form-label">Facebook:</label>
                <input
                    type="text"
                    class="form-control"
                    name="linkfacebook"
                    id="linkfacebook"
                    aria-describedby="helpId"
                    placeholder="Escriba el link de la cuenta de facebook..."
                />
            </div>   

            <!-- linkedin -->
            <div class="mb-3">
                <label for="" class="form-label">Linkedin:</label>
                <input
                    type="text"
                    class="form-control"
                    name="linklinkedin"
                    id="linklinkedin"
                    aria-describedby="helpId"
                    placeholder="Escriba el link de la cuenta de linkedin..."
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
            <button type="submit" class="btn btn-success">Crear Colaborador</button>
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