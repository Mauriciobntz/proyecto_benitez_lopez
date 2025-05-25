<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'bd_benitez_lopez';
$username = 'root';
$password = '';

try {
    // Intentar conexión
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    echo "¡Conexión exitosa a la base de datos!<br>";
    echo "Base de datos: " . $dbname . "<br>";
    echo "Host: " . $host . "<br>";
    echo "Usuario: " . $username . "<br><br>";

    // 1. Insertar un usuario
    $random_suffix = bin2hex(random_bytes(3));
    $email = 'test' . $random_suffix . '@example.com';
    $password_hash = password_hash('clave123', PASSWORD_DEFAULT);
    
    $sql_usuario = "INSERT INTO usuarios (email, contraseña_hash, rol, verificado) 
                   VALUES ('$email', '$password_hash', 'cliente', 1)";
    
    if ($conn->query($sql_usuario)) {
        $usuario_id = $conn->insert_id;
        echo "✅ Usuario insertado correctamente<br>";
        echo "ID: $usuario_id<br>";
        echo "Email: $email<br><br>";
    } else {
        throw new Exception("Error al insertar usuario: " . $conn->error);
    }
    
    // 2. Insertar datos de persona asociada
    $sql_persona = "INSERT INTO personas (usuario_id, tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, telefono)
                   VALUES ($usuario_id, 'DNI', '12345678A', 'Juan', 'Pérez', '1990-01-01', 'H', '600123456')";
    
    if ($conn->query($sql_persona)) {
        $persona_id = $conn->insert_id;
        echo "✅ Persona insertada correctamente<br>";
        echo "ID: $persona_id<br>";
        echo "Nombre: Juan Pérez<br><br>";
    } else {
        throw new Exception("Error al insertar persona: " . $conn->error);
    }
    
    // 3. Insertar una categoría
    $sql_categoria = "INSERT INTO categorias (nombre, descripcion) 
                     VALUES ('Electrónica', 'Productos electrónicos y dispositivos')";
    
    if ($conn->query($sql_categoria)) {
        $categoria_id = $conn->insert_id;
        echo "✅ Categoría insertada correctamente<br>";
        echo "ID: $categoria_id<br>";
        echo "Nombre: Electrónica<br><br>";
    } else {
        throw new Exception("Error al insertar categoría: " . $conn->error);
    }
    
    // 4. Insertar un producto
    $sql_producto = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, marca, modelo)
                    VALUES ('Smartphone X', 'Último modelo con 128GB de almacenamiento', 599.99, 50, $categoria_id, 'MarcaEjemplo', 'Modelo2025')";
    
    if ($conn->query($sql_producto)) {
        $producto_id = $conn->insert_id;
        echo "✅ Producto insertado correctamente<br>";
        echo "ID: $producto_id<br>";
        echo "Nombre: Smartphone X<br>";
        echo "Precio: 599.99€<br><br>";
    } else {
        throw new Exception("Error al insertar producto: " . $conn->error);
    }

    // 5. Insertar dirección
    $sql_direccion = "INSERT INTO direcciones (usuario_id, tipo, alias, direccion, codigo_postal, ciudad, provincia, pais, es_principal)
                     VALUES ($usuario_id, 'particular', 'Casa', 'Calle Principal 123', '28001', 'Madrid', 'Madrid', 'España', 1)";
    
    if ($conn->query($sql_direccion)) {
        $direccion_id = $conn->insert_id;
        echo "✅ Dirección insertada correctamente<br>";
        echo "ID: $direccion_id<br>";
        echo "Alias: Casa<br><br>";
    } else {
        throw new Exception("Error al insertar dirección: " . $conn->error);
    }

    // Cerrar conexión
    $conn->close();

} catch (Exception $e) {
    echo "<strong>Error:</strong> " . $e->getMessage();
}
?>