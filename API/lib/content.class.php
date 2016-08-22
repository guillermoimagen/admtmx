<?
/**
 * @class Content
 * @brief Clase que define las operaciones de manejo de contenidos.
 */
class Content extends API
{

/*! @publicsection */

	/**
	 * Constructor de la clase Usuarios, que invoca el constuctor de la clase API.
	 *
	 * @param request       Tipo de petición.
	 */
	public function __construct($args = null){
		parent::__construct($args);
	}

	/**
	  * Lee el feed de noticias.
	  *
	  * @return 			Objeto con noticias añadidas, o código de error encaso de ocurrir.
	  */
	public function listCountries(){
		if(is_null($this->db->conn)) return "02005";

		$sql = "
			SELECT
				pais.id AS pid,
				pais.nombrepais AS name 
			FROM pais 
			WHERE pais.activo = '1'
			ORDER BY ordenpais ASC, pais.nombrepais ASC
		";
		$query = $this->db->conn->query($sql);
		$data = array();
		while($row = $query->fetch_object()){
			$row->name = utf8_encode($row->name);
			$data[] = $row;
		}

		return $data;
	}

	/**
	  * Lee el feed de noticias.
	  *
	  * @return 			Objeto con noticias añadidas, o código de error encaso de ocurrir.
	  */
	public function listStates($pid){
		if(is_null($this->db->conn)) return "02005";
		if(!(is_numeric($pid) && $pid > 0)) return "01031";

		$pid = intval($this->db->conn->real_escape_string($pid));

		$sql = "
			SELECT
				estados.id AS sid,
				estados.nombreestado AS name 
			FROM estados 
			WHERE estados.activo = '1' AND estados.ipaisestado = " . $pid . "
			ORDER BY estados.nombreestado ASC
		";
		$query = $this->db->conn->query($sql);
		$data = array();
		while($row = $query->fetch_object()){
			$row->name = utf8_encode($row->name);
			$data[] = $row;
		}
		
		return $data;
	}
}