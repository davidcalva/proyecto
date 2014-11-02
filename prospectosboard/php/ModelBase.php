<?php
abstract class ModelBase
{
    private $_db;
    protected $table;
    private $_debug = 1;
    public function __construct() {
    }
    /**
    *Funcion que recibe un sql y devuelve un arreglo, solo para selects
    */
    public function select($query,$params = array()){
        try {
            $this->_db = new PDO('mysql:host='.SRVDBHOST.';dbname='.SRVDBWEB.';charset=utf8', SRVDBUSER, SRVDBPASS);
    		$result = $this->_db->prepare($query);
            if(!empty($params)){
                foreach ($params as $key => &$value) {
                    $result ->bindParam(":".$key,$value);
                }
            }
	        $result ->execute();
            $errors = $result->errorInfo();
            if (!empty($errors[2]) && $this->_debug == 1) {
                echo "<pre>";
                print_r($errors);
                echo "</pre>";
            }
            $arr = $result->fetchAll(PDO::FETCH_ASSOC);
            $this->_db = null;
	        return $arr;
	        #return $query;
    	}catch (PDOException $e) {
            $this->_db = null;
    		return $e->getMessage();
    	}
    }
    /**
    *insertar 
    *Funcion que recibe un arreglo asociativo con los paramentros que se actualizaran
    *las keys del arreglo son los nombres de la columnas y el valor, es el valor que se actualizara
    *regresa 0 si todo ok , cualquier otro valor se considera como error
    */
    public function update($arr,$valor,$where="id"){
    	try{
            $this->_db = new PDO('mysql:host='.SRVDBHOST.';dbname='.SRVDBWEB.';charset=utf8', SRVDBUSER, SRVDBPASS);
    		$params = "";
    		foreach ($arr as $key => $value) {
    			$params .= $key."= :" . $key . ",";
    		}
    		$params = substr($params,0,-1);
    		$params .= " where " . $where . " = :valordonotrepeat123456789";
			$query = "UPDATE " . $this->table . " SET " . $params;
			$statement = $this->_db->prepare($query);
			foreach ($arr as $key => &$value) {
				$statement->bindParam(":".$key,$value);
			}
			$statement->bindParam(':valordonotrepeat123456789',$valor);
			$statement->execute();
            if (!empty($errors[2]) && $this->_debug == 1) {
                echo "<pre>";
                print_r($errors);
                echo "</pre>";
            }
            $this->_db = null;
			if($statement){
                $resp = 0;
				return $resp; 
			}else{
                $resp = 1;
				return $resp;
			}
		}catch(PDOException $e){
            $this->_db = null;
			return $e->getMessage();
		}
    }
    public function delete($valor,$where){
    	try{
            $this->_db = new PDO('mysql:host='.SRVDBHOST.';dbname='.SRVDBWEB.';charset=utf8', SRVDBUSER, SRVDBPASS);
			$query = "DELETE FROM " . $this->table . " WHERE " . $where . "= :valor";
			$statement = $this->_db->prepare($query);
			
			$statement->bindParam(':valor',$this->getText($valor));
			$statement->execute();
            if (!empty($errors[2]) && $this->_debug == 1) {
                echo "<pre>";
                print_r($errors);
                echo "</pre>";
            }
            $this->_db = null;
			if($result){
				return 0; 
			}else{
				return 1;
			}
		}catch(PDOException $e){
            $this->_db = null;
			return $e->getMessage();
		}
    }
   
}
?>