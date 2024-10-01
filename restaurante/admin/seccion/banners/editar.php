<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_banners` WHERE ID= :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $titulo=$registro['titulo'];
    $descripcion=$registro['descripcion'];
    $link=$registro['link'];
    
}

if($_POST){
    $txtID = (isset($_POST["txtID"]))?$_POST['txtID']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $link=(isset($_POST['link']))?$_POST['link']:"";
    
    $sentencia=$conexion->prepare("UPDATE `tbl_banners` SET titulo=:titulo, descripcion=:descripcion, link=:link WHERE ID=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":link", $link);

    $sentencia->execute();

    header("Location:index.php");
}

include("../../templates/header.php"); 
?> 
<br>
<div class="card">
    <div class="card-header">
        Banners
    </div>
    <div class="card-body">
        <form action="" method="post">

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
                <label for="" class="form-label">Titulo:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $titulo; ?>"
                    name="titulo"
                    id="titulo"
                    aria-describedby="helpId"
                    placeholder="Escriba el titulo del banner..."
                />

            </div>

            <!-- descripcion -->
            <div class="mb-3">
                <label for="" class="form-label">descripcion:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $descripcion;?>"
                    name="descripcion"
                    id="descripcion"
                    aria-describedby="helpId"
                    placeholder="Escriba la descripcion del banner..."
                />
            </div>    

            <!-- enlace -->
            <div class="mb-3">
                <label for="" class="form-label">Enlace:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $link; ?>"
                    name="link"
                    id="link"
                    aria-describedby="helpId"
                    placeholder="Escriba el enlace del banner..."
                />
            </div>    

            <!-- boton de crear -->
            <button type="submit" class="btn btn-success">Modificar Banner</button>
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