<?php
$prov = "";
$pres = "";
$nom = "";
$cant = "";
$cad = "";
$usu = "";
$precio_v = "";
$precio_a = "";
$foto = "";
$ubi="";
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
)	
);
$datos_proveedores = $cliente->consproveedores();
$datos_categorias = $cliente->consCategorias();
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    if(!empty($_POST["txtNom"]) && !empty($_POST["txtPres"]) && !empty($_POST["txtUbi"]) && !empty($_POST["txtCant"]) && !empty($_POST["txtPrecioV"]) && !empty($_POST["txtPrecioA"] && !empty($_POST["txtCad"]) && !empty($_POST["txtProv"]) && isset($_FILES["filIma"]["name"]))){
        $prov = htmlspecialchars($_POST["txtProv"]);
        $pres =htmlspecialchars($_POST["txtPres"]);
        $nom = htmlspecialchars($_POST["txtNom"]);
        $cant= htmlspecialchars($_POST["txtCant"]);
        $cad= htmlspecialchars($_POST["txtCad"]);
        $ubi= htmlspecialchars($_POST["txtUbi"]);
        $usu= $_SESSION['cveUsuario'];
        $precio_v= htmlspecialchars($_POST["txtPrecioV"]);
        $precio_a= htmlspecialchars($_POST["txtPrecioA"]);
        $cat= htmlspecialchars($_POST["txtCat"]);
        $foto = "";
        //se indican los tipos de imagenes que se pueden subir
        $tipo = array("image/jpg", "image/jpeg", "image/png");
        //estoy dando un tamaño máximo de 16MB de la imagen
        $tamaño=16384;
        //se obtiene el nombre de la imagen a cargar
        $temp = $_FILES['filIma']['tmp_name'];
        
        //verificamos que cumpla con el tipo y tamaño
        if(in_array($_FILES["filIma"]["type"], $tipo) && $_FILES["filIma"]["size"] <= $tamaño * 1024){
            //se obtienen los datos de la imagen
            $ino = basename($_FILES['filIma']['name']);
            $ipe = (int)$_FILES['filIma']['size'];
            $iti = $_FILES['filIma']['type'];
            //nueva ruta donde se guardará la imagen en el sitio web
            $foto = "paginas/imagenes/productos/".$ino;
            //se mueve o copia la imagen a la nueva ruta
            move_uploaded_file($temp, $foto);
           //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    	  $datos=$cliente->registrarProducto($prov, $pres, $nom, $cant, $cad, $usu, $precio_v, $precio_a, $foto);
    	   //$datos[0]["ID"]=1;
    	    if($datos[0]["ID"]!= "0") {
                echo '<script language="javascript">alert("Producto registrado correctamente.")</script>';
                //echo "Categoria> ".$datos_categorias[$reg]["Clave"];
                $datos_relacion=$cliente->productoMayor();
                // echo json_encode($datos_relacion);
                 $iden= $datos_relacion[0]["ID"];
                // $iden= intval($datos_relacion[0]["ID"]);
                // $cate_envia = intval($datos_categorias[$reg]["Clave"]);
                //  echo "Valor de iden> ".$iden;
                //  echo "Valor de cat> " .$cat;
                // echo "Valor de ubi> " . $ubi;
                $datos_rel=$cliente->registrarRelacion($iden, $cat, $ubi);
                //echo json_encode($datos_rel);
                if($datos_rel[0]["ID"]== "1") {
                    echo '<script language="javascript">alert("Categoria asignada")</script>';
                }else if($datos_rel[0]["ID"]== "0"){
                    echo '<script language="javascript">alert("La relacion ya existe")</script>';
                }else if ($datos_rel[0]["ID"]== "2"){
                    echo '<script language="javascript">alert("Un dato no existe.")</script>';
                }else{
                    echo '<script language="javascript">alert("Algo salio mal, valor: "'.$datos_rel[0]["ID"].')</script>';
                }
                
                 $prov = "";$pres = "";$nom = "";$cant = "";$cad = "";$usu = "";$precio_v = "";$precio_a = "";$foto="";
            } else {
                $datos[0] = 0;
                echo '<script language="javascript">alert("Producto no registrado, verificar datos.")</script>';
            }
        } else {
          echo '<script language="javascript">alert("Imagen no valida.")</script>';
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
                <h2><b for="" class="col-sm-2 col-form-label">Administrar Productos:</b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Producto:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPres" class="col-sm-3 col-form-label text-center">Presentación:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPres" name="txtPres" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCant" class="col-sm-3 col-form-label text-center">Cantidad:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" step="0.01" id="txtCant" name="txtCant" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCad" class="col-sm-3 col-form-label text-center">Fecha de caducidad:</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="txtCad" name="txtCad" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPrecioA" class="col-sm-3 col-form-label text-center">Precio de adquisición:</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="txtPrecioA" name="txtPrecioA" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPrecioV" class="col-sm-3 col-form-label text-center">Precio de venta:</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="txtPrecioV" name="txtPrecioV" required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="txtProv" class="col-sm-3 col-form-label text-center">Selecciona el proveedor:</label>
                      <div class="col-sm-9">
                          <select class="form-select" id="txtProv" name="txtProv" required>
                            <?php
                                for($reg = 0; $reg < count($datos_proveedores); $reg++){
                                    echo '<option selected value="'.$datos_proveedores[$reg]["CLAVE"].'">'.$datos_proveedores[$reg]["EMPRESA"].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                </div>
                
                
                <div class="mb-3 row">
                      <label for="txtCat" class="col-sm-3 col-form-label text-center">Selecciona el tipo de producto:</label>
                      <div class="col-sm-9">
                          <select class="form-select" id="txtCat" name="txtCat" required>
                            <?php
                                for($reg = 0; $reg < count($datos_categorias); $reg++){
                                    echo '<option selected value="'.$datos_categorias[$reg]["Clave"].'">'.$datos_categorias[$reg]["Categoria"].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtUbi" class="col-sm-3 col-form-label text-center">Ubicación:</label>
                    <div class="col-sm-9">
                        <input type="text" step="0.01" class="form-control" id="txtUbi" name="txtUbi" required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="filIma" class="col-sm-3 col-form-label text-center">Selecciona la imagen:</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="file" id="filIma" name="filIma">
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