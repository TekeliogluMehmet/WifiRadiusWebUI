<?php

include('../../library/checklogin.php');
include('pages_common.php');

/*
 * delGroups removes an instance of a select box item for a group
 */
if(isset($_GET['delGroups'])) {

	if (isset($_GET['divContainer']))
		$divContainer = $_GET['divContainer'];

	if (isset($_GET['divContainer2']))
		$divContainer2 = $_GET['divContainer2'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];


        printqn("
                var divContainer = document.getElementById('$divContainer');
		var childGroup = document.getElementById('divContainerGroups$divCounter');
		divContainer.removeChild(childGroup);
                var divContainer2 = document.getElementById('$divContainer2');
		var childMac = document.getElementById('divContainerMacs$divCounter');
		divContainer2.removeChild(childMac);
	");
}



/*
 * getGroups creates a new select item for adding groups along with a Del link to delete
 * the added item
 */
if(isset($_GET['getGroups'])) {

	if (isset($_GET['divContainer']))
		$divContainer = $_GET['divContainer'];

	if (isset($_GET['divContainer2']))
		$divContainer2 = $_GET['divContainer2'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];

	if (isset($_GET['elemName']))
		$elemName = $_GET['elemName'];


	switch ($divContainer) {
		case "divContainerProfiles":
			$name = "Profile";
			break;		
		case "divContainerGroups":
			$name = "Group";
			break;		
		default:
			$name = "Group";
			break;		
	}
	switch ($divContainer2) {
		case "divContainerProfiles":
			$name2 = "Profile";
			break;		
		case "divContainerMacs":
			$name2 = "Mac";
			break;		
		default:
			$name2 = "Mac";
			break;		
	}

	include '../../library/opendb.php';

        $sql = "(SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].")".
                        "UNION (SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].");";
        $res = $dbSocket->query($sql);


	printqn("
		var divContainer = document.getElementById('$divContainer');
		var groups = ''+
	                '<label for=\'$name\' class=\'form\'>$name / MAC Address</label>'+
	                '        <select class=\'form\' name=\'$elemName\' >'+
	");
			

        while($row = $res->fetchRow()) {

		printqn("
	        	'<option value=\'$row[0]\'>$row[0]</option>'+
		");

	}

        printqn("
	        '        </select>'+
	                '        <input type=\'text\' name=\'macs[]\' >'+
                '&nbsp; <a class=\"tablenovisit\" href=\"#\"'+
                '        onClick=\"javascript:ajaxGeneric(\'include/management/dynamic_groups.php\',\'delGroups\',\'$divContainer\',\'divCounter=$divCounter\',\'$divContainer2\');\">Del</a>';

		var childGroup = document.createElement('div');
		childGroup.setAttribute('id','divContainerGroups$divCounter');
		childGroup.innerHTML = groups;
		divContainer.appendChild(childGroup);
	");
	printqn("
		var divContainer2 = document.getElementById('$divContainer2');
		var macs = ''+
	                '        <input type=\'text\' name=\'$elemName\' >';
			
		var childMac = document.createElement('div');
		childMac.setAttribute('id','divContainerMacs$divCounter');
		childMac.innerHTML = macs;
		divContainer2.appendChild(childMac);
	");
	


	include '../../library/closedb.php';

}


?>
