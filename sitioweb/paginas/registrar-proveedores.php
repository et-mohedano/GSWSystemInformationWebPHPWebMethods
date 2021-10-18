<?php
$empresa = "";
$tel_s = "";
$tel = "";
$correo = "";
$nom = "";
$ape_pa = "";
$ape_ma = "";
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
)	
);
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    if(!empty($_POST["txtNom"]) && !empty($_POST["txtEmp"]) && !empty($_POST["txtTel"]) && !empty($_POST["txtTel_s"]) && !empty($_POST["txtAp"]) && !empty($_POST["txtAm"]) && !empty($_POST["txtCorreo"])){
        $empresa = htmlspecialchars($_POST["txtEmp"]);
        $tel_s = htmlspecialchars($_POST["txtTel_s"]);
        $tel = htmlspecialchars($_POST["txtTel"]);
        $correo = htmlspecialchars($_POST["txtCorreo"]);
        $nom = htmlspecialchars($_POST["txtNom"]);
        $ape_pa = htmlspecialchars($_POST["txtAp"]);
        $ape_ma = htmlspecialchars($_POST["txtAm"]);
           //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    	   $datos=$cliente->registrarProveedor($empresa, $tel_s, $tel, $correo, $nom, $ape_pa, $ape_ma);
    	    if($datos[0]["ID"]!= "0") {
                echo '<script language="javascript">alert("Proveedor registrado correctamente.")</script>';
                 $prov = "";$pres = "";$nom = "";$cant = "";$cad = "";$usu = "";$precio_v = "";$precio_a = "";$foto="";
            } else {
                $datos[0] = 0;
                echo '<script language="javascript">alert("Proveedor no registrado, verificar datos.")</script>';
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
                <h2><b for="" class="col-sm-2 col-form-label">Registrar Proveedor:</b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtEmp" class="col-sm-3 col-form-label text-center">Empresa:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtEmp" name="txtEmp" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Nombre:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtAp" class="col-sm-3 col-form-label text-center">Apellido paterno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtAp" name="txtAp" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtAm" class="col-sm-3 col-form-label text-center">Apellido materno:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtAm" name="txtAm" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel" class="col-sm-3 col-form-label text-center">Teléfono:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel" name="txtTel" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCorreo" class="col-sm-3 col-form-label text-center">Correo:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="txtCorreo" name="txtCorreo" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtTel_s" class="col-sm-3 col-form-label text-center">Teléfono supervisor:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtTel_s" name="txtTel_s" required>
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