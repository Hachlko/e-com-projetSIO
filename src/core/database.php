<?php

class Database
{
  private $PDOInstance = null;

  private static $instance = null;

  private function __construct()
  {
    $string = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
    $this->PDOInstance  = new PDO($string, DB_USER, DB_PASS);
  }

  /**
   * Crée et retourne l'objet SPDO
   * @return SPDO $instance
   */
  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  /**
   * read
   * lis la BDD
   * @return array
   */
  public function read($query, $data = array())
  {
    $statement = $this->PDOInstance->prepare($query);
    $result = $statement->execute($data);
    
    if ($result) {
      $data = $statement->fetchAll(PDO::FETCH_OBJ);
      if (is_array($data) && count($data) > 0) {
        return $data;
      }
    }
    return false;
  }

  /**
   * write
   * écris dans la BDD
   * @return bool
   */
  public function write($query, $data = array())
  {
    $statement = $this->PDOInstance->prepare($query);
    $result = $statement->execute($data);
    var_dump($result);
    if ($result) {
      return true;
    }
    return false;
  }

  /**
   * getLastInsertId
   * retourne le dernier id enregistrer
   * @return void
   */
  public function getLastInsertId()
  {
    return $this->PDOInstance->lastInsertId();
  }
}
