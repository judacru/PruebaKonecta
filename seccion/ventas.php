<?php include("../template/cabecera.php")?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtProductoID=(isset($_POST['txtProductoID']))?$_POST['txtProductoID']:"";
$txtCantidad=(isset($_POST['txtCantidad']))?$_POST['txtCantidad']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtFecha=(isset($_POST['txtFecha']))?$_POST['txtFecha']:"";
$cantidadInsuficiente=false;



$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){
    case"Agregar":      
        $sentenciaSQL= $conexion->prepare("SELECT * FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtProductoID);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $precioProducto=$producto['precio'];
        $cantidadStock=$producto['stock'];

        if($cantidadStock >= $txtCantidad){
            $sentenciaSQL= $conexion->prepare("INSERT INTO ventas (productoID,cantidad,precio,fechaCreacion) VALUES (:productoID,:cantidad,:precio,CURDATE());");
            $sentenciaSQL->bindParam(':productoID',$txtProductoID);
            $sentenciaSQL->bindParam(':cantidad',$txtCantidad);
            $total= $precioProducto * $txtCantidad;
            $sentenciaSQL->bindParam(':precio',$total);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE productos SET stock=:stock WHERE id=:id");
            $stockActual=$cantidadStock - $txtCantidad;        
            $sentenciaSQL->bindParam(':stock',$stockActual);
            $sentenciaSQL->bindParam(':id',$txtProductoID);
            $sentenciaSQL->execute();
            header("Location:ventas.php");
            
        }else{
            $cantidadInsuficiente="No hay la cantidad suficiente en stock";
        };
        break;
    
    case"Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM ventas WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $venta=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtProductoID=$venta['productoID'];
        $txtCantidad=$venta['cantidad'];
        $txtPrecio=$venta['precio'];
        $txtFecha=$venta['fechaCreacion'];
        break;

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM ventas");
$sentenciaSQL->execute();
$listaVentas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaProductosSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaProductosSQL->execute();
$listaProductos=$sentenciaProductosSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="col-md-4">

    <div class="card">
        <?php if($cantidadInsuficiente!=false){?>
            <div class="alert alert-primary" role="alert">
               <?php echo $cantidadInsuficiente ?>
            </div>
        <?php } ?>

        <div class="card-header">        
            Datos de la venta
        </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                <div class = "form-group">
                <label for="txtID">ID:</label>
                <input type="text" required class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID"  placeholder="" readonly>
                </div>

                <div class = "form-group">
                <label for="txtProductoID">Producto:</label>
                <select required class="form-control" name="txtProductoID" id="txtProductoID"  placeholder="Producto" ><?php foreach($listaProductos as $producto) {?>
                    <option value="<?php echo $producto['ID'];?>">
                        <?php echo $producto['nombre'];?>
                        
                    </option>
                        <?php } ?>
                </select>
                
                </div>

                <div class = "form-group">
                <label for="txtCantidad">Cantidad:</label>
                <input type="text" required class="form-control" value="<?php echo $txtCantidad;?>" name="txtCantidad" id="txtCantidad"  placeholder="Ingrese la cantidad">
                </div>

                <div class = "form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" class="form-control" value="<?php echo ($txtPrecio);?>" name="txtPrecio" id="txtPrecio"  placeholder="" readonly>
                </div>

                <div class = "form-group">
                <label for="txtFecha">Fecha de creacion:</label>
                <input type="text" class="form-control" value="<?php echo $txtFecha;?>" name="txtFecha" id="txtFecha"  placeholder="" readonly>
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                </div>
                
                </form>
            </div>
        
    </div>
    
</div>

<div class="col-md-8">
    
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>ProductoID</th>
            <th>Cantidad</th>
            <th>Precio</th>           
            <th>Fecha de creacion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaVentas as $venta) {?>
        <tr>
            
            <td><?php echo $venta['ID'];?></td>
            <td><?php echo $venta['productoID'];?></td>
            <td><?php echo $venta['cantidad'];?></td>
            <td><?php echo $venta['precio'];?></td>            
            <td><?php echo $venta['fechaCreacion'];?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $venta['ID'];?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                </form>
            </td>

           

        </tr>
        <?php } ?>
    </tbody>
</table>

</div>
<?php include("../template/pie.php")?>