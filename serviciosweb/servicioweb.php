<?php
    // Hacer el include de la clase con las reglas de negocio
    include 'clsservicios.php';
    // Usar el protocolo SOAP para crear el objeto que haga referencia al servicio
    $soap = new SoapServer(null, array('uri' => 'http://localhost/'));
    // Ejecutar la clase que tiene los métodos
    $soap->setClass('clsservicios');
    // Se ejecuta el manejador de clase
    $soap->handle();
?>