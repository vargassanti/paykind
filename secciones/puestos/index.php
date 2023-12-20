<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("location:index.php?mensaje=".$mensaje);
}

$sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include("../../templates/header.php");?>

<section class="home">
    <div class="text">
        <br/>
        <h4>Puestos</h4>
        <div class="card">
            <div class="card-header">
                <a name="" id="" class="btn btn-primary" 
                    href="crear.php" role="button">
                    Agregar registro
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table" id="tabla_id">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre del puesto</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($lista_tbl_puestos as $registro) {?>
                            <tr class="">
                                <td scope="row"><?php echo $registro['id'];?></td>
                                <td><?php echo $registro['nombredelpuesto'];?></td>
                                <td>
                                    <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id'];?>" role="button">Editar</a>
                                    <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'];?>);" role="button">Eliminar</a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>
    </div>
</section>

<script>
    function borrar(id){
        Swal.fire({
            title: '¿Desea borrar el registro?',
            showCancelButton: true,
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location="index.php?txtID="+id;
            } 
        })
    }
</script>