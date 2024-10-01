<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID= :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $titulo=$registro['titulo'];
    $descripcion=$registro['descripcion'];
    $linkinstagram=$registro['linkinstagram'];
    $linkfacebook=$registro['linkfacebook'];
    $linklinkedin=$registro['linklinkedin'];
    $imagen = $registro['imagen']; 

    
}

if($_POST){
    $txtID = (isset($_POST["txtID"]))?$_POST['txtID']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $linkinstagram=(isset($_POST['linkinstagram']))?$_POST['linkinstagram']:"";
    $linkfacebook=(isset($_POST['linkfacebook']))?$_POST['linkfacebook']:"";
    $linklinkedin=(isset($_POST['linklinkedin']))?$_POST['linklinkedin']:"";
    $imagen=(isset($_POST['imagen']))?$_POST['imagen']:"";
    
    $sentencia=$conexion->prepare("UPDATE `tbl_colaboradores` SET titulo=:titulo, descripcion=:descripcion, linkinstagram=:linkinstagram, linkfacebook=:linkfacebook, linklinkedin=:linklinkedin WHERE ID=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":linkinstagram", $linkinstagram);
    $sentencia->bindParam(":linkfacebook", $linkfacebook);
    $sentencia->bindParam(":linklinkedin", $linklinkedin);

    $sentencia->execute();

    // Proceso de actualizacion de la imagen
    // Recepcionamos la imagen 
    $imagen = (isset($_FILES['imagen']["name"])) ? $_FILES['imagen']["name"] : "";
    $tmp_imagen = $_FILES['imagen']["tmp_name"];

    if($imagen != ""){
        $Fecha_imagen = new DateTime();
        $nombre_imagen = $Fecha_imagen->getTimestamp() . "_" . $imagen;

        move_uploaded_file($tmp_imagen,  '../../../images/colaboradores/' . $nombre_imagen);

        // Borrado fisicamente
        // Proceso de borrado que busque la imagen y la pueda borrar
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($registro_imagen["imagen"])){  // vemos que exista la imagen
            // Borramos los datos si esta el archivo 
            if(file_exists("../../../images/colaboradores/".$registro_imagen["imagen"])){
                unlink("../../../images/colaboradores/".$registro_imagen["imagen"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_colaboradores` SET imagen=:imagen WHERE ID=:id");
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
        Colaboradores
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
                    placeholder="Escriba el titulo del banner..."
                />

            </div>

            <!-- titulo -->
            <div class="mb-3">
                <label for="" class="form-label">Nombre del colaborador:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $titulo; ?>"
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
                    value="<?php echo $descripcion; ?>"
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
                    value="<?php echo $linkinstagram; ?>"
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
                    value="<?php echo $linkfacebook; ?>"
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
                    value="<?php echo $linklinkedin; ?>"
                    name="linklinkedin"
                    id="linklinkedin"
                    aria-describedby="helpId"
                    placeholder="Escriba el link de la cuenta de linkedin..."
                />
            </div>   

            <!-- imagen -->
            <div class="mb-3">
                <div class="mb-3">
                    
                    <label for="" class="form-label">Seleccionar imagen:</label> <br>
                    <img src="../../../images/colaboradores/<?php echo $nombre_imagen; ?>" width="50"/>
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
            <button type="submit" class="btn btn-success">Editar Colaborador</button>
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