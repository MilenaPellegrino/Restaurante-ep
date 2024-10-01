<?php 
    include("../../bd.php");
    include("../../templates/header.php"); 

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_comentarios`");

    $sentencia->execute();
    $lista_comentarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    // Borrado 

    if(isset($_GET['txtID'])){
        $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

        $sentencia = $conexion->prepare("DELETE FROM tbl_comentarios WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        header("Location:index.php");
    }
?>
<br>

<div class="card">
    <div class="card-header">Comentarios</div>
    <div class="card-body">
        <div
            class="table-responsive"
        >
            <table
                class="table table-primary"
            >
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo Electronico</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_comentarios as $value) { ?>
                    <tr class="">
                        <td scope="row"><?php echo  $value['id']; ?></td>
                        <td><?php echo  $value['nombre']; ?></td>
                        <td><?php echo  $value['correo']; ?></td>
                        <td><?php echo  $value['mensaje']; ?></td>
                        <td>
                        <a
                                    name=""
                                    id=""
                                    class="btn btn-danger"
                                    href="index.php?txtID=<?php echo $value['id'];?>"
                                    role="button"
                                    >Eliminar</a
                                >
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>




<?php include("../../templates/footer.php"); ?>