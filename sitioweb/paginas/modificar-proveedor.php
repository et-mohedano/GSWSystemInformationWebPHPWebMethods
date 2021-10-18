<?php
$cve = $_GET["cve"];
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
)	
);
$datos_proveedor = $cliente->filtrarProveedor($cve);
$correo = $datos_proveedor[0]['CORREO'];
$emp = $datos_proveedor[0]['EMPRESA'];
$nom = $datos_proveedor[0]['NOMBRE'];
$apa = $datos_proveedor[0]['PATERNO'];
$ama = $datos_proveedor[0]['MATERNO'];
$tel = $datos_proveedor[0]['TELEFONO'];
$tel_s = $datos_proveedor[0]['TELEFONO_SUPERVISOR'];
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    $correo = htmlspecialchars($_POST["txtCorreo"]);
    $emp = htmlspecialchars($_POST["txtEmp"]);
    $nom = htmlspecialchars($_POST["txtNom"]);
    $apa = htmlspecialchars($_POST["txtApa"]);
    $ama = htmlspecialchars($_POST["txtAma"]);
    $tel = htmlspecialchars($_POST["txtTel"]);
    $tel_s = htmlspecialchars($_POST["txtTel_s"]);
    //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    $datos = $cliente->modificarProveedor($cve, $emp, $tel_s, $tel, $correo, $nom, $apa, $ama, 1);
    if($datos[0]["ID"]== "1") {
        echo '<script language="javascript">alert("Producto modificado correctamente.")</script>';
        //  $prov = "";$pres = "";$nom = "";$cant = "";$cad = "";$usu = "";$precio_v = "";$precio_a = "";$foto="";
    } else if($datos[0]["ID"]== "0") {
        $datos[0] = 0;
        echo '<script language="javascript">alert("Producto no modificado, verificar datos.")</script>';
    }else{
        $datos[0] = 0;
        echo '<script language="javascript">alert("Empresa duplicada, verificar datos.")</script>';
    }
} 

?>

<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
              <div class="col-auto text-center">
                <h2><b for="" class="col-sm-2 col-form-label">Modificación de proveedor con clave <?=$cve?></b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtEmp" class="col-sm-3 col-form-label text-center">Empresa:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtEmp" name="txtEmp" value="<?=$emp?>" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Nombre:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" value="<?=$nom?>" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtApa" class="col-sm-3 col-form-label text-center">Apellido paterno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtApa" name="txtApa" value="<?=$apa?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtAma" class="col-sm-3 col-form-label text-center">Apellido materno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtAma" name="txtAma" value="<?=$ama?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel" class="col-sm-3 col-form-label text-center">Teléfono:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel" name="txtTel" value="<?=$tel?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCorreo" class="col-sm-3 col-form-label text-center">Correo:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="txtCorreo" name="txtCorreo" value="<?=$correo?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel_s" class="col-sm-3 col-form-label text-center">Teléfono supervisor:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel_s" name="txtTel_s" value="<?=$tel_s?>" required>
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
        <?php
            require('sidebar.php');
        ?>
    </div>
</main>