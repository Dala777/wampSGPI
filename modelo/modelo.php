<?php
class DB {
    // (A) CONNECT TO DATABASE
    public $error = "";
    private $pdo = null;
    private $stmt = null;
    function __construct () {
        $this->pdo = new PDO(
            "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=".DB_CHARSET,
            DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // (B) CLOSE CONNECTION
    function __destruct () {
        if ($this->stmt!==null) { $this->stmt = null; }
        if ($this->pdo!==null) { $this->pdo = null; }
    }

    // (C) RUN A SELECT QUERY
    function select ($sql, $data=null) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($data);
        return $this->stmt->fetchAll();
    }

    // (D) Method to execute insert, update, delete
    function execute($sql, $data=null) {
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($data);
    }

    // (E) Method to obtain users
    function obtenerUsuarios() {
        $sql = 'SELECT id_usuario AS id, nombre, email FROM USUARIOS';
        return $this->select($sql);
    }

    // (F) Public method to get PDO instance
    public function getPDO() {
        return $this->pdo;
    }


    public function actualizarProyecto($data) {
      $sql = "UPDATE proyectos_integradores SET 
          codigo_sis = ?, 
          nombre_proyecto = ?, 
          descripcion = ?, 
          palabras_clave = ?, 
          area_enfoque = ?, 
          integrador = ?, 
          estado = ?, 
          semestre = ?, 
          sede = ?, 
          documento_proyecto = ? 
          WHERE id_proyecto = ?";
    
      $stmt = $this->pdo->prepare($sql); // Cambiado a $this->pdo
      return $stmt->execute([
          $data['codigo_sis'], 
          $data['nombre_proyecto'], 
          $data['descripcion'], 
          $data['palabras_clave'], 
          $data['area_enfoque'], 
          $data['integrador'], 
          $data['estado'], 
          $data['semestre'], 
          $data['sede'], 
          $data['documento_proyecto'], 
          $data['id_proyecto']
      ]);
    }
    
    public function obtenerProyectoPorId($id_proyecto) {
      $sql = "SELECT * FROM proyectos_integradores WHERE id_proyecto = ?";
      $stmt = $this->pdo->prepare($sql); // Cambiado a $this->pdo
      $stmt->execute([$id_proyecto]);
      return $stmt->fetch(); // O fetchAll() si esperas múltiples resultados
    }
    

    // (G) Method to obtain projects
    function obtenerProyectos() {
        // Consulta SQL para seleccionar todos los proyectos integradores con los campos necesarios
        $sql = 'SELECT 
                    id_proyecto,
                    codigo_sis,
                    nombre_proyecto,
                    descripcion,
                    palabras_clave,
                    area_enfoque,
                    integrador,
                    estado,
                    semestre,
                    sede,
                    documento_proyecto
                FROM proyectos_integradores';
        return $this->select($sql);
    }

    function obtenerDatosReportes() {
        $sql = "SELECT datos, referencia, descripcion, integrador FROM reportes";
        return $this->select($sql); // Utiliza el método select de la clase DB para ejecutar la consulta
    }
    
    
}



// (H) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "sgpi");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_PORT", "3308");

// (I) NEW DATABASE OBJECT
$_DB = new DB();

?>
