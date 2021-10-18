<?php
$cve = $_GET["cve"];
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));

$datos_producto = $cliente-> filtrarCategoria($cve);
$nom = $datos_producto[0]['NOMBRE'];
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    $nom = htmlspecialchars($_POST["txtNom"]);

    //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    $datos = $cliente->modificarCategoria($cve, $nom);
    echo json_encode($datos);
    if($datos[0]["ID"]== "1") {
        echo '<script language="javascript">alert("Categoria modificada correctamente.")</script>';
        echo "<script language='javascript'>document.location.href = 'inicio.php?op=categorias';</script>";
    }else{
        $datos[0] = 0;
        echo '<script language="javascript">alert("Categoria no modificada, cambiar datos.")</script>';
    }
} 

?>

<main>
    <div class="row">
        <div class="col col-md-2">
        </div>
        <div class="col col-md-5 col-xs-12">
              <div class="col-auto text-center">
                <h2><b for="" class="col-sm-2 col-form-label">Modificación de categoria con clave <?=$cve?></b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Categoria:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" value="<?=$nom?>" required>
                     </div>
                </div>
                <hr>
                  <div class="text-center">
                    <button type="submit" name="btnGuadar" id="btnGuadar" class="btn btn-sys">Modificar</button>
                    <button type="reset" class="btn btn-sys">Cancelar</button>
                  </div>
                <hr>
                </form>
        </div>
        <div class="col col-md-2">
        </div>
        <?php
            require('sidebar.php');
        ?>
    </div>
</main>