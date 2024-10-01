<?php 
    include("../../bd.php");

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios`");
    $sentencia->execute();

    $lista_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    // Borramos los usuarios 
    if(isset($_GET['txtID'])){
        $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

        $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        header("Location:index.php");
    }

    include("../../templates/header.php"); 
?>
<br>
<div class="card">
    <div class="card-header">
    <a
            name=""
            id=""
            class="btn btn-primary"
            href="crear.php"
            role="button"
            >Agregar Usuarios</a
        >
    </div>
    <div class="card-body">
        <div
            class="table-responsive-sm"
        >
            <table
                class="table table"
            >
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Password</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($lista_usuarios as $value){ ?>
                    <tr class="">
                        <td scope="row"><?php echo $value['id'];?></td>
                        <td><?php echo $value['nombre'];?></td>
                        <td><?php echo $value['correo'];?></td>
                        <td>*****</td>
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