<?php  
include(APP_DIR . "/profile/php/profile_model.php");
include(APP_DIR . "/prospectosboard/php/ModelBase.php");
include(APP_DIR . "/prospectosboard/php/CtrlProspectosBoard.php");
include(APP_DIR . "/prospectosboard/php/ProspectosModel.php");
include(APP_DIR . "/prospectosboard/php/EtapasModel.php");

$ctrlProspectosBoard= new CtrlProspectosBoard($idprofile);
if (!isset($_REQUEST['view'])) {
	switch ($action) {
        case "default":
            $html = $ctrlProspectosBoard->getIndexProspectosBoard($_REQUEST);
            break;
    }
} else {
    switch ($_REQUEST['view']) {
        case 'report':
            $html = $ctrlProspectosBoard->prospectReport();
            break;
    }
}

?>
