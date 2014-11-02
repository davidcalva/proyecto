<?php 
/**
* 
*/
class EtapasModel extends ModelBase
{
	public $idProfile;
	public $myCenter;
	public $idEntityProspecto;
	function __construct($dataProfile)
	{
		parent::__construct();
		$this->idProfile = $dataProfile['idProfile'];
		$this->myCenter = $dataProfile['myCenter'];
	}
	public function getEtapas()
    {
    	$params = array(
    		'idcenter' => $this->myCenter
    	);
    	$query = 'SELECT id,name,porcentaje FROM prospectos_etapas WHERE idcenter = :idcenter ORDER BY posicion';
    	$etapas = $this->select($query,$params);
    	return $etapas;
    }
}
?>