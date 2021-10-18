<?php
$cve = $_GET["cve"];
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
)	
);
$datos_producto = $cliente->filtrarProducto($cve);
$datos_proveedores = $cliente->consproveedores();
$datos_categorias = $cliente->consCategorias();
$datos_catRel = $cliente-> consDatRel($cve);
$nom = $datos_producto[0]['ARTICULO'];
$pres = $datos_producto[0]['PRESENTACION'];
$prov = $datos_producto[0]['SURTIDOR'];
$cant = $datos_producto[0]['CANTIDAD'];
$cad = $datos_producto[0]['CADUCIDAD'];
$cat = $datos_catRel[0]['CATEGORIA_P'];
$ubi = $datos_catRel[0]['UBICACION'];
$usu= $_SESSION['cveUsuario'];
$precio_v = $datos_producto[0]['VENTA'];
$precio_a = $datos_producto[0]['ADQUISICION'];
$foto = $datos_producto[0]['FOTO'];
//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    $prov = htmlspecialchars($_POST["txtProv"]);
    $pres =htmlspecialchars($_POST["txtPres"]);
    $nom = htmlspecialchars($_POST["txtNom"]);
    $cant= htmlspecialchars($_POST["txtCant"]);
    $cad= htmlspecialchars($_POST["txtCad"]);
    $precio_v= htmlspecialchars($_POST["txtPrecioV"]);
    $precio_a= htmlspecialchars($_POST["txtPrecioA"]);
    $cat = htmlspecialchars($_POST["txtCat"]);
    $ubi = htmlspecialchars($_POST["txtUbi"]);
    //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
    $datos = $cliente->modificarProducto($cve, $prov, $pres, $nom, $cant, $cad, $usu, $precio_v, $precio_a, $foto);
    if($datos[0]["ID"]!= "0") {
        echo '<script language="javascript">alert("Producto modificado correctamente.")</script>';
        //  $prov = "";$pres = "";$nom = "";$cant = "";$cad = "";$usu = "";$precio_v = "";$precio_a = "";$foto="";
    } else {
        $datos[0] = 0;
        echo '<script language="javascript">alert("Producto no modificado, verificar datos.")</script>';
    }
    
    $datos_cat = $cliente->modificarCatRel($cve, $cve, $cat, $ubi);
    if($datos[0]["ID"]== "1") {
        echo '<script language="javascript">alert("Categoria modificada correctamente.")</script>';
        //  $prov = "";$pres = "";$nom = "";$cant = "";$cad = "";$usu = "";$precio_v = "";$precio_a = "";$foto="";
    } else if($datos[0]["ID"]== "0") {
        $datos[0] = 0;
        echo '<script language="javascript">alert("Producto no modificado, verificar datos.")</script>';
    }else if($datos[0]["ID"]== "2"){
        $datos[0] = 0;
        echo '<script language="javascript">alert("Es un 2.")</script>';
    }else{
        $datos[0] = 0;
        echo '<script language="javascript">alert("No se que paso")</script>';
    }
} 

?>

<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
              <div class="col-auto text-center">
                <h2><b for="" class="col-sm-2 col-form-label">Modificación de producto con clave <?=$cve?></b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Producto:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" value="<?=$nom?>" required>
                     </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPres" class="col-sm-3 col-form-label text-center">Presentación:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPres" name="txtPres" value="<?=$pres?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCant" class="col-sm-3 col-form-label text-center">Cantidad:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" step="0.01" id="txtCant" name="txtCant" value="<?=$cant?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtCad" class="col-sm-3 col-form-label text-center">Fecha de caducidad:</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="txtCad" name="txtCad" value="<?=$cad?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPrecioA" class="col-sm-3 col-form-label text-center">Precio de adquisición:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" step="0.01" id="txtPrecioA" name="txtPrecioA" value="<?=$precio_a?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtPrecioV" class="col-sm-3 col-form-label text-center">Precio de venta:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" step="0.01" id="txtPrecioV" name="txtPrecioV" value="<?=$precio_v?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="txtProv" class="col-sm-3 col-form-label text-center">Selecciona el proveedor:</label>
                      <div class="col-sm-9">
                          <select class="form-select" id="txtProv" name="txtProv">
                            <?php
                                for($reg = 0; $reg < count($datos_proveedores); $reg++){
                                    if($prov ==$datos_proveedores[$reg]["CLAVE"]){
                                        echo '<option selected value="'.$datos_proveedores[$reg]["CLAVE"].'">'.$datos_proveedores[$reg]["EMPRESA"].'</option>';
                                    }else{
                                        echo '<option value="'.$datos_proveedores[$reg]["CLAVE"].'">'.$datos_proveedores[$reg]["EMPRESA"].'</option>';
                                    }
                                    
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
                                    if($cat ==$datos_categorias[$reg]["Clave"]){
                                        echo '<option selected value="'.$datos_categorias[$reg]["Clave"].'">'.$datos_categorias[$reg]["Categoria"].'</option>';
                                    }else{
                                        echo '<option value="'.$datos_categorias[$reg]["Clave"].'">'.$datos_categorias[$reg]["Categoria"].'</option>';
                                    }
                                    
                                }
                            ?>
                          </select>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtUbi" class="col-sm-3 col-form-label text-center">Ubicación:</label>
                    <div class="col-sm-9">
                        <input type="text" step="0.01" class="form-control" id="txtUbi" name="txtUbi" value="<?=$ubi?>"required>
                    </div>
                </div>
                <div class="mb-3 row">
                      <label for="filIma" class="col-sm-3 col-form-label text-center">Selecciona la imagen:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="filIma" name="filIma" value="<?=$foto?>" required readonly>
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