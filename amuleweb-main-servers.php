<!DOCTYPE html>

<html lang="en">
<head>
	<title>aMule | Servers</title>
	<?php
		if ( $_SESSION["auto_refresh"] > 0 ) {
			echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
		}
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
	<link href="/style.css" rel="stylesheet">


	<!-- <script type="text/Javascript">
		$(function () { $("[data-toggle='tooltip']").tooltip(); });
		$(function () { $("[data-toggle='popover']").popover(); });
	</script> -->

	<script language="JavaScript" type="text/JavaScript">
		function formCommandSubmit(command)	{
		<?php
			if ($_SESSION["guest_login"] != 0) {
				echo 'alert("You logged in as guest - commands are disabled");';
				echo "return;";
			}
		?>
		let value = document.querySelector("input[type='radio'][name=serverselect]:checked").value;
		var serverArr = value.split(',');
		console.log(serverArr);
		console.log(serverArr[0]);
		console.log(serverArr[1]);
		console.log(command);
		let cinput = document.getElementById("comm");
		cinput.value = command;
		let sinput = document.getElementById("serv");
		sinput.value = serverArr[0];
		let pinput = document.getElementById("port");
		pinput.value = serverArr[1];
		let frm = document.getElementById("servf");
		frm.submit();
		//const timeo = setTimeout(window.location.reload, 5000);
		//window.location.reload();
		//window.location.href = window.location.href;
		}	
	</script>
