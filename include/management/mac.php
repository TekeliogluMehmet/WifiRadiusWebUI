<?php
/*********************************************************************
* Name: mac.php
* Author: Liran tal <liran.tal@gmail.com>
* 
* This file extends user management pages (specifically edit user
* page) to allow group management.
* Essentially, this extention populates groups into tables
*
*********************************************************************/

	if (!isset($macTerminology)) {
		$macTerminology = "Mac";
		$macTerminologyPriority = "MacPriority";
	}
		


	// Grabing the group lists from usergroup table
        $sql = "(SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].
                ") UNION (SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].");";

	$res = $dbSocket->query($sql);

	$macOptions = "";
	$macAddress = "";

	while($row = $res->fetchRow()) {			
		$macOptions .= "<option value='$row[0]'> $row[0] </option>";
		$macAddress .= "<option value='$row[1]'> $row[1] </option>";
	}

?>

	<fieldset>

                <h302> <?php echo $macTerminology ?> Assignment </h302>
		<br/>

	        <h301> Associated <?php echo $macTerminology ?>s </h301>
	        <br/>

		<ul>

<?php

	$sql = "SELECT GroupName, priority FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']
		." WHERE UserName='".$dbSocket->escapeSimple($username)."';";
	$sql = "SELECT vlan, macaddress FROM userMacDefine where username='".$dbSocket->escapeSimple($username)."';";
	$res = $dbSocket->query($sql);

	if ($res->numRows() == 0) {
		echo "<center> ".$l['messages']['nomacdefinedforuser']." <br/></center>";
	} else {

		$counter = 0;

		while($row = $res->fetchRow()) {

			echo "

				<li class='fieldset'>
				<label for='mac' class='form'>".$l['all'][$macTerminology]." #".($counter+1)."</label>
				<select name='groups[]' id='usergroup$counter' tabindex=105 class='form' >
					<option value='$row[0]'>$row[0]</option>
					<option value=''></option>
					".$macOptions."
				</select>

				<input value='$row[1]' name='macs[]' id='mac_priority$counter' >

				<br/>
				</li>
			";

			$counter++;

		} //while

	} // if-else
?>


