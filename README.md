# Prueba Konecta

## Instalación

Para ejecutarse localmente, debe modificar el archivo bd.php con las siguientes variables:
```
$host="localhost";
$db="konecta";
$usuario="";
$contrasenia="";
```

* Instalar Xampp

* Pegar la carpeta del proyecto en la carpeta htdocs que se encuentra en la siguiente dirección: C:\xampp\htdocs.

* Ejecutar los queries en phpmyadmin

* Pegar la siguiente dirección en Google Chrome: http://localhost/cafeteria/

## Base de datos

El ejemplo de los scripts de la base de datos:

```sql
CREATE SCHEMA konecta ;

CREATE TABLE konecta.productos (
  ID INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NULL,
  referencia VARCHAR(255) NULL,
  precio INT NULL,
  peso INT NULL,
  categoria VARCHAR(255) NULL,
  stock INT NULL,
  fecha DATE NULL,
  PRIMARY KEY (ID)
);


CREATE TABLE konecta.ventas (
  ID INT NOT NULL AUTO_INCREMENT,
  productoID INT NULL,
  cantidad INT NULL,
  precio INT NULL,
  fechaCreacion DATE NULL,
  PRIMARY KEY (ID),
  CONSTRAINT FK_productoVenta FOREIGN KEY (productoID)
    REFERENCES productos (ID)
);
```

Consultas:

```sql
// Producto con mayor stock
SELECT * FROM productos
WHERE stock = (SELECT MAX(stock) AS stockMax FROM productos );

// Producto más vendido
SELECT P.ID, P.nombre, SUM(cantidad) AS cantidadVendida 
FROM Ventas V INNER JOIN  Productos P ON V.productoId = P.ID
GROUP BY P.ID, P.nombre 
ORDER BY cantidadVendida DESC LIMIT 1;
```