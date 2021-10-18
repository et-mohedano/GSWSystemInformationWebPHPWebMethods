<?php
$nom = "";
$pat = "";
$mat = "";
$tel = "";
$per = "";
$pswd = "";
$rol = "";
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));

//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    if(!empty($_POST["txtNom"]) && !empty($_POST["txtPat"]) && !empty($_POST["txtMat"]) && !empty($_POST["txtTel"]) && !empty($_POST["txtPer"]) && !empty($_POST["txtPas"]) && !empty($_POST["txtRol"])){
        $pat = htmlspecialchars($_POST["txtPat"]);
        $mat =htmlspecialchars($_POST["txtMat"]);
        $nom = htmlspecialchars($_POST["txtNom"]);
        $tel= htmlspecialchars($_POST["txtTel"]);
        $per= htmlspecialchars($_POST["txtPer"]);
        $pswd= htmlspecialchars($_POST["txtPas"]);
        $rol= htmlspecialchars($_POST["txtRol"]);
       
       //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	   $datos=$cliente->registrarUsuario($nom, $pat, $mat, $tel, $per, $pswd, $rol);
	    if($datos[0]["ID"]== "1") {
            echo '<script language="javascript">alert("Usuario registrado correctamente.")</script>';
             $nom = ""; $pat = ""; $mat = ""; $tel = ""; $per = ""; $pswd = ""; $rol = "";
             echo "<script language='javascript'>document.location.href = 'inicio.php?op=usuarios';</script>";
        } else if ($datos[0]["ID"]== "0") {
            $datos[0] = 0;
            echo '<script language="javascript">alert("Contraseña ya existente, modificar datos.")</script>';
        }else{
             $datos[0] = 0;
            echo '<script language="javascript">alert("Perfil ya existente, modificar datos.")</script>';
        }
    }else{
        echo '<script language="javascript">alert("Error en campos")</script>';
    }
} 

?>

<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
              <div class="col-auto text-center">
                <h2><b for="" class="col-sm-2 col-form-label">Registrar Usuario:</b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Nombres:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPat" class="col-sm-3 col-form-label text-center">Apellido Paterno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPat" name="txtPat" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtMat" class="col-sm-3 col-form-label text-center">Apellido Materno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtMat" name="txtMat" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel" class="col-sm-3 col-form-label text-center">Teléfono:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel" name="txtTel" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPer" class="col-sm-3 col-form-label text-center">Perfil:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPer" name="txtPer" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPas" class="col-sm-3 col-form-label text-center">Contraseña:</label>
                    <div class="col-sm-9">
                        <input type="taxt" class="form-control" id="txtPas" name="txtPas" required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="txtRol" class="col-sm-3 col-form-label text-center">Selecciona el rol:</label>
                      <div class="col-sm-9">
                          <select class="form-select" id="txtRol" name="txtRol" required>
                              <option value="Administrador">Administrador</option>
                              <option selected value="Empleado">Empleado</option>
                          </select>
                        </div>
                </div>
                <hr>
                  <div class="text-center">
                    <button type="submit" name="btnGuadar" id="btnGuadar" class="btn btn-sys">Registrar</button>
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