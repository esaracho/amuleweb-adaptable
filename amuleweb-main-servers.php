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
			    		$ed2k = "Connected " . (($stats["id"] < 16777216) ? "(low)" : "(high)");
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
		<div class="shadow container-lg g-0">
			<input type="hidden" name="command" id="comm">
			<input type="hidden" name="ip" id="serv">
			<input type="hidden" name="port" id="port">	
			<div class="text-bg-dark">
				<div class="row align-items-center g-0 px-3 py-2">
					<div class="col-auto col-sm-6 col-md-1 col-xl-auto me-2"><h5 class="">Servers</h5></div>
					<div class="col-8 col-sm-6 col-md-11 col-xl-11">
						<div class="btn-group mb-2" role="group">
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('connect');" role="button">Connect</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('disconnect');" role="button">Disconnect</a>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table">
				<thead class="table-light">
					<tr>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=name">Server&nbsp;name&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-servers.php?sort=desc">Description&nbsp;&darr;&uarr;</a></th>
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
							if ($_SESSION["guest_login"] == 0) {
								amule_do_server_cmd($HTTP_GET_VARS["ip"], $HTTP_GET_VARS["port"], $HTTP_GET_VARS["command"]);
							}
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

						$stats = amule_get_stats();
						$srvc = $stats["serv_name"];

						foreach ($servers as $srv) {

							echo "<tr>";

							if ($_SESSION["guest_login"] != 0) {
								echo "<td class='texte' align='center'></td>";
							} else {

								if ($srv->name == $srvc) {
									echo "<td><div class='form-check' style='margin: 0px;'><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"' checked>&nbsp;",  $srv->name, "</div></td>";
								
								} else {
									echo "<td><div class='form-check' style='margin: 0px;'><input class='form-check-input' type='radio' name='serverselect' id='ss' value='", $srv->ip,",",$srv->port,"'>&nbsp;",  $srv->name, "</div></td>";
								}
							}

							echo '<td>', $srv->desc, '</td>';
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
	</body>
</html>
