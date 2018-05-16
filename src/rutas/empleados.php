<?php
// hacer las peticiones
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/************************Esto es para la cabecera de Bienvenida*****************************/
// creamos un objeto. Indicamos donde vamos a meterlo
$app = new \Slim\App;
// lo que obtenemos. La clase es app
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Página de gestión de API REST de la aplicación de Merce");

    return $response; // devuelve las respuestas
});
/******************************************************************************************/

$app->get('/api/empleados', function(Request $request, Response $response){

    // obtener información de todos los empleados
    $consulta = 'SELECT * FROM empleados';

    try{
        //instanciamos la base de datos
        $db = new db();

        //conexion.Llamamos al método conectar situado en db.php
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $empleados = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        // Exportar en formato json. Llamamos a la variable $empleados que es donde está guardada la consulta
        echo json_encode($empleados);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

 });
/*************************************/
$app->get('/api/empleado/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    // obtener información de un empleado en concreto
    $consulta = "SELECT * FROM empleados WHERE id='$id'";

    try{
        //instanciamos la base de datos
        $db = new db();

        //conexion.Llamamos al método conectar situado en db.php
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $empleado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        // Exportar en formato json. Llamamos a la variable $empleados que es donde está guardada la consulta
        echo json_encode($empleado);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

 });

/********************************************/
/*para agregar un empleado.POST*/
$app->post('/api/crear', function(Request $request, Response $response){

   $id = $request->getParam('id');
   $nombre = $request->getParam('nombre');
   $direccion = $request->getParam('direccion');
   $telefono = $request->getParam('telefono');

    // agregar empleado
    $consulta = "INSERT INTO empleados (id, nombre, direccion, telefono) VALUES (:id, :nombre, :direccion, :telefono)";

    try{
        //instanciamos la base de datos
        $db = new db();

        //conexion.Llamamos al método conectar situado en db.php
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute(); // para ejecutar el inserto en la base de datos
        //echo '{"comprobación": {"text": "El empleado ha sido agregado correctamente"}';

       }catch(PDOException $e){
        //echo '{"error": {"text": '.$e->getMessage().'}';
        echo "El id del empleado ya existe";
    }

 });
/***************************************/
/*para actualizar empleados.PUT. Con post también deja*/
$app->put('/api/actualizar/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

   $nombre = $request->getParam('nombre');
   $direccion = $request->getParam('direccion');
   $telefono = $request->getParam('telefono');

    // actualizar empleado
    $consulta = "UPDATE empleados SET id = :id,
                                nombre = :nombre,
                                direccion = :direccion,
                                telefono = :telefono
                                WHERE id = $id";

    try{
        //instanciamos la base de datos
        $db = new db();

        //conexion.Llamamos al método conectar situado en db.php
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute(); // para ejecutar la actualización en la base de datos
        //echo '{"comprobación": {"text": "El empleado ha sido actualizo con éxito"}';

          }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

    }

 });

/**************************************/
/*eliminar un empleado.DELETE. Con get también funciona*/
$app->delete('/api/eliminar/{id}', function(Request $request, Response $response){
      $id = $request->getAttribute('id');
//echo $id;
    // borrar empleado
    $consulta = "DELETE FROM empleados
       WHERE id = '$id'";

    try{
        //instanciamos la base de datos
        $db = new db();

        //conexion.Llamamos al método conectar situado en db.php
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->execute(); // para ejecutar el borrado en la base de datos
        $db = null;
        //echo '{"comprobación": {"text": "El empleado ha sido borrado con éxito"}';

          }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

 });





?>
