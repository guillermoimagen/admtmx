<?php
/**
 * @class Files
 * @brief Clase que define métodos principales para el tratamiendo de archivos para el CMS.
 */
final class IC_Files
{
	public static function makeDirectory($folder){
		if(!file_exists($folder)){
			mkdir($folder, 0777, true);
		}
	}

	public static function getPathOfContent($tid, $rid, $path = "../"){
		$db = new DB();
		$sql = "SELECT ayudatabla AS name, campotabla AS field FROM catablas WHERE idtabla = " . $tid . "";
		$query = $db->conn->query($sql);
		if($query->num_rows == 0){
			$db->_disconnectDatabase();
			return false;
		}
		$data = $query->fetch_object();
		IC_Files::makeDirectory($path . "recursos/" . $data->name);

		$sql = "SELECT " . $data->field . " AS title FROM " . $data->name . " WHERE id = " . $rid . " ";
		$queryx = $db->conn->query($sql);
		if($query->num_rows == 0){
			$db->_disconnectDatabase();
			return false;
		}
		$datax = $queryx->fetch_object();
		$folder = IC_Image::formatLink($datax->title);
		IC_Files::makeDirectory($path . "recursos/" . $data->name . "/" . $folder);
		IC_Files::makeDirectory($path . "recursos/" . $data->name . "/" . $folder . "/fotos");
		IC_Files::makeDirectory($path . "recursos/" . $data->name . "/" . $folder . "/fotos/stock");
		IC_Files::makeDirectory($path . "recursos/" . $data->name . "/" . $folder . "/archivos");

		$db->_disconnectDatabase();
		return $data->name . '/' . $folder . '/';
	}

	public static function getNameOfCategory($cid){
		$data = array(
			1 => "fotos",
			2 => "archivos"
		);
		return (isset($data[$cid])) ? $data[$cid] : false;
	}

	public static function getFilesOfCategory($cid){
		$data = array(
			1 => array(".jpg", ".png", ".gif"),
			2 => array(".doc", ".docx", ".pdf")
		);
		return (isset($data[$cid])) ? $data[$cid] : false;
	}

	public static function getFilesOfContent($tid, $rid, $cid, $path = "../"){
		$db = new DB();
		$sql = "
			SELECT
				fotos.id AS fid,
				fotos.titulofoto AS title,
				fotos.descripcionfoto AS description,
				fotos.archivofoto AS file,
				fotos.ordenfoto AS 'order',
				fotos.activo AS active
			FROM fotos
			WHERE itablafoto = " . $tid . " AND registrofoto = " . $rid . " AND icfotofoto = " . $cid . "
			ORDER BY ordenfoto ASC
		";
		$query = $db->conn->query($sql);
		$data = array();
		while($row = $query->fetch_object()){
			$regex = '/^(.*\/)?(.*)\.(jpg|png|jpeg|gif|doc|docx|pdf)$/i';
			$temp = null;
			preg_match($regex, $row->file, $temp);
			$row->name = $temp[2] . "." . $temp[3];
			if($temp[3] == "jpg" || $temp[3] == "png" || $temp[3] == "jpeg" || $temp[3] == "gif"){
				$row->thumbnail = $path . "recursos/" . $row->file;
				$row->file = $temp[1] . "stock/" . $temp[2] . "_movHNormal." . $temp[3];
			}else if($temp[3] == "doc" || $temp[3] == "docx")
				$row->thumbnail = $path . "recursos/ico_doc.png";
			else if($temp[3] == "pdf")
				$row->thumbnail = $path . "recursos/ico_pdf.png";
			$row->size = filesize($path . "recursos/" . $row->file);
			if(is_null($row->title)) $row->title = "";
			if(is_null($row->description)) $row->description = "";
			$data[$row->fid] = $row;
			unset($data[$row->fid]->fid);
		}
		$db->_disconnectDatabase();
		return $data;
	}

