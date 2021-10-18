<?php
    session_start();
    if(isset($_GET['salir'])){
        session_destroy();
        echo "si";
       echo "<script language='javascript'>document.location.href = 'inicio.php';</script>";
    }
    if(isset($_GET['buscarProd'])){
        $_GET['op'] = 'consultar_productos';
    }
    $pagina = isset($_GET['op']) ? strtolower($_GET['op']) : 'login';
    if ($pagina == 'login'){
        require_once 'paginas/header-login.php';
    }else{
        require_once 'paginas/header.php';
    }
    require_once 'paginas/'.$pagina.'.php';
    require_once 'paginas/footer.php';
    
?>