<?php
/**
 * @class DB
 * @brief Clase que define la configuración de la conexión a la base de datos.
 */
class DB
{
	const DB_HOST = 'dev-mysql.alcanciadigitalteleton.mx';
	const DB_USER = 'teletondev';
	const DB_PASS = 'KSue2Ue8gK';
	const DB_NAME = 'adtmx';

	public $conn = NULL; //!< Conexión a la base de datos.

	/**
	 * Constructor de la clase DB.
	 *
	 */
    public function __construct(){
    	$this->_connectDatabase();
    }

	public function _connectDatabase(){
		$this->_disconnectDatabase();
		$this->conn = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
		if($this->conn->connect_error){
			printf("Conexión fallida: %s\n", $this->conn->connect_error);
			return false;
		}
		return true;
	}

	public function _disconnectDatabase(){
		if(!is_null($this->conn)){
			$this->conn->close();
			$this->conn = null;
		}
		return true;
	}
}
?>