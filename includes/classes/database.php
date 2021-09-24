<?php class Database{
  private static $_mysqlUser='root';
  private static $_mysqlPwd='';
  private static $_mysqlDb  ='caso_estudio';
  private static $_hostName ='localhost';
  // para patrón Singleton 
  private static $_connection=NULL;          

  // Constructor Singleton (para clase no instanciable)
  private function __construct() {}

  // Obtiene conexión SINGLETON
  public static function getConnection() {
    if (!self::$_connection){
      self::$_connection = new mysqli(
        self::$_hostName, 
        self::$_mysqlUser,
        self::$_mysqlPwd,
        self::$_mysqlDb
      );
      if (self::$_connection->connect_error) {
        die('Error de conexión: ' . self::$_connection->connect_error); 
      }
    }
    return self::$_connection; 
  }

  public static function escape($humanInput){
    $humanInput = self::$_connection->real_escape_string($humanInput);
    return $humanInput;	
  }
}	?>