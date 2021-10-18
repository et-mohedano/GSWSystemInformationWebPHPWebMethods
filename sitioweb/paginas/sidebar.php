<div class="col col-md-3 col-xs-4 content-alert">
    <h3>Alertas: </h3>
<?php
    //######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
       $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
	   )	
	  );	  	  					    
		
	//###SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	//OBTIENE EL TOTAL DE REGISTROS A MOSTRAR EN LA PÁGINA
	$datosPag=$cliente->consultarProductosAlerta();
	$fecha_actual = date("Y-m-d");
	$fecha_actual_2 = date("Y-m-d",strtotime($fecha_actual."+ 1 month")); 
    for($reg = 0; $reg < count($datosPag); $reg++){
        $fecha_prod = $datosPag[$reg]['CADUCIDAD']; 
        if($fecha_prod <= $fecha_actual_2 && $fecha_prod >= $fecha_actual){
            # Va a caducar
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>¡Producto próximo a caducar! '.$datosPag[$reg]['NOMBRE'].' '.$datosPag[$reg]['PRESENTACION']. ' => ' .$datosPag[$reg]['CADUCIDAD'].'</strong><br>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }else if($fecha_prod <= $fecha_actual){
            #Ya caduco
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>¡Producto caducado! '.$datosPag[$reg]['NOMBRE'].' '.$datosPag[$reg]['PRESENTACION']. ' => ' .$datosPag[$reg]['CADUCIDAD'].'</strong><br><center><a href="?op=productos&ne='.$datosPag[$reg]["CLAVE"].'" class="" title="Eliminar" > Pulsa aquí para eliminarlo</a></center>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        if($datosPag[$reg]['CANTIDAD'] <= 3 && $datosPag[$reg]['CANTIDAD'] > 0){
            echo '
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
              <strong>¡Producto próximo a agotarse!</strong> '.$datosPag[$reg]['NOMBRE'].' restan:'. $datosPag[$reg]['CANTIDAD'] .'
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }else if($datosPag[$reg]['CANTIDAD'] == 0){
            echo '
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
              <strong>¡Producto agotado!</strong> '.$datosPag[$reg]['NOMBRE'].': '. $datosPag[$reg]['CANTIDAD'] .'
              </strong><br><center><a href="inicio.php?op=modificar-producto&cve='.$datosPag[$reg]["CLAVE"].'" class="" title="Eliminar" >Pulsa aquí para actualizarlo</a></center><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
?>
    
    
    
</div>