<?php 
/**
* 
*/
class ProspectosModel extends ModelBase
{
	public $idProfile;
	public $myCenter;
	public $idEntityProspecto;
	function __construct($dataProfile)
	{
		parent::__construct();
		$this->idProfile = $dataProfile['idProfile'];
		$this->myCenter = $dataProfile['myCenter'];
		$entity = $this->select("SELECT entity_id FROM entitys WHERE idprofile = :idcenter AND flag = 'Prospecto'", array('idcenter' => $this->myCenter));
		$this->idEntityProspecto = $entity[0]['entity_id'];
	}
	public function getProspectosByEtapas($idEtapa)
    {
    	$params = array(
    		'idcenter' => $this->myCenter,
    		'entityId' => $this->idEntityProspecto,
    		'idetapa' => $idEtapa
    	);
    	$query = 'SELECT p.idprofile,p.name,p.phone,p.email,pp.flag,pi.rango1,pi.rango2 FROM profiles p 
    			  INNER JOIN profiles_profiles pp ON pp.idprofile1 = :idcenter AND p.idprofile = pp.idprofile2 AND pp.entity = :entityId
    			  INNER JOIN prospectos_info pi ON pi.idprospecto =	p.idprofile 
    			  WHERE pi.idetapa = :idetapa';
    	$prospectos = $this->select($query,$params);
    	return $prospectos;
    }
}
?>