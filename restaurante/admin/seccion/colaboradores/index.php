
<?php 
    include("../../bd.php");

     if(isset($_GET['txtID'])){
        $txtID = (isset($_GET["txtID"]))?$_GET['txtID']:"";

        // Borrado fisicamente
        // Proceso de borrado que busque la imagen y la pueda borrar
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
        //print_r($registro_imagen);

        if(isset($registro_imagen["imagen"])){  // vemos que exista la imagen
            // Borramos los datos si esta el archivo 
            if(file_exists("../../../images/colaboradores/".$registro_imagen["imagen"])){
                unlink("../../../images/colaboradores/".$registro_imagen["imagen"]);
            }
        }

        // Borramos en la base de datos 
        $sentencia = $conexion->prepare("DELETE FROM tbl_colaboradores WHERE ID = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        header("Location:index.php");
    } 

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores`");
    $sentencia->execute();

    $lista_colaboradores=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    include("../../templates/header.php"); 
?> 

</br>
<div class="card">
    <div class="card-header">
        <a
            name=""
            id=""
            class="btn btn-primary"
            href="crear.php"
            role="button"
            >Agregar Registros</a
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
                        <th scope="col">Nombre del Colaborador</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Redes Sociales </th>
                        <th scope="col">Acciones </th>
                    </tr>
                </thead>
                <tbody>

                <!-- Agegamos los registros traidos de la base de dato-->
                <?php foreach ($lista_colaboradores as $value){ ?>
                            <tr class="">
                            <td scope="row"><?php echo $value["id"]?> </td>
                            <td> <?php echo $value["titulo"]?>  </td>
                            <td><?php echo $value["descripcion"]?> </td>
                            <td>
                             <img src="../../../images/colaboradores/<?php echo $value['imagen']; ?>" alt="Imagen del colaborador" width="50">
            
                            <td>
                                <?php echo $value["linkinstagram"];?> <br>
                                <?php echo $value["linkfacebook"];?> <br>
                                <?php echo $value["linklinkedin"];?> 
                            </td>
                            <td>
                                <a
                                    name=""
                                    id=""
                                    class="btn btn-info"
                                    href="editar.php?txtID=<?php echo $value['id'];?>"
                                    role="button"
                                    >Editar</a
                                >
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
                <?php   } ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="card-footer text-muted"></div>
</div>


<?php include("../../templates/footer.php"); ?> 