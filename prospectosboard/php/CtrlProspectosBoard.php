<?php 
class CtrlProspectosBoard extends Profile
{
	#public $modelProspectos;
	public $layout;
	public $viewDirectory;
	public $dataProfile;
	function __construct($idProfile)
	{
		parent::__construct($idProfile);
		$this->dataProfile = array(
			'idProfile' => $this->idprofile,
			'myCenter' => $this->mycenter
		);
		$this->layout = 'layout1';
		$this->viewDirectory = 'apps/prospectosboard/html';
	}
	public function ptmin($keys, $template) {
        return $this->print_template($keys, file_get_contents($this->viewDirectory . "/" . $this->layout . "/" . $template.'.html'));
    }
    public function getIndexProspectosBoard()
    {
    	$keys = array(
    		'DATA' => $this->printProspectoByEtapa()
    	);
    	return $this->ptmin($keys,'index');
    }
    public function printProspectoByEtapa()
    {
		$modelProspectos = new ProspectosModel($this->dataProfile);
		$modelEtapas = new EtapasModel($this->dataProfile);
		$etapas = $modelEtapas->getEtapas();
		$totalEtapas = sizeof($etapas);
		$html = '';
		$with = 100 / $totalEtapas;
		$sumRango1 = 0;
		$sumRango2 = 0;
		for ($i=0; $i < $totalEtapas; $i++) { 
			$prospectos = $modelProspectos->getProspectosByEtapas($etapas[$i]['id']);
			$totalProspectos = sizeof($prospectos);
			$htmlItems = '';
			for ($x=0; $x < $totalProspectos; $x++) {
				$prospectoInfo = array(
					'NAMEPROSPECTO' => $prospectos[$x]['name'],
					'PRESUPUESTO' => $prospectos[$x]['rango1'] . '-' . $prospectos[$x]['rango2'],
					'PHONE' => $prospectos[$x]['phone'],
					'MAIL' => $prospectos[$x]['email'],
				);
				$htmlItems .= $this->ptmin($prospectoInfo,'item_prospecto');
				$sumRango1 += (int)$prospectos[$x]['rango1'];
				$sumRango2 += (int)$prospectos[$x]['rango2'];
			}
			$nameEtapa = ($i == 0) ? 'Sin etapa' : $etapas[$i]['name'] . ' ' . $etapas[$i]['porcentaje'] . ' %' ;
			$prospectosItems = array(
				'ITEMSPROSPECTOS' =>  $htmlItems,
				'WIDTH' => $with.'%',
				'ETAPA' => $nameEtapa,
				'TOTALPROSPECTOS' => $totalProspectos,
				'SUMRANGO1' => $sumRango1,
				'SUMRANGO2' => $sumRango2,
			);
			$html .= $this->ptmin($prospectosItems,'col_list');
		}
		//echo $html;
		return $html;
    }
 }
?>