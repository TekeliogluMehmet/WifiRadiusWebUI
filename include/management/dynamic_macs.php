<?php

include('../../library/checklogin.php');
include('pages_common.php');

/*
 * delMacs removes an instance of a select box item for a group
 */
if(isset($_GET['delMacs'])) {

	if (isset($_GET['divContainerMacs']))
		$divContainer2 = $_GET['divContainerMacs'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];


        printqn("
                var divContainer2 = document.getElementById('$divContainer2');
		var childMac = document.getElementById('divContainerMacs$divCounter');
		divContainer2.removeChild(childMac);
	");
}



/*
 * getMacs creates a new select item for adding macs along with a Del link to delete
 * the added item
 */
if(isset($_GET['getMacs'])) {

	if (isset($_GET['divContainerMacs']))
		$divContainer = $_GET['divContainerMacs'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];

	if (isset($_GET['elemName']))
		$elemName = $_GET['elemName'];


	switch ($divContainer) {
		case "divContainerProfiles":
			$name = "Profile";
			break;		
		case "divContainerMacs":
			$name = "Mac";
			break;		
		default:
			$name = "Mac";
			break;		
	}

	include '../../library/opendb.php';

        $sql = "(SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].")".
                        "UNION (SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].");";
        $res = $dbSocket->query($sql);


	printqn("
		var divContainer = document.getElementById('$divContainer');
		var macs = ''+
	                '<label for=\'$name\' class=\'form\'>$name</label>'+
	                '        <select class=\'form\' name=\'$elemName\' >'+
	");
			

        while($row = $res->fetchRow()) {

		printqn("
	        	'<option value=\'$row[0]\'>$row[0]</option>'+
		");

	}

        printqn("
	        '        </select>'+
                '&nbsp; <a class=\"tablenovisit\" href=\"#\"'+
                '        onClick=\"javascript:ajaxGeneric(\'include/management/dynamic_macs.php\',\'delMacs\',\'$divContainer\',\'divCounter=$divCounter\');\">Del</a>';

		var childMac = document.createElement('div');
		childMac.setAttribute('id','divContainerMacs$divCounter');
		childMac.innerHTML = macs;
		divContainer.appendChild(childMac);
	");
	


	include '../../library/closedb.php';

}


?>
