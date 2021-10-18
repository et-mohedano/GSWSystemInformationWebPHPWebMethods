<?php
// Definición de la clase
class clsservicios{
     //PROGRAMACIÓN DE MÉTODOS CON ACCESO A DATOS (MYSQL).
    public function acceso($usuario, $contrasena) {
        //DEFINICIÓN DEL ARREGLO RECEPTOR DE DATOS.
        $datos = array();
        //CADENA DE CONEXIÓN TIENE ÉSTE FORMATO: hosting, usuario, contraseña, base de datos.
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
            echo "<script language='javascript'>alert('si');</script>";
            // CONEXION ABIERTA, PROCEDER A EJECUTAR COMANDOS SQL
            // CREACIÓN DE LA CONSULTA SQL
            $sqlText = "CALL spValidarAcceso('$usuario', '$contrasena')";
            // EJECUCION DE LA CONSULTA SQL
            $renglon = mysqli_query($conn, $sqlText);
          // VALIDA LA RECEPCION DE DATOS DE LA EJECUCION DEL PROCEDIMIENTO ALMACENADO
            while($resultado = mysqli_fetch_assoc($renglon)){
                // SE ANALIZARAN LOS DATOS PARA FORMATEAR EL ARREGLO DE SALIDA
                $datos[0]["ID"]=$resultado["CLAVE"];
                if( (int)$datos[0]!=0 ){
                    $datos[1]["NOMBRE"]=$resultado["USUARIO"];
                    $datos[2]["ROL"]=$resultado["ROL"];
                }
            }
            // CIERRE DE CONEXION
            mysqli_close($conn);
        }
        // RETORNAR DATOS A LA CAPA DE PRESENTACION
        return $datos;
    }
    public function buscarProductos($nom){
        $datos = array();
        $reg = 0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
            $renglon = mysqli_query($conn, "CALL spBuscaProducto('$nom')");
            while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[$reg]["CLAVE"] = $resultado["CLAVE"];
                $datos[$reg]["PRODUCTO"] = $resultado["ARTICULO"];
                $datos[$reg]["PRESENTACION"] = $resultado["PRESENTACION"];
                $datos[$reg]["PRECIO"] = $resultado["PRECIO"];
                $datos[$reg]["FOTO"] = $resultado["FOTO"];
                $datos[$reg]["VENCIMIENTO"] = $resultado["VENCIMIENTO"];
                $reg++;
            }
            mysqli_close($conn);
        }
        return $datos;
    }
    public function registrarUsuario($nom,$pat,$mat,$tel,$per, $pas, $rol){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spInsUsuario('$nom','$pat','$mat','$tel','$per','$pas','$rol');");	  			
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function eliminarUsuario($clave){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spDelUsuario('$clave');");	  			
		
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
			
									
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function contarUsuarios(){
		$res=array();		
		
  		if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsUsuario(0,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarUsuarios($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spConsUsuario(1,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["ROL"] =$resultado["ROL"];					
			    $datos[$reg]["PERFIL"] =$resultado["PERFIL"];					
			    $datos[$reg]["PWD"] =$resultado["PWD"];					
			    $datos[$reg]["CONTACTO"] =$resultado["CONTACTO"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function modificarUsuario($cve,$nom,$ap,$am,$tel,$per,$pas, $rol){
	$datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		$renglon = mysqli_query($conn,"CALL spModUsuario($cve, '$nom','$ap','$am','$tel','$per','$pas','$rol', null);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function filtrarUsuario($cve){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spTraUsuario($cve);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["NOMBRE"]=$resultado["NOMBRE"];				
			    $datos[$reg]["PATERNO"] =$resultado["PATERNO"];					
			    $datos[$reg]["MATERNO"] =$resultado["MATERNO"];					
			    $datos[$reg]["TELEFONO"] =$resultado["TELEFONO"];					
			    $datos[$reg]["PERFIL"] =$resultado["PERFIL"];
			    $datos[$reg]["PASS"] =$resultado["PASS"];					
			    $datos[$reg]["ROL"] =$resultado["ROL"];					
			    $datos[$reg]["ESTADO"] =$resultado["ESTADO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function contarUsuariosIna(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsUsuario(2,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarUsuariosIna($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsUsuario(4,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["ROL"] =$resultado["ROL"];					
			    $datos[$reg]["PERFIL"] =$resultado["PERFIL"];					
			    $datos[$reg]["PWD"] =$resultado["PWD"];					
			    $datos[$reg]["CONTACTO"] =$resultado["CONTACTO"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function actUsuario($cve){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModUsuario($cve, '','','','','','','', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function contarProductos(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProducto(0,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarProductos($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProducto(1,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["PRESENTACION"] =$resultado["PRESENTACION"];
			    $datos[$reg]["CANTIDAD"] =$resultado["CANTIDAD"];	
			    $datos[$reg]["CADUCIDAD"] =$resultado["CADUCIDAD"];	
			    $datos[$reg]["PRECIO_VENTA"] =$resultado["PRECIO_VENTA"];
			    $datos[$reg]["PRECIO_ADQUISICION"] =$resultado["PRECIO_ADQUISICION"];
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];
			    $datos[$reg]["SURTIDOR"] =$resultado["SURTIDOR"];
			    $datos[$reg]["EMPLEADO"] =$resultado["EMPLEADO"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function modificarProducto($cve,$prov,$pres,$nombre,$cant,$caduc, $usu, $ven, $adqu, $foto){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModProducto('$cve','$prov','$pres','$nombre','$cant','$caduc','$usu','$ven',' $adqu','$foto', null);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function eliminarProducto($clave){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spDelProducto('$clave');");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
			
									
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function registrarProducto($prov,$pres,$nombre,$cant,$caduc, $usu, $ven, $adqu, $foto){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spInsProducto('$prov','$pres','$nombre','$cant','$caduc','$usu','$ven','$adqu','$foto');");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function filtrarProducto($cve){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spTraProducto($cve);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["SURTIDOR"]=$resultado["SURTIDOR"];				
			    $datos[$reg]["PRESENTACION"] =$resultado["PRESENTACION"];					
			    $datos[$reg]["ARTICULO"] =$resultado["ARTICULO"];					
			    $datos[$reg]["CANTIDAD"] =$resultado["CANTIDAD"];					
			    $datos[$reg]["CADUCIDAD"] =$resultado["CADUCIDAD"];					
			    $datos[$reg]["EMPLEADO"] =$resultado["EMPLEADO"];					
			    $datos[$reg]["VENTA"] =$resultado["VENTA"];					
			    $datos[$reg]["ADQUISICION"] =$resultado["ADQUISICION"];					
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];					
			    $datos[$reg]["ESTADO"] =$resultado["ESTADO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function consproveedores(){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProveedor(0,0,0);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["EMPRESA"] =$resultado["EMPRESA"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function contarProveedores(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProveedor(0,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarProveedores($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProveedor(1,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["EMPRESA"] =$resultado["EMPRESA"];
			    $datos[$reg]["CONTACTO"] =$resultado["CONTACTO"];	
			    $datos[$reg]["CORREO"] =$resultado["CORREO"];	
			    $datos[$reg]["CONTACTO_SUPERVISOR"] =$resultado["CONTACTO_SUPERVISOR"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function registrarProveedor($emp, $tel_S, $tel, $correo, $nom, $paterno, $materno){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spInsProveedor('$emp','$tel_S','$tel','$correo','$nom','$paterno','$materno');");	  			
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function eliminarProveedor($clave){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spDelProveedor('$clave');");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}					
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function filtrarProveedor($cve){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spTraProveedor($cve);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CORREO"]=$resultado["CORREO"];				
			    $datos[$reg]["EMPRESA"] =$resultado["EMPRESA"];					
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];
			    $datos[$reg]["PATERNO"] =$resultado["PATERNO"];
			    $datos[$reg]["MATERNO"] =$resultado["MATERNO"];
			    $datos[$reg]["TELEFONO"] =$resultado["TELEFONO"];					
			    $datos[$reg]["TELEFONO_SUPERVISOR"] =$resultado["TELEFONO_SUPERVISOR"];					
			    $datos[$reg]["ESTADO"] =$resultado["ESTADO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function modificarProveedor($cve,$emp,$tel_s,$tel,$correo,$nom, $apa, $ama, $est){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModProveedor('$cve','$emp','$tel_s','$tel','$correo','$nom','$apa','$ama','$est');");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function contarProveedoresIna(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProveedor(2,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarProveedoresIna($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProveedor(4,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["EMPRESA"] =$resultado["EMPRESA"];
			    $datos[$reg]["CONTACTO"] =$resultado["CONTACTO"];	
			    $datos[$reg]["CORREO"] =$resultado["CORREO"];	
			    $datos[$reg]["CONTACTO_SUPERVISOR"] =$resultado["CONTACTO_SUPERVISOR"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function actProveedor($cve){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModProveedor($cve, '','','','','','','', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function mostrarUsuariosPdf(){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876750_efrain", "Translader22!", "id15876750_bd_prosoft") ){			
		   $consulta = mysqli_query($conn,"call spConsultarUsuarios(0,0,0);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];
                $datos[$reg]["USUARIO"] =$resultado["USUARIO"];
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["ROL"] =$resultado["ROL"];	
			    $datos[$reg]["PWD"] =$resultado["PWD"];
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];	
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function contarProductosIna(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProducto(2,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarProductosIna($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProducto(4,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["PRESENTACION"] =$resultado["PRESENTACION"];
			    $datos[$reg]["CANTIDAD"] =$resultado["CANTIDAD"];	
			    $datos[$reg]["CADUCIDAD"] =$resultado["CADUCIDAD"];	
			    $datos[$reg]["PRECIO_VENTA"] =$resultado["PRECIO_VENTA"];
			    $datos[$reg]["PRECIO_ADQUISICION"] =$resultado["PRECIO_ADQUISICION"];
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];
			    $datos[$reg]["SURTIDOR"] =$resultado["SURTIDOR"];
			    $datos[$reg]["EMPLEADO"] =$resultado["EMPLEADO"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function actProducto($cve){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModProducto('$cve',null,'','',null,null,null,null,null,'', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function consCategorias(){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spConsCategoria(0,0,0);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["Clave"]=$resultado["Clave"];				
			    $datos[$reg]["Categoria"] =$resultado["Categoria"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	// ------------------------------------------------CATEGORIAS--------------------------------------------
	public function DelCategorias($clave){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spDelCategoria('$clave');");	  			
		
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
			
									
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function contarCategorias(){
		$res=array();		
		
  		if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsCategoria(0,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarCategorias($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spConsCategoria(1,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["Clave"]=$resultado["Clave"];				
			    $datos[$reg]["Categoria"] =$resultado["Categoria"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function registrarCategoria($nombre){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spInsCategoria('$nombre');");	  			
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function filtrarCategoria($cve){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spTraCategoria('$cve');");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["NOMBRE"]=$resultado["NOMBRE"];				
			    $datos[$reg]["ESTADO"] =$resultado["ESTADO"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function modificarCategoria($cve,$nom){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModCategoria('$cve','$nom', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function contarCategoriasIna(){
		$res=array();		
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsCategoria(2,0,0);");	      			 
		   $res[0]=mysqli_num_rows($consulta);		  	  
		}
		mysqli_free_result($consulta);
		mysqli_close($conn); 			
		return $res;
	}
	public function consultarCategoriasIna($inicioPag,$numReg){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsCategoria(4,$inicioPag,$numReg);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["Clave"]=$resultado["Clave"];				
			    $datos[$reg]["Categoria"] =$resultado["Categoria"];					
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function actCategoria($cve,$nom){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModCategoria('$cve', '$nom', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	# ---------------------------------------------------PDF'S----------------------------------------------
    public function consultarProductosAlerta(){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spConsProducto(0,0,0);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["CLAVE"]=$resultado["CLAVE"];				
			    $datos[$reg]["NOMBRE"] =$resultado["NOMBRE"];					
			    $datos[$reg]["PRESENTACION"] =$resultado["PRESENTACION"];
			    $datos[$reg]["CANTIDAD"] =$resultado["CANTIDAD"];	
			    $datos[$reg]["CADUCIDAD"] =$resultado["CADUCIDAD"];	
			    $datos[$reg]["PRECIO_VENTA"] =$resultado["PRECIO_VENTA"];
			    $datos[$reg]["PRECIO_ADQUISICION"] =$resultado["PRECIO_ADQUISICION"];
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];
			    $datos[$reg]["SURTIDOR"] =$resultado["SURTIDOR"];
			    $datos[$reg]["EMPLEADO"] =$resultado["EMPLEADO"];
			    $datos[$reg]["ACTIVO"] =$resultado["ACTIVO"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	public function consultarProductosPDF($op){
		$datos=array();		
		$reg=0;
        if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		   $consulta = mysqli_query($conn,"call spReportesPDF('$op');");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
                $datos[$reg]["PRODUCTO"]=$resultado["PRODUCTO"];				
			    $datos[$reg]["PRESENTACION"] =$resultado["PRESENTACION"];
			    $datos[$reg]["CANTIDAD"] =$resultado["CANTIDAD"];	
			    $datos[$reg]["VENCIMIENTO"] =$resultado["VENCIMIENTO"];	
			    $datos[$reg]["PROVEEDOR"] =$resultado["PROVEEDOR"];
			    $datos[$reg]["PRECIO_ADQUISICION"] =$resultado["PRECIO_ADQUISICION"];
			    $datos[$reg]["FOTO"] =$resultado["FOTO"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
		return $datos;
	}
	// ------------------------------------------Administrar relaciones-----------------------------------
	public function productoMayor(){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
         if($id_row = mysqli_fetch_assoc(mysqli_query($conn,"CALL spUltProducto();")))
            $id[0]["ID"] = $id_row["id"];
      }
	   return $id;
	}
	public function registrarRelacion($prod, $cate, $ubic){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spInsRelacion('$prod', '$cate', '$ubic');");	  			
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
	public function consDatRel($cve){
		$datos=array();		
		$reg=0;
		
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){	
		   $consulta = mysqli_query($conn,"call spGetCategori($cve);");	      			 
		  	while($resultado = mysqli_fetch_assoc($consulta)){
               $datos[$reg]["CATEGORIA_P"]=$resultado["CATEGORIA_P"];				
			    $datos[$reg]["CATEGORIA_N"] =$resultado["CATEGORIA_N"];					
			    $datos[$reg]["UBICACION"] =$resultado["UBICACION"];
			   	$reg++;
			}		
				mysqli_close($conn); 
		}
				
		return $datos;
	}
	public function modificarCatRel($cve,$prod, $cate, $ubi){
	  $datos=array();  
      if($conn = mysqli_connect("localhost", "id15876757_gsw_user", "LPsv\wML_H^y{g0u", "id15876757_gswdatabase")){
		$renglon = mysqli_query($conn,"CALL spModRelacion('$cve','$prod', '$cate', '$ubi', 1);");
       	while($resultado = mysqli_fetch_assoc($renglon)){
                $datos[0]["ID"]=$resultado["ID"];		
			}		
        mysqli_close($conn); 
      } 
	   return $datos;
	}
}

?>