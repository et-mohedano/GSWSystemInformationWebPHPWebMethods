<?php
$cve = $_GET["cve"];
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));
$datos_producto = $cliente->filtrarUsuario($cve);
$nom = $datos_producto[0]['NOMBRE'];
$pat = $datos_producto[0]['PATERNO'];
$mat = $datos_producto[0]['MATERNO'];
$tel = $datos_producto[0]['TELEFONO'];
$per = $datos_producto[0]['PERFIL'];
$pas = $datos_producto[0]['PASS'];
$rol = $datos_producto[0]['ROL'];
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    $nom = htmlspecialchars($_POST["txtNom"]);
    $pat =htmlspecialchars($_POST["txtPat"]);
    $mat = htmlspecialchars($_POST["txtMat"]);
    $tel= htmlspecialchars($_POST["txtTel"]);
    $per= htmlspecialchars($_POST["txtPer"]);
    $pas= htmlspecialchars($_POST["txtPas"]);
    $rol= htmlspecialchars($_POST["txtRol"]);
    //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    $datos = $cliente->modificarUsuario($cve, $nom, $pat, $mat, $tel, $per, $pas, $rol);
    if($datos[0]["ID"]== "1") {
        echo '<script language="javascript">alert("Usuario modificado correctamente.")</script>';
        echo "<script language='javascript'>document.location.href = 'inicio.php?op=usuarios';</script>";
    } else if($datos[0]["ID"]== "0") {
        $datos[0] = 0;
        echo '<script language="javascript">alert("Usuario no existente.")</script>';
    }else if($datos[0]["ID"]== "2"){
        $datos[0] = 0;
        echo '<script language="javascript">alert("Perfil ya existente, cambiar datos.")</script>';
    }else{
        $datos[0] = 0;
        echo '<script language="javascript">alert("Contraseña ya existente, cambiar datos.")</script>';
    }
} 

?>

<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
              <div class="col-auto text-center">
                <h2><b for="" class="col-sm-2 col-form-label">Modificación de usuario con clave <?=$cve?></b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Nombre:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" value="<?=$nom?>" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPat" class="col-sm-3 col-form-label text-center">Apellido paterno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPat" name="txtPat" value="<?=$pat?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtMat" class="col-sm-3 col-form-label text-center">Apellido Materno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtMat" name="txtMat" value="<?=$mat?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel" class="col-sm-3 col-form-label text-center">Teléfono:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel" name="txtTel" value="<?=$tel?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPer" class="col-sm-3 col-form-label text-center">Perfil:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPer" name="txtPer" value="<?=$per?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPas" class="col-sm-3 col-form-label text-center">Contraseña:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPas" name="txtPas" value="<?=$pas?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="txtRol" class="col-sm-3 col-form-label text-center">Selecciona el rol:</label>
                      <div class="col-sm-9">
                          <select class="form-select" id="txtRol" name="txtRol">
                            <?php
                                if($rol=="Administrador"){
                                    echo '<option selected value="Administrador">Administrador</option>';
                                    echo '<option value="Empleado">Empleado</option>';
                                }else{
                                    echo '<option value="Administrador">Administrador</option>';
                                    echo '<option selected value="Empleado">Empleado</option>';
                                }
                            ?>
                          </select>
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