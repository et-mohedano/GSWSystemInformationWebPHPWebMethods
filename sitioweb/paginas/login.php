<?php
    if(isset($_SESSION['cveUsuario'])){
        echo "<script language='javascript'>document.location.href = 'inicio.php?op=consultar_productos';</script>";
    }
    $nom = "";
    $dato = "";
    $con = "";
    // Verificación del dato recibido (txtUsuario)
    if(!empty($_POST['txtUsuario'])){
        $nom = htmlspecialchars($_POST['txtUsuario']);
        $con = htmlspecialchars($_POST['txtContrasena']);
        //-------------------------------------------
        // Creación del servicio web (objeto) que ya esta publicado
        $cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));
        // ----------------------------------------------------
        // PRUEBAS DE EJECUCION DEL METODO acceso(,)
        $datosUsuario = $cliente->acceso($nom, $con);
        if ((int)$datosUsuario[0]["ID"] != 0){
            // echo json_encode($datosUsuario);
            if(!isset($_SESSION['cveUsuario']))
                $_SESSION['cveUsuario'] = $datosUsuario[0]['ID'];
            if(!isset($_SESSION['nomUsuario']))
                $_SESSION['nomUsuario'] = $datosUsuario[1]['NOMBRE'];
            if(!isset($_SESSION['rolUsuario']))
                $_SESSION['rolUsuario'] = $datosUsuario[2]['ROL'];
            echo "<script nomRol='javascript'>alert('Bienvenido ".$datosUsuario[1]['NOMBRE']."');</script>";
            echo "<script language='javascript'>document.location.href = 'inicio.php?op=consultar_productos';</script>";
        }else{
            // echo json_encode($datosUsuario);
            echo "<script language='javascript'>alert('Acceso denegado favor de validar sus datos');</script>";
        }
    }
?>
<main style="min-height: 26.55em !important;">
    <div class="row content-login">
        <div class="col-md">
        </div>
        <div class="col-md">
            <form method="POST">
              <div class="mb-3">
                <label for="txtUsuario" class="form-label">Ingresa tu usuario:</label>
                <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="txtContrasena" class="form-label">Ingresa tu contraseña:</label>
                <input type="password" class="form-control" name="txtContrasena" id="txtContrasena">
              </div>
              <div align="right">
                  <button type="submit" class="btn btn-sys">Aceptar</button>
              </div>
            </form>
        </div>
        <div class="col-md">
        </div>
    </div>
</main>