</head>
<body>
<!-- Navigation bar :: This part will be common in all the scripts -->
<div class="shadow container-lg bg-dark sticky-top">
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	    	<a class="navbar-brand" href="#"><img src="logo-nav.png" class="d-inline-block align-middle">aMule Web</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuColapsable">
      			<span class="navbar-toggler-icon"></span>
    		</button>
    		<div class="collapse navbar-collapse" id="menuColapsable">
      			<ul class="navbar-nav">
        			<li class="nav-item">
          				<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-dload.php">Transfer</a>
        			</li>
        			<li class="nav-item">
            			<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-shared.php">Shared</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-search.php">Search</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex active justify-content-end" href="./amuleweb-main-servers.php">Servers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-kad.php">Kad</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-stats.php">Stats</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-prefs.php">Settings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-log.php">Logs</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./login.php">Exit</a>
					</li>
      			</ul>
			</div>
    	</nav>
	
	<!-- Ed2k link -->
		<form name="formlink" method="post" class="form-inline pb-3" action="amuleweb-main-dload.php" role="form" id="formed2link">
			<div class="input-group">
		  		<input type="text" class="form-control" name="ed2klink" id="ed2klink" placeholder="ed2k:// - Insert link">
		 		<select class="form-select" name="selectcat" id="selectcat">
		   	   <?php
				$cats = amule_get_categories();
					if ( $HTTP_GET_VARS["Submit"] != "" ) {
							$link = $HTTP_GET_VARS["ed2klink"];
							$target_cat = $HTTP_GET_VARS["selectcat"];
							$target_cat_idx = 0;

							foreach($cats as $i => $c) {
								if ( $target_cat == $c) $target_cat_idx = $i;
							}

							if ( strlen($link) > 0 ) {
								$links = split("ed2k://", $link);
								foreach($links as $linkn) {
								    amule_do_ed2k_download_cmd("ed2k://" . $linkn, $target_cat_idx);
								}
							}
						}

						foreach($cats as $c) {
							echo  '<option>', $c, '</option>';
						}
					?>
						</select>
						<input class="btn btn-outline-light" type="submit" name="Submit" value="Download link">
				</div>
			</form>

		<!-- Status -->
		<div class="text-bg-dark pb-3">
				<?php
			      	$stats = amule_get_stats();
			    	if ( $stats["id"] == 0 ) {
			    		$ed2k = "Not connected";
			    		$ed2k_status = "bg-danger";
			    	} elseif ( $stats["id"] == 0xffffffff ) {
			    		$ed2k = "Connecting ...";
			    		$ed2k_status = "bg-info text-dark";
			    	} else {
			    		$ed2k = "Connected " . (($stats["id"] < 16777216) ? "(low)" : "(high)"); //. " " . $stats["serv_name"] . " " . $stats["serv_addr"];
			    		$ed2k_status = (($stats["id"] < 16777216) ? "bg-warning text-dark" : "bg-success");
			    	}
			    	if ( $stats["kad_connected"] == 1 ) {
			    		$kad1 = "Connected";
						if ( $stats["kad_firewalled"] == 1 ) {
							$kad2 = "(FW)";
							$kad_status = "bg-warning text-dark";
						} else {
							$kad2 = "(OK)";
							$kad_status = "bg-success";
						}
			    	} else {
			    		$kad1 = "Disconnected";
			    		$kad2 = "";
			    		$kad_status = "bg-danger";
			    	}

			    	echo '<span class="fs-6">ED2k</span> ';
			    	echo '<span class="badge rounded-pill ', $ed2k_status, '">', $ed2k, '</span>';
			    	echo '<span class="fs-6">&nbsp;&nbsp;&nbsp;KAD</span> ';
			    	echo '<span class="badge rounded-pill ', $kad_status, '">', $kad1, ' ', $kad2, '</span>';
			    ?>
		</div>
	</div>
    	<!-- Center table -->
		<!-- Table Servers -->
		<form action="amuleweb-main-servers.php" role= "form" method="post" name="serverform" id="servf">
  			<input type="hidden" name="command" id="comm">
			<input type="hidden" name="ip" id="serv">
			<input type="hidden" name="port" id="port">
		<div class="shadow container-lg g-0">
			<div class="text-bg-dark px-3 py-3 border-top border-light-subtle">
			<div class="row align-items-center">
					<div class="col-3 col-sm-6 col-md-1 col-xl-auto"><h5 class="">Servers</h5></div>
					<div class="col-9 col-sm-6 col-md-11 col-xl-11">
						<div class="btn-group mb-2" role="group">
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('connect');" role="button">Connect</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('disconnect');" role="button">Disconnect</a>
						</div>
					</div>
				</div>
				<!-- <div class="row align-items-center"> -->
					<!-- <h5>Servers</h5> -->
					<!-- <div class="col-sm-6 col-md-10 col-xl-11"> -->
						<!-- <?php
							//$stats = amule_get_stats();
							//echo '<span class="badge rounded-pill bg-success">', $stats["serv_name"] , " " , $stats["serv_addr"], '</span>';
						?> -->
					<!-- </div> -->
					<!-- <div class="col-sm-6 col-md-10 col-xl-11">
						<div class="btn-group me-2" role="group">
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('priodown');" role="button">- prio</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('reload');" role="button">Refresh</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('prioup');" role="button">+ prio</a>
						</div>
					</div> -->
				<!-- </div> -->
			</div>
			<div class="table-responsive">
			<table class="table">
				<thead class="table-light">
					<tr>
						<!-- <th scope="col">Conn</th> -->
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=name">Server&nbsp;name&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=desc">Description&nbsp;&darr;&uarr;</a></th>
						<!-- <th scope="col">Address</th> -->
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=users">Users&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=files">Files&nbsp;&darr;&uarr;</a></th>
					</tr>
				</thead>
				<tbody>

					<?php

						$sort_order;$sort_reverse;

						function my_cmp($a, $b) {
							global $sort_order, $sort_reverse;
							switch ( $sort_order) {
								case "name": $result = $a->name > $b->name; break;
								case "desc": $result = $a->desc > $b->desc; break;
								case "users": $result = $a->users > $b->users; break;
								case "files":$result = $a->files > $b->files; break;
							}

							if ( $sort_reverse ) {
								$result = !$result;
							}
							return $result;
						}

						$servers = amule_load_vars("servers");

						$sort_order = $HTTP_GET_VARS["sort"];

						if ( ($HTTP_GET_VARS["command"] != "") and ($HTTP_GET_VARS["ip"] != "") and ($HTTP_GET_VARS["port"] != "")) {
							// if ($_SESSION["guest_login"] == 0) {
								amule_do_server_cmd($HTTP_GET_VARS["ip"], $HTTP_GET_VARS["port"], $HTTP_GET_VARS["command"]);
							// }
						}

						if ( $sort_order == "" ) {
							$sort_order = $_SESSION["servers_sort"];
						} else {
							if ( $_SESSION["sort_reverse"] == "" ) {
								$_SESSION["sort_reverse"] = 0;
							} else {
								$_SESSION["sort_reverse"] = !$_SESSION["sort_reverse"];
							}
						}

						$sort_reverse = $_SESSION["sort_reverse"];
						if ( $sort_order != "" ) {
							$_SESSION["servers_sort"] = $sort_order;
							usort(&$servers, "my_cmp");
						}

						// perform command before processing content
					/* 	if ( ($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0) ) {
						foreach ( $HTTP_GET_VARS as $name => $val) {
						// this is file checkboxes
						if ( (strlen($name) == 32) and ($val == "on") ) {
						//var_dump($name);
						amule_do_download_cmd($name, $HTTP_GET_VARS["command"]);
							}
						} */
						$stats = amule_get_stats();
						$srvc = $stats["serv_name"];

						foreach ($servers as $srv) {

							/* if ($srv->name == $srvc) {
								echo '<p>',$srv->name,'</p>';
							} */

							echo "<tr>";

							if ($_SESSION["guest_login"] != 0) {
								echo "<td class='texte' align='center'></td>";
							} else {

								if ($srv->name == $srvc) {
									echo "<td><div class='form-check' style='margin: 0px;'><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"' checked>&nbsp;",  $srv->name, "</div></td>";
									//echo "<td><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"' checked></td>";	
								
								} else {
									echo "<td><div class='form-check' style='margin: 0px;'><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"'>&nbsp;",  $srv->name, "</div></td>";
									//echo "<td><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"'></td>";
								
								/* echo '<td>', '<a class="text-decoration-none" href="amuleweb-main-servers.php?cmd=connect&ip=', $srv->ip, '&port=', $srv->port, '">
												<span class="badge rounded-pill bg-success"> + </span>
											</a>',
											'<a class="text-decoration-none" href="amuleweb-main-servers.php?cmd=disconnect&ip=', $srv->ip, '&port=', $srv->port, '">
												<span class="badge rounded-pill bg-danger"> x </span>
											</a>',
									'</td>'; */
								}
							}

							// echo '<td>', $srv->name, '</td>';
							echo '<td>', $srv->desc, '</td>';
							// echo '<td>', $srv->addr, '</td>';
							echo '<td>', $srv->users, '</td>';
							echo '<td>', $srv->files, '</td> ';
							echo '</tr>';
						}
					?>

				</tbody>
			</table>
			</form>
		</div>
			<?php
			$stats = amule_get_stats();
			echo '<div class="container-fluid text-dark bg-dark-subtle px-3 py-3">';
			echo '<span>Connected to ', $stats["serv_name"] , " " , $stats["serv_addr"], "</span>";
			echo '</div>';
			?>
		</div>
		
	<!-- </div> -->

		<!-- Footer -->
			<!-- <div id="footer">
		<div class="col-md-1"></div>
		<div class="col-md-5">
			<form name="formlink" method="post" class="form-inline" action="amuleweb-main-servers.php" role="form" id="formed2link">
    			<div class="btn-group">
        			<input class="form-control btn-group" name="ed2klink" type="text" id="ed2klink" placeholder="ed2k:// - Insert link" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px; height: 30px;" size="25">
        			<select class="form-control btn-group" name="selectcat" id="selectcat" style="height: 30px;">
 -->
			      <!--   <?php
						$cats = amule_get_categories();

						if ( $HTTP_GET_VARS["Submit"] != "" ) {
							$link = $HTTP_GET_VARS["ed2klink"];
							$target_cat = $HTTP_GET_VARS["selectcat"];
							$target_cat_idx = 0;

							foreach($cats as $i => $c) {
								if ( $target_cat == $c) $target_cat_idx = $i;
							}

							if ( strlen($link) > 0 ) {
								$links = split("ed2k://", $link);
								foreach($links as $linkn) {
								    amule_do_ed2k_download_cmd("ed2k://" . $linkn, $target_cat_idx);
								}
							}
						}

						foreach($cats as $c) {
							echo  '<option>', $c, '</option>';
						}
					?> -->
        		<!-- </select>
        		<input class="btn btn-default btn-group" type="submit" name="Submit" value="Download link" onClick="amuleweb-main-dload.php" style="height: 30px;">
    		</div>
    </form>
		</div>
		<div class="col-md-5">
			<div class="form-inline" style="margin-top:10px;"> -->
				<!-- <?php
			      	$stats = amule_get_stats();
			    	if ( $stats["id"] == 0 ) {
			    		$ed2k = "Not connected";
			    		$ed2k_status = "danger";
			    	} elseif ( $stats["id"] == 0xffffffff ) {
			    		$ed2k = "Connecting ...";
			    		$ed2k_status = "info";
			    	} else {
			    		$ed2k = "Connected " . (($stats["id"] < 16777216) ? "(low)" : "(high)") . " " . $stats["serv_name"] . " " . $stats["serv_addr"];
			    		$ed2k_status = (($stats["id"] < 16777216) ? "warning" : "success");
			    	}
			    	if ( $stats["kad_connected"] == 1 ) {
			    		$kad1 = "Connected";
						if ( $stats["kad_firewalled"] == 1 ) {
							$kad2 = "(FW)";
							$kad_status = "warning";
						} else {
							$kad2 = "(OK)";
							$kad_status = "success";
						}
			    	} else {
			    		$kad1 = "Disconnected";
			    		$kad2 = "";
			    		$kad_status = "danger";
			    	}

			    	echo '<span class="label label-default">ED2k:</span> ';
			    	echo '<span class="label label-', $ed2k_status, '">', $ed2k, '</span> ';
			    	echo '<span class="label label-default">KAD:</span> ';
			    	echo '<span class="label label-', $kad_status, '">', $kad1, ' ', $kad2, '</span>';
			    ?> -->
			<!-- </div>
		</div>
		<div class="col-md-1"></div>
	</div> -->

	</body>
</html>
