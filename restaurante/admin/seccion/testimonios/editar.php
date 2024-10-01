<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_testimonios` WHERE ID= :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $opinion=$registro['opinion'];
    $nombre=$registro['nombre'];
    
}

if($_POST){
    $txtID = (isset($_POST["txtID"]))?$_POST['txtID']:"";
    $opinion=(isset($_POST['opinion']))?$_POST['opinion']:"";
    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    
    $sentencia=$conexion->prepare("UPDATE `tbl_testimonios` SET  opinion=:opinion, nombre=:nombre WHERE ID=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":opinion", $opinion);

    $sentencia->execute();

    header("Location:index.php");
}

include("../../templates/header.php"); 
?> 
<br>
<div class="card">
    <div class="card-header">
        Testimonios
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
                />

            </div>

            <!-- opinion -->
            <div class="mb-3">
                <label for="" class="form-label">Opinion:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $opinion; ?>"
                    name="opinion"
                    id="opinion"
                    aria-describedby="helpId"
                    placeholder="Escriba la opinion"
                />

            </div>

            <!-- nombre -->
            <div class="mb-3">
                <label for="" class="form-label">Nombre:</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?php echo $nombre;?>"
                    name="nombre"
                    id="nombre"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre..."
                />
            </div>    

            <!-- boton de crear -->
            <button type="submit" class="btn btn-success">Modificar Testimonio</button>
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