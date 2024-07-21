<!DOCTYPE html>

<html lang="en">
<head>
	<title>aMule | Shared</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
	<link href="/style.css" rel="stylesheet">
	<script language="JavaScript" type="text/JavaScript">
		function formCommandSubmit(command)
		{
			<?php
				if ($_SESSION["guest_login"] != 0) {
					echo 'alert("You logged in as guest - commands are disabled");';
					echo "return;";
			}
			?>
		var frm=document.forms.mainform
		frm.command.value=command
		frm.submit()
		}
	</script>

</head>




<body>
    <?php
    	if ($_SESSION["guest_login"] != 0) {
		    echo '<br><br><span class="label label-warning">You logged in as guest - commands are disabled</span>';
		}
	?>

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
            			<a class="nav-link d-flex active justify-content-end" href="./amuleweb-main-shared.php">Shared</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-search.php">Search</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-servers.php">Servers</a>
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
	
	

		<!-- Table Download -->
		<form name="mainform" action="amuleweb-main-shared.php" method="post">
		<input type="hidden" name="command">
		<div class="shadow container-lg g-0">
			<div class="text-bg-dark">
				<div class="row align-items-center g-0 px-3 py-2">
					<div class="col-auto col-sm-6 col-md-1 col-xl-auto me-2"><h5 class="">Shared</h5></div>
					<div class="col-8 col-sm-6 col-md-11 col-xl-11">
						<div class="btn-group mb-2" role="group">
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('priodown');" role="button">- prio</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('reload');" role="button">Refresh</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('prioup');" role="button">+ prio</a>
						</div>
					</div>
				</div>
			</div>
	
		<div class="table-responsive">
			<table class="table">
				<thead class="table-light">
					<tr>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=name">File&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=size">Size&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=xfer">Up&nbsp;sess&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=xfer_all">Up&nbsp;total&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=ratio">Ratio&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=prio">Priority&nbsp;&darr;&uarr;</a></th>
					</tr>
				</thead>
				<tbody>

				<?php

					function CastToXBytes($size, &$count) {
						$count += $size;
						if ( $size < 1024 ) {
							$result = $size . " b";
						} elseif ( $size < 1048576 ) {
							$result = ($size / 1024.0) . " kb";
						} elseif ( $size < 1073741824 ) {
							$result = ($size / 1048576.0) . " mb";
						} else {
							$result = ($size / 1073741824.0) . " gb";
						}
						return $result;
					}

					function StatusString($file) {
						if ( $file->status == 7 ) {
							return '<span class="label label-info" padding-top:3.6px;">Paused</span>';
						} elseif ( $file->src_count_xfer > 0 ) {
							return '<span class="label label-success"">Downloading</span>';
						} else {
							return '<span class="label label-warning"">Waiting</span>';
						}
					}

					function StatusCode($file) {
						if ( $file->status == 7 ) {
							return 1; // Paused
						} elseif ( $file->src_count_xfer > 0 ) {
							return 0; // downloading
						} else {
							return -1; // waiting
						}
					}

					function PrioString($file) {
						$prionames = array(0 => "Low", 1 => "Normal", 2 => "High",
							3 => "Very high", 4 => "Very low", 5=> "Auto", 6 => "Powershare");
						$result = $prionames[$file['prio']];
						if ( $file['prio_auto'] == 1) {
							$result = $result . "&nbsp(auto)";
						}
						return $result;
					}

					$sort_order;$sort_reverse;

					function my_cmp($a, $b)	{
						global $sort_order, $sort_reverse;
						switch ( $sort_order) {
							case "size": $result = $a['size'] > $b['size']; break;
							case "name": $result = $a['name'] > $b['name']; break;
							case "xfer": $result = $a['xfer'] > $b['xfer']; break;
							case "xfer_all": $result = $a['xfer_all'] > $b['xfer_all']; break;
							case "ratio": $result = $a['ratio'] > $b['ratio']; break;
							case "prio": $result = $a['prio'] > $b['prio']; break;
						}

						if ( $sort_reverse ) {
							$result = !$result;
						}
						return $result;
					}

					//
					// perform command before processing content
					//
					
					if (($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0)) {
						foreach ( $HTTP_GET_VARS as $name => $val) {
							// this is file checkboxes
							if ( (strlen($name) == 32) and ($val == "on") ) {
								amule_do_shared_cmd($name, $HTTP_GET_VARS["command"]);
							}
						}
						if ($HTTP_GET_VARS["command"] == "reload") {
							amule_do_reload_shared_cmd();
						}

					}


					$shared = amule_load_vars("shared");
					$sharedFinal = array(0);
					$index = 0;

					foreach ($shared as $file) {

						$name = $file->name;
						$short_name = $file->short_name;
						$hash = $file->hash;
						$size = $file->size;
						$link = $file->link;
						$xfer = $file->xfer;
						$xfer_all = $file->xfer_all;
						$req = $file->req;
						$req_all = $file->req_all;
						$accept = $file->accept;
						$accept_all = $file->accept_all;
						$prio = $file->prio;
						$prio_auto = $file->prio_auto;
						$ratio = (float)((float)$xfer_all / (float)$size);

						$sharedFinal[$index] = array("name" => $name, "short_name" => $short_name, "hash" => $hash, "size" => $size, "link" => $link,
						"xfer" => $xfer, "xfer_all" => $xfer_all, "req" => $req, "req_all" => $req_all, "accept" => $accept, "accept_all" => $accept_all,
						"prio" => $prio, "prio_auto" => $prio_auto, "ratio" => $ratio);

						++$index;

					}


					$sort_order = $HTTP_GET_VARS["sort"];

					if ( $sort_order == "" ) {
						$sort_order = $_SESSION["shared_sort"];
					} else {
						if ( $_SESSION["sort_reverse"] == "" ) {
							$_SESSION["sort_reverse"] = 0;
						} else {
							$_SESSION["sort_reverse"] = !$_SESSION["sort_reverse"];
						}
					}
					
					$sort_reverse = $_SESSION["sort_reverse"];

					if ( $sort_order != "" ) {
						$_SESSION["shared_sort"] = $sort_order;
						usort(&$sharedFinal, "my_cmp");
					}

					if ($HTTP_GET_VARS["select"] == "All" || $HTTP_GET_VARS["select"] == "") {
						foreach ($sharedFinal as $file) {
							echo '<tr scope="row">';
							echo '<td >', '<div class="form-check" style="margin: 0px;"><input class="form-check-input" type="checkbox" name="', $file['hash'], '" >&nbsp;', $file['name'], "</div></td>";
							echo '<td >', CastToXBytes($file['size']), '</td>';
							echo '<td >', CastToXBytes($file['xfer']), '</td>';
							echo '<td >', CastToXBytes($file['xfer_all']), '</td>';
							echo '<td >', $file['ratio'], '</td>';
							echo '<td >', PrioString($file), '</td>';
							echo '</tr>';
						}
					} 
				?>

				</tbody>
			</table>
			</div>
			<?php
			function CastToXBytes($size, &$count) {
				$count += $size;
				if ( $size < 1024 ) {
					$result = $size . " b";
				} elseif ( $size < 1048576 ) {
					$result = ($size / 1024.0) . " kb";
				} elseif ( $size < 1073741824 ) {
					$result = ($size / 1048576.0) . " mb";
				} else {
					$result = ($size / 1073741824.0) . " gb";
				}
				return $result;
			}
			$countSharedTotal = 0;
			$countSharedTotalSize = 0;
			$fakevar=0;
			$shared = amule_load_vars("shared");
			foreach ($shared as $file) {
				CastToXBytes($file->xfer_all, $countSharedTotal);
				CastToXBytes($file->size, $countSharedTotalSize);
			}
			echo '<div class="container-fluid text-dark bg-dark-subtle px-3 py-3">';
			echo '<span>', count($shared), " Shared | ", CastToXBytes($countSharedTotalSize, $fakevar), " | &uarr; ", CastToXBytes($countSharedTotal, $fakevar), "</span>";
			echo '</div>';
			?>
		</div>
	</form>
</body>
</html>
