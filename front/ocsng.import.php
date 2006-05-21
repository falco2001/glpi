<?php
/*
 * @version $Id$
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2006 by the INDEPNET Development Team.
 
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------

 LICENSE

	This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
*/

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

include ("_relpos.php");
$NEEDED_ITEMS=array("ocsng","computer","device","printer","networking","peripheral","monitor","software","infocom","phone","state","tracking","enterprise");
include ($phproot . "/inc/includes.php");

checkRight("ocsng","w");

commonHeader($lang["title"][39],$_SERVER["PHP_SELF"]);

if (isset($_SESSION["ocs_import"])){
	if ($count=count($_SESSION["ocs_import"])){
		$percent=min(100,round(100*($_SESSION["ocs_import_count"]-$count)/$_SESSION["ocs_import_count"],0));
		
  		displayProgressBar(400,$percent);

		$key=array_pop($_SESSION["ocs_import"]);
		ocsImportComputer($key);
		glpi_header($_SERVER['PHP_SELF']);
	} else {
		unset($_SESSION["ocs_import"]);

		displayProgressBar(400,100);

		echo "<div align='center'><strong>".$lang["ocsng"][8]."<br>";
		echo "<a href='".$_SERVER['PHP_SELF']."'>".$lang["buttons"][13]."</a>";
		echo "</strong></div>";
	}
}

if (!isset($_POST["import_ok"])){
if (!isset($_GET['check'])) $_GET['check']='all';
if (!isset($_GET['start'])) $_GET['start']=0;

if (isset($_SESSION["ocs_import"])) unset($_SESSION["ocs_import"]);
ocsManageDeleted();
ocsCleanLinks();
ocsShowNewComputer($_GET['check'],$_GET['start']);

} else {
	if (count($_POST['toimport'])>0){
		$_SESSION["ocs_import_count"]=0;
		foreach ($_POST['toimport'] as $key => $val){
			if ($val=="on")	{
				$_SESSION["ocs_import"][]=$key;
				$_SESSION["ocs_import_count"]++;
			}
		}
	}
	glpi_header($_SERVER['PHP_SELF']);
}


commonFooter();

?>
