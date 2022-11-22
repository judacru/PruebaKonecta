
<?php include("../template/cabecera.php")?>
<?php 
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtReferencia=(isset($_POST['txtReferencia']))?$_POST['txtReferencia']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtPeso=(isset($_POST['txtPeso']))?$_POST['txtPeso']:"";
$txtCategoria=(isset($_POST['txtCategoria']))?$_POST['txtCategoria']:"";
$txtStock=(isset($_POST['txtStock']))?$_POST['txtStock']:"";
$txtFecha=(isset($_POST['txtFecha']))?$_POST['txtFecha']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$error=false;
$txtNombreMax=false;
$txtStockMax=false;
$cantidadVendida=false;
$nombreProducto=false;


include("../config/bd.php");
//PRODUCTO MAS VENDIDO
$sentenciaSQL= $conexion->prepare("SELECT P.ID, P.nombre, SUM(cantidad) AS cantidadVendida 
FROM Ventas V INNER JOIN  Productos P ON V.productoId = P.ID
GROUP BY P.ID, P.nombre 
ORDER BY cantidadVendida DESC LIMIT 1;");
$sentenciaSQL->execute();
$productoV=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
if($productoV){
    $nombreProducto=$productoV['nombre'];
    $cantidadVendida=$productoV['cantidadVendida'];
}


// MAX STOCK
$sentenciaSQL= $conexion->prepare("SELECT * FROM productos WHERE stock= (SELECT MAX(stock) AS stockMax FROM productos );");
$sentenciaSQL->execute();
$producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
if($producto){
    $txtIDMax=$producto['ID'];
    $txtNombreMax=$producto['nombre'];
    $txtStockMax=$producto['stock'];
}



switch($accion){
    case"Agregar":       
        $sentenciaSQL= $conexion->prepare("INSERT INTO productos (nombre,referencia,precio,peso,categoria,stock,fecha) VALUES (:nombre,:referencia,:precio,:peso,:categoria,:stock,CURDATE());");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':referencia',$txtReferencia);
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':peso',$txtPeso);
        $sentenciaSQL->bindParam(':categoria',$txtCategoria);
        $sentenciaSQL->bindParam(':stock',$txtStock);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;
        

    case"Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE productos SET nombre=:nombre,referencia=:referencia,precio=:precio,peso=:peso,categoria=:categoria,stock=:stock,fecha=:fecha WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':referencia',$txtReferencia);
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':peso',$txtPeso);
        $sentenciaSQL->bindParam(':categoria',$txtCategoria);
        $sentenciaSQL->bindParam(':stock',$txtStock);
        $sentenciaSQL->bindParam(':fecha',$txtFecha);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");

            break;
    case"Cancelar":
        header("Location:productos.php");
        break;
    case"Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$producto['nombre'];
        $txtReferencia=$producto['referencia'];
        $txtPrecio=$producto['precio'];
        $txtPeso=$producto['peso'];
        $txtCategoria=$producto['categoria'];
        $txtStock=$producto['stock'];
        $txtFecha=$producto['fecha'];
        break;
    


    case"Borrar":

        try {
            $sentenciaSQL= $conexion->prepare("DELETE FROM productos WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();        
            header("Location:productos.php");             
            break;            
        } catch (Exception $e) {
            $error= $e->getMessage();
        }
       

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-4">

    <div class="card">
        <?php if($error!=false){?>
            <div class="alert alert-primary" role="alert">
               <?php echo "Este producto no se puede borrar porque está asociado a una o más ventas" ?>
            </div>
        <?php } ?>
        <div class="card-header">
            Datos de producto
        </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                <div class = "form-group">
                <label for="txtID">ID:</label>
                <input type="text"  required class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID"  placeholder="" readonly>
                </div>

                <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre"  placeholder="Ingrese el nombre">
                </div>

                <div class = "form-group">
                <label for="txtReferencia">Referencia:</label>
                <input type="text" required class="form-control" value="<?php echo $txtReferencia;?>" name="txtReferencia" id="txtReferencia"  placeholder="Ingrese la referencia">
                </div>

                <div class = "form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" required class="form-control" value="<?php echo $txtPrecio;?>" name="txtPrecio" id="txtPrecio"  placeholder="Ingrese el precio">
                </div>

                <div class = "form-group">
                <label for="txtPeso">Peso:</label>
                <input type="text" required class="form-control" value="<?php echo $txtPeso;?>" name="txtPeso" id="txtPeso"  placeholder="Ingrese el peso">
                </div>

                <div class = "form-group">
                <label for="txtCategoria">Categoria:</label>
                <input type="text" required class="form-control" value="<?php echo $txtCategoria;?>" name="txtCategoria" id="txtCategoria"  placeholder="Ingrese la categoria">
                </div>

                <div class = "form-group">
                <label for="txtStock">Stock:</label>
                <input type="text" required class="form-control" value="<?php echo $txtStock;?>" name="txtStock" id="txtStock"  placeholder="Ingrese la cantidad">
                </div>

                <div class = "form-group">
                <label for="txtFecha">Fecha de creacion:</label>
                <input type="text" required class="form-control" value="<?php echo $txtFecha;?>" name="txtFecha" id="txtFecha"  placeholder="" readonly>
                </div>

               

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
                
                </form>
            </div>
        
    </div>
    
</div>
<div class="col-md-8">
<label for="exampleInputPassword1">El producto más vendido es <?php echo $nombreProducto .": ".$cantidadVendida?></label>
<br/>
<label for="exampleInputPassword1">El producto con más stock es <?php echo $txtNombreMax .": ".$txtStockMax?></label>
   <br/> 
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Referencia</th>
            <th>Precio</th>
            <th>Peso</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Fecha de creacion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaProductos as $producto) {?>
        <tr>
            <td><?php echo $producto['ID'];?></td>
            <td><?php echo $producto['nombre'];?></td>
            <td><?php echo $producto['referencia'];?></td>
            <td><?php echo $producto['precio'];?></td>
            <td><?php echo $producto['peso'];?></td>
            <td><?php echo $producto['categoria'];?></td>
            <td><?php echo $producto['stock'];?></td>
            <td><?php echo $producto['fecha'];?></td>

            <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['ID'];?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                </form>
            </td>

        </tr>
        <?php } ?>
    </tbody>
</table>

</div>

<?php include("../template/pie.php")?>