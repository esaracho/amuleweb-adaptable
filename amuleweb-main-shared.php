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
	<!-- <div class="container-fluid panel-tr"> -->
	<form name="mainform" action="amuleweb-main-shared.php" method="post">
		<input type="hidden" name="command">
		<div class="shadow container-lg g-0">
			<div class="text-bg-dark px-3 py-3 border-top border-light-subtle">
				<div class="row align-items-center">
					<div class="col-3 col-sm-6 col-md-1 col-xl-auto"><h5 class="">Shared</h5></div>
					<div class="col-9 col-sm-6 col-md-11 col-xl-11">
						<div class="btn-group mb-2" role="group">
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('priodown');" role="button">- prio</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('reload');" role="button">Refresh</a>
							<a class="btn btn-outline-light" href="javascript:formCommandSubmit('prioup');" role="button">+ prio</a>
						</div>
					</div>
				</div>
			</div>

		<!-- Table Download -->
		<!-- <div class="panel" style="margin-bottom: 60px;">
		<div class="panel-heading panel-center"><h4>SHARED FILES</h4></div> -->
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=name">File&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=size">Size&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=xfer">Up&nbsp;sess&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-shared.php?sort=xfer_all">Up&nbsp;total&nbsp;&darr;&uarr;</a></th>
						<!-- <th scope="col"><a href="amuleweb-main-shared.php?sort=req">Requested</a> <a href="amuleweb-main-shared.php?sort=req_all">(Total)</a></th>
						<th scope="col"><a href="amuleweb-main-shared.php?sort=acc">Accepted Rqst</a> <a href="amuleweb-main-shared.php?sort=acc_all">(Total)</a></th> -->
						<th scope="col"><span>Ratio</span></th>
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
							return '<span class="label label-info" style="font-size:12px; padding-top:3.6px;">Paused</span>';
						} elseif ( $file->src_count_xfer > 0 ) {
							return '<span class="label label-success" style="font-size:12px;">Downloading</span>';
						} else {
							return '<span class="label label-warning" style="font-size:12px;">Waiting</span>';
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
							3 => "Very high", 4 => "Very low", 5=> "Auto", 6 => "Release");
						$result = $prionames[$file->prio];
						if ( $file->prio_auto == 1) {
							$result = $result . "&nbsp(auto)";
						}
						return $result;
					}

					function PrioStringSorter($file) {
						$prionames = array(0 => "Low", 1 => "Normal", 2 => "High",
							3 => "High", 4 => "Low", 5=> "Normal", 6 => "Release");
						$result = $prionames[$file->prio];
						return $result;
					}

					$sort_order;$sort_reverse;

					function my_cmp($a, $b)	{
						global $sort_order, $sort_reverse;
						//echo '<p>', $sort_order,'</p>';
						//echo '<p>', $sort_reverse,'</p>';

						switch ( $sort_order) {
							case "size": $result = $a->size > $b->size; break;
							case "name": $result = $a->name > $b->name; break;
							case "xfer": $result = $a->xfer > $b->xfer; break;
							case "xfer_all": $result = $a->xfer_all > $b->xfer_all; break;
							case "acc": $result = $a->accept > $b->accept; break;
							case "acc_all": $result = $a->accept_all > $b->accept_all; break;
							case "req": $result = $a->req > $b->req; break;
							case "req_all": $result = $a->req_all > $b->req_all; break;
							case "prio": $result = PrioSort($a) < PrioSort($b); break;
						}

						if ( $sort_reverse ) {
							$result = !$result;
						}
						//var_dump($sort_reverse);
						return $result;
					}

					//
					// perform command before processing content
					//
					
					if (($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0)) {
						//echo var_dump($HTTP_GET_VARS) . "<br>";
						//amule_do_download_cmd($HTTP_GET_VARS["command"]);
						foreach ( $HTTP_GET_VARS as $name => $val) {
							// this is file checkboxes
							if ( (strlen($name) == 32) and ($val == "on") ) {
								//var_dump($name);var_dump($val);
								amule_do_shared_cmd($name, $HTTP_GET_VARS["command"]);
							}
						}
						if ($HTTP_GET_VARS["command"] == "reload") {
							amule_do_reload_shared_cmd();
						}

					}

					$shared = amule_load_vars("shared");

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
					//var_dump($_SESSION);
					$sort_reverse = $_SESSION["sort_reverse"];

					if ( $sort_order != "" ) {
						$_SESSION["shared_sort"] = $sort_order;
						usort(&$shared, "my_cmp");
					}

					if ($HTTP_GET_VARS["select"] == "All" || $HTTP_GET_VARS["select"] == "") {
						foreach ($shared as $file) {

							$ratio = (float)((float)$file->xfer_all / (float)$file->size);
							//$ratio_2 = round($ratio, 2);
							//$archivo = $file->$name;

							echo '<tr scope="row">';
							echo '<td >', '<div class="form-check" style="margin: 0px;"><input class="form-check-input" type="checkbox" name="', $file->hash, '" >&nbsp;', $file->name, "</div></td>";
							echo '<td >', CastToXBytes($file->size), '</td>';
							echo '<td >', CastToXBytes($file->xfer), '</td>';
							echo '<td >', CastToXBytes($file->xfer_all), '</td>';
							echo '<td >', $ratio, '</td>';
							/* echo '<td >', $file->req, " (", $file->req_all, ")</td>";
							echo '<td >', $file->accept, " (", $file->accept_all, ")</td>"; */
							echo '<td >', PrioString($file), '</td>';
							echo '</tr>';
						}
					} else {
						foreach ($shared as $file) {
							if ($HTTP_GET_VARS["select"] == PrioStringSorter($file)) {
								echo '<tr>';

								echo '<td style="font-size:12px;">', '<div class="form-check" style="margin: 0px;"><label><input class="form-check-input" type="checkbox" name="', $file->hash, '" >&nbsp;<b>', $file->name, "</b></label></div></td>";
								echo '<td style="font-size:12px;">', CastToXBytes($file->xfer), " (", CastToXBytes($file->xfer_all),")</td>";
								echo '<td style="font-size:12px;">', $file->req, " (", $file->req_all, ")</td>";
								echo '<td style="font-size:12px;">', $file->accept, " (", $file->accept_all, ")</td>";
								echo '<td style="font-size:12px;">', CastToXBytes($file->size), "</td>";
								echo '<td style="font-size:12px;">', PrioString($file), "</td>";;
								echo '</tr>';
							}
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
		
		<!-- </div> -->

		<!-- Footer -->
<!-- 		<div id="footer">
			<div class="col-md-1"></div>
			<div class="col-md-5">
				<form name="formlink" method="post" class="form-inline" action="amuleweb-main-shared.php" role="form" id="formed2link">
	    			<div class="btn-group">
	        			<input class="form-control btn-group" name="ed2klink" type="text" id="ed2klink" placeholder="ed2k:// - Insert link" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px; height: 30px;" size="25">
	        			<select class="form-control btn-group" name="selectcat" id="selectcat" style="height: 30px;">
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
	        		<input class="btn btn-default btn-group" type="submit" name="Submit" value="Download link" onClick="amuleweb-main-dload.php" style="height: 30px;">
	    		</div>
	    </form>
			</div>
			<div class="col-md-5">
				<div class="form-inline" style="margin-top:10px;">
					<?php
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
				    ?>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div> -->
</body>
</html>
