<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="icon" href="img/coffee.ico" />

    <title>Konecta</title>
    
  </head>
  <body>
    <?php  $url="http://".$_SERVER['HTTP_HOST']."/PruebaKonecta"?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="nav navbar-nav">
          <a class="nav-item nav-link active" href="#">Administrador </a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/index.php">Inicio</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/seccion/productos.php">Productos</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/seccion/ventas.php">Ventas</a>
          
      </div>
  </nav>
    <div class="container">
      <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron text-center" >
                    <h1 class="display-3">Bienvenido a la cafetería Konecta</h1>
                    <p class="lead">Vamos a administrar nuestros productos</p>
                    <hr class="my-2">
                    <img width="600" src="img/2621231.jpg" class="img-thumbnail rounded mx-auto d-block">
                
                
                        <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar</a>
                    </p>
                </div>


            </div>

<?php include('template/pie.php');?>
      