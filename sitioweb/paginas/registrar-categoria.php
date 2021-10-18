<?php
$nom = "";
$datos = array();
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
$cliente = new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));

//verificar al botón que se le hizo clic  
if(isset($_POST["btnGuadar"])){
    if(!empty($_POST["txtNom"])){
        $nom = htmlspecialchars($_POST["txtNom"]);
       
       //SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	   $datos=$cliente->registrarCategoria($nom);
	    if($datos[0]["ID"]== "1") {
            echo '<script language="javascript">alert("Categoria registrada correctamente.")</script>';
             $nom = "";
             echo "<script language='javascript'>document.location.href = 'inicio.php?op=categorias';</script>";
        }else{
             $datos[0] = 0;
            echo '<script language="javascript">alert("Categoria ya existente, modificar dato.")</script>';
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
                <h2><b for="" class="col-sm-2 col-form-label">Registrar Categoria:</b></h2>
              </div>
              <form method="POST" name="registrar" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="txtNom" class="col-sm-3 col-form-label text-center">Nombre de la categoria:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtNom" name="txtNom" required>
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