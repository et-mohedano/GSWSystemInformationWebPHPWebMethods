<main>
    <div class="row">
        <div class="col col-md-9 col-xs-8">
            <form class="row g-3 form-search" method="POST">
              <div class="col-auto">
                <label for="buscarProducto" class="col-form-label">Consultar producto:</label>
              </div>
              <div class="col-auto">
                <input type="text" name="txtProd" id="txtProd" class="form-control" id="buscarProducto" placeholder="Buscar...">
              </div>
              <div class="col-auto">
                <button type="submit" name="buscarProd" id="buscarProd" class="btn btn-outline mb-3 btn-sys">Enviar</button>
              </div>
            </form>
            <?php
                if(isset($_POST['buscarProd']) && $_POST['txtProd'] != ""){
                    $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
                    	   )	
                    	  );
                    $datosPag = $cliente->buscarProductos($_POST['txtProd']);
                    echo'
                    <div class="table-responsive table-report">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                      <th scope="col">Clave</th>
                                      <th scope="col">Producto</th>
                                      <th scope="col">Presentación</th>
                                      <th scope="col">Precio</th>
                                      <th scope="col">Foto</th>
                                      <th scope="col">Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    for($ren = 0; $ren < count($datosPag); $ren++){
                        echo'
                            <tr>
                              <th scope="row">'.$datosPag[$ren]["CLAVE"].'</th>
                              <td>'.$datosPag[$ren]["PRODUCTO"].'</td>
                              <td>'.$datosPag[$ren]["PRESENTACION"].'</td>
                              <td>'.$datosPag[$ren]["PRECIO"].'</td>
                              <td align="middle"><img src="'.$datosPag[$ren]["FOTO"].'" class="img-fluid logo-sys"/></td>
                              <td>'.$datosPag[$ren]["VENCIMIENTO"].'</td>
                            </tr>';
                    }
                    echo '
                        </tbody>
                              </table>
                            </div>';
                }else{
                    echo '<center><img src="paginas/imagenes/sistema/lupa.png" class="img-fluid logo-search" alt="Buscar..." title="Buscando"/><br><br><h2>Bienvenido -> Inicia una busqueda</h2></center>';
                }
                echo '</div>';
                require('sidebar.php');
            ?>
    </div>
</main>