	public static function uploadFile($folder, $tid, $rid, $cid, $file, $path = "../"){
		if(empty($file))
			return false;
		$sizes = explode(',', '400,120,800,240');
		$db = new DB();
		$regex = '/^(.*)\.(jpg|png|jepg|gif|doc|docx|pdf)$/i';
		$temp = null;
		preg_match($regex, $file['name'], $temp);
		$name = $temp[1];
		$temp[1] = IC_Image::formatLink($temp[1]);
		$sql = "
			INSERT INTO fotos SET
				itablafoto = " . $tid . ",
				registrofoto = " . $rid . ",
				icfotofoto = " . $cid . ",
				fechafoto = DATE_FORMAT(NOW(), '%Y-%m-%d'),
				titulofoto = '" . $name . "',
				archivofoto = '" . $folder . IC_Files::getNameOfCategory($cid) . "/" . $temp[1] . "." . $temp[2] . "'
		";
		if(!$db->conn->query($sql)){
			$db->_disconnectDatabase();
			return false;
		}
		if($cid == 1){
			IC_Image::resizeImage($file, $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/", $temp[1] . "." . $temp[2], 100, 100, 60);
			IC_Image::resizeImage($file, $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/stock/", $temp[1] . "_movLNormal." . $temp[2], $sizes[0], $sizes[0], 100);
			IC_Image::resizeImage($file, $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/stock/", $temp[1] . "_movLM." . $temp[2], $sizes[1], $sizes[1], 100);
			IC_Image::resizeImage($file, $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/stock/", $temp[1] . "_movHNormal." . $temp[2], $sizes[2], $sizes[2], 100);
			IC_Image::resizeImage($file, $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/stock/", $temp[1] . "_movHMini." . $temp[2], $sizes[3], $sizes[3], 100);
		}else{
			move_uploaded_file($file['tmp_name'], $path . "recursos/" . $folder . IC_Files::getNameOfCategory($cid) . "/" . $temp[1] . "." . $temp[2]);
		}
		return true;
	}

	public static function updateFile($fid, $title, $description, $order, $active){
		$db = new DB();
		$sql = "
			UPDATE fotos SET
				titulofoto = '" . $title . "',
				descripcionfoto = '" . $description . "',
				ordenfoto = " . $order . ",
				activo = '" . (($active) ? '1' : '0') . "'
			WHERE
				id = " . $fid . "
			LIMIT 1
		";
		if(!$db->conn->query($sql))
			return false;
		return true;
	}

	public static function deleteFile($fid, $path = "../"){
		$db = new DB();
		$sql = "
			SELECT
				fotos.id AS fid,
				fotos.archivofoto AS file,
				fotos.icfotofoto AS cid
			FROM fotos
			WHERE fotos.id = " . $fid . "
		";
		$query = $db->conn->query($sql);
		if($query->num_rows == 0){
			$db->_disconnectDatabase();
			return false;
		}
		$data = $query->fetch_object();

		$sql = "DELETE FROM fotos WHERE id = " . $fid . " LIMIT 1";
		if(!$db->conn->query($sql)){
			$db->_disconnectDatabase();
			return false;
		}
		unlink($path . "recursos/" . $data->file);
		if(intval($data->cid) == 1){
			$regex = '/^(.*\/)?(.*)\.(jpg|png|jepg|gif)$/i';
			$temp = null;
			preg_match($regex, $data->file, $temp);
			unlink($path . "recursos/" . $temp[1] . "stock/" . $temp[2] . "_movLNormal." . $temp[3]);
			unlink($path . "recursos/" . $temp[1] . "stock/" . $temp[2] . "_movLM." . $temp[3]);
			unlink($path . "recursos/" . $temp[1] . "stock/" . $temp[2] . "_movHNormal." . $temp[3]);
			unlink($path . "recursos/" . $temp[1] . "stock/" . $temp[2] . "_movHMini." . $temp[3]);
		}
		$db->_disconnectDatabase();
		return true;
	}
}
?>