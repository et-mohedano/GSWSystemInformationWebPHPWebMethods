<?php
$estado = "0";
$datos=array();
$datosDel=array();
$totalRegistro=0;
$numRegistro=3;
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
       $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
	   )	
	  );	
	  
    //OBITNE LA PÁGINA ACTUAL O A LA QUE SE LE HIZO CLIC
    if(isset($_GET['pagina'])){
	  $numPagina=$_GET['pagina'];		
	}
	else{ //la primera vez que mostrará los datos
		  $inicioPag=0;
		  $numPagina=1;
	}	 	 
	//DETERMINA CUÁNTOS REGISTROS SE TRAERAN POR PÁGINA
	if($numPagina>1){		  
		$inicioPag=($numPagina-1)*$numRegistro;	  		
	}
	else{ //CUANDO ES LA PRIMERA VEZ
		$inicioPag=0;
	}	  
	    
	//###SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	$datos=$cliente->contarUsuarios();	
	
	$totalRegistro=$datos[0];		
	//DETEMRINA EL TOTAL DE PAÁGINAS
	$totalPaginas=ceil($totalRegistro/$numRegistro);	  	  					    
		
	//###SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	//OBTIENE EL TOTAL DE REGISTROS A MOSTRAR EN LA PÁGINA
	$datosPag=$cliente->consultarUsuarios($inicioPag,$numRegistro);			
    $estado=1;
   
    //VERIFICA QUE LA VARIABLE ne TENGA VALOR PARA ELIMINAR AL USUARIO
    if (isset($_GET['ne'])){
       
       	$datosDel=$cliente->eliminarUsuario($_GET['ne']);	
       	if((int)$datosDel[0]["ID"]!=0)
       	{
       	    echo '<script language="javascript">alert("Usuario eliminado correctamente")</script>';
       	    echo "<script language='javascript'>document.location.href = 'inicio.php?op=usuarios';</script>";
       	}
    }

?>
<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
              <div class="col-auto">
                <h2><b for="" class="col-form-label">Administrar Usuarios:</b></h2>
              </div>
              <form id="frmConexion" name="frmConexion" method="POST">
                <div class="container">
                    <div class="table-responsive table-report">
                      <table align="center" class="table table-dark table-striped">
                        <thead>
                          <tr>
                              <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                              <td><b>Clave</b></td>
                              <td><b>Nombre</b></td>
                              <td><b>Rol</b></td>  
                              <td><b>Perfil</b></td>
                              <td><b>Contraseña</b></td> 
                              <td><b>Contacto</b></td> 
                              
                          </tr>
                        </thead>
                        <tbody>
                    <?php
                      if($estado!="0")
                      {	          
                    	for($rr=0;$rr<count($datosPag);$rr++){	
                    		echo "<tr>";
                    		echo "<td bg-primary><a href='?op=modificar-usuario&cve=".$datosPag[$rr]["CLAVE"]."' class='btn btn-sys btn-options' title='Editar' ><i class='fa fa-pencil-square-o'></i></a>
                                <br/><a href='?op=usuarios&ne=".$datosPag[$rr]["CLAVE"]."' class='btn btn-sys' title='Eliminar' ><i class='fa fa-times-circle'></i></a></td>";
                            echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["CLAVE"]."</td>";
                    		echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["NOMBRE"]."</td>";
                    		echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["ROL"]."</td>";
                    	    echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["PERFIL"]."</td>";
                    	    echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["PWD"]."</td>";
                    	    echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["CONTACTO"]."</td>";
                    		echo "</tr>";
                          }
                    	  echo "</tbody></table></div><center>";
                	  if($totalPaginas>1)
                	  {
                	     echo "<font class='Etiquetas2'>P&aacute;ginas: </font>";
                	  }
                	  else
                	  {
                		  echo "P&aacute;gina:";
                	  }	  
                	  for ($i=1; $i<=$totalPaginas; $i++)
                	  {		
                		if ($numPagina == $i)
                		{
                			echo "<font class='text-primary'><b> $numPagina </b> </font>";
                		}
                		else
                		{		
                			echo " <a href='?op=usuarios&pagina=$i'>$i</a> ";
                		}
                	  }
                	  echo "</center>";
                	  
                  }
                ?>
                </div>
                </form>
                <hr>
                  <div class="text-center">
                      <a href='?op=registrar-usuario' class="btn btn-sys">Registrar Usuario&nbsp;</a>
                      <a href='?op=activar-usuario' class="btn btn-sys">Activar Usuario&nbsp;</a>
                      <!--<button type="button" class="btn btn-sys">Cancelar&nbsp;</button>-->
                  </div>
                <hr>
        </div>
        <?php
            require('sidebar.php');
        ?>
    </div>
</main>