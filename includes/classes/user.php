<?php class User {
  protected $id; 
  protected $name;
  protected $pwd;

  public function __construct($input=false) {
    if(is_array($input)) {
      foreach($input as $key=>$value) {
        $this->$key=$value;
      }
    }
  }

  private static function checkUserData($userName, $userPwd, $userId = NULL) {
    if (!trim($userName) || !trim($userPwd) || 
      ($userId === NULL )?FALSE:!trim($userId)
    ){
      throw new Exception('Datos de usuario incorrectos.');        
    };
  }	

  public function get($property){
    return $this->$property;
  }
  
  private static function throwQuery($query){
    $connection = Database::getConnection();
    $result = $connection->query($query);
    if(!$result){
      throw new Exception(mysqli_error($connection));
    }
    return $result;
  }

  // public static function encrypt($rawPwd){
  //   self::throwQuery("SELECT PASSWORD('xyz'); ");
  // }

  public static function getAllUsers() {
    $selection = self::throwQuery("SELECT * FROM users");
    $users = [];
    while($fetchResult = $selection->fetch_object('User')) {
      // PUSH
      $users[] = $fetchResult;
    }
    return $users;
  }

  public function deleteUser(){
    return self::throwQuery("DELETE FROM users WHERE id = $this->id");
  }

  static public function deleteUsers($ids){
    return self::throwQuery("DELETE FROM users WHERE id IN ($ids)");
    //return "DELETE FROM users WHERE id IN ($ids)";
  }

  public function updateUser(){
    self::checkUserData($this->name, $this->pwd, $this->id);
    return self::throwQuery("UPDATE users 
      SET name='$this->name', pwd='$this->pwd' 
      WHERE id='$this->id'
    ")?'Usuario actualizado correctamente'
    :'imposible actualizar usuario!';
  }
  
  public function addUser() {
    self::checkUserData($this->name, $this->pwd);
    return self::throwQuery("INSERT INTO users(name, pwd) VALUES ('$this->name', '$this->pwd')");
    //return "INSERT INTO users(name, pwd) VALUES ('$this->name', '$this->pwd')";
  }
} ?>