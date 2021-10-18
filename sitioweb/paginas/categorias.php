<?php
$estado = "0";
$datos=array();
$datosDel=array();
$totalRegistro=0;
$numRegistro=3;
//######### HACE USO DEL SERVICIO WEB QUE ESTA PUBLICADO DE MANERA LOCAL ########		 
       $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'));	
	  
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
	$datos=$cliente->contarCategorias();	
	
	$totalRegistro=$datos[0];		
	//DETEMRINA EL TOTAL DE PAÁGINAS
	$totalPaginas=ceil($totalRegistro/$numRegistro);	  	  					    
		
	//###SE EJECUTA UN MÉTODO DEL SERVICIO WEB, PASANDO SUS PARAMETROS
	//OBTIENE EL TOTAL DE REGISTROS A MOSTRAR EN LA PÁGINA
	$datosPag=$cliente->consultarCategorias($inicioPag,$numRegistro);			
    $estado=1;
   
    //VERIFICA QUE LA VARIABLE ne TENGA VALOR PARA ELIMINAR AL USUARIO
    if (isset($_GET['ne'])){
       
       	$datosDel=$cliente->DelCategorias($_GET['ne']);	
       	if((int)$datosDel[0]["ID"]!=0)
       	{
       	    echo '<script language="javascript">alert("Categoria eliminada correctamente")</script>';
       	    echo "<script language='javascript'>document.location.href = 'inicio.php?op=categorias';</script>";
       	}
    }

?>
<main>
    <div class="row">
        <div class="col col-md-2">
        </div>
        <div class="col col-md-5 col-xs-12">
              <div class="col-auto">
                <h2><b for="" class="col-form-label">Administrar Categorias:</b></h2>
              </div>
              <form id="frmConexion" name="frmConexion" method="POST">
                <div class="container">
                    <div class="table-responsive table-report">
                      <table align="center" class="table table-dark table-striped text-center">
                        <thead>
                          <tr>
                              <td><b>Opciones</b></td>
                              <td><b>Clave</b></td>
                              <td><b>Categoria</b></td>
                          </tr>
                        </thead>
                        <tbody>
                    <?php
                      if($estado!="0")
                      {	          
                    	for($rr=0;$rr<count($datosPag);$rr++){	
                    		echo "<tr>";
                    		echo "<td bg-primary align='middle'><a href='?op=modificar-categoria&cve=".$datosPag[$rr]["Clave"]."' class='btn btn-sys' title='Editar' ><i class='fa fa-pencil-square-o'></i></a>
                                <a href='?op=categorias&ne=".$datosPag[$rr]["Clave"]."' class='btn btn-sys' title='Eliminar' ><i class='fa fa-times-circle'></i></a></td>";
                            echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["Clave"]."</td>";
                    		echo "<td><font class='Etiquetas2'>".$datosPag[$rr]["Categoria"]."</td>";
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
                			echo " <a href='?op=categorias&pagina=$i'>$i</a> ";
                		}
                	  }
                	  echo "</center>";
                	  
                  }
                ?>
                </div>
                </form>
                <hr>
                  <div class="text-center">
                      <a href='?op=registrar-categoria' class="btn btn-sys">Registrar Categoria&nbsp;</a>
                      <a href='?op=activar-categoria' class="btn btn-sys">Activar Categoria&nbsp;</a>
                      <!--<button type="button" class="btn btn-sys">Cancelar&nbsp;</button>-->
                  </div>
                <hr>
        </div>
        <div class="col col-md-2">
        </div>
        <?php
            require('sidebar.php');
        ?>
    </div>
</main>