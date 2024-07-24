<!DOCTYPE html>

<html lang="en">

<head>

	<title>aMule | Transfer</title>
	<?php
		if ( $_SESSION["auto_refresh"] > 0 ) {
			echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
		}
	?>

	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
	<link href="/style.css" rel="stylesheet">


	<script>
	function formCommandSubmit(command)
	{
		if ( command == "cancel" ) {
			var res = confirm("Delete selected files ?")
			if ( res == false ) {
				return;
			}
		}
		if ( command != "filter" ) {
			<?php
				if ($_SESSION["guest_login"] != 0) {
						echo 'alert("You logged in as guest - commands are disabled");';
						echo "return;";
				}
			?>
		}

		let input = document.getElementById("comm");
		input.value = command;
		let frm = document.getElementById("mainf");
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
          		<a class="nav-link active d-flex justify-content-end" href="./amuleweb-main-dload.php">Transfer</a>
        		</li>
        		<li class="nav-item">
            	<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-shared.php">Shared</a>
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

	<!-- BEGIN OF CENTRAL BODY -->
	<form action="amuleweb-main-dload.php" role= "form" method="post" name="mainform" id="mainf">
    	<input type="hidden" name="command" id="comm">
		<div class="shadow container-lg g-0">
		<div class="text-bg-dark">
			<div class="row align-items-center g-0 px-3 py-2">
				<div class="col-12 col-sm-12 col-md-2 col-xl-auto me-2"><h5 class="">Downloads</h5></div>
				<div class="col-12 col-sm-12 col-md-10 col-xl-10">
					<div class="btn-group me-2 mb-2" role="group">
						<a class="btn btn-outline-light" href="javascript:formCommandSubmit('pause');" role="button">Pause</a>
						<a class="btn btn-outline-light" href="javascript:formCommandSubmit('resume');" role="button">Resume</a>
						<a class="btn btn-outline-light" href="javascript:formCommandSubmit('cancel');" role="button">Remove</a>
					</div>
					<div class="btn-group mb-2" role="group">
						<a class="btn btn-outline-light" href="javascript:formCommandSubmit('priodown');" role="button">- prio</a>
						<a class="btn btn-outline-light" href="javascript:formCommandSubmit('prioup');" role="button">+ prio</a>
					</div>
				</div>
			</div>
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

					function StatusString($file) {
						if ( $file->status == 7 ) {
							return '<span>Paused</span>';
						} elseif ( $file->src_count_xfer > 0 ) {
							return '<span>Downloading</span>';
						} else {
							return '<span>Waiting</span>';
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

					//
					// declare it here, before any function reffered it in "global"
					//
					$sort_order; $sort_reverse;

					function my_cmp($a, $b)	{
						global $sort_order, $sort_reverse;

						switch ( $sort_order) {
							case "size": $result = $a->size > $b->size; break;
							case "size_done": $result = $a->size_done > $b->size_done; break;
							case "progress": $result = (((float)$a->size_done)/((float)$a->size)) > (((float)$b->size_done)/((float)$b->size)); break;
							case "name": $result = $a->name > $b->name; break;
							case "speed": $result = $a->speed > $b->speed; break;
							case "scrcount": $result = $a->src_count > $b->src_count; break;
							case "status": $result = StatusString($a) > StatusString($b); break;
							case "prio": $result = $a->prio < $b->prio; break;
						}

						if ( $sort_reverse ) {
							$result = !$result;
						}
						
						return $result;
					}

					function create_prg_bar($file) {

						$done = ((float)$file->size_done*100)/((float)$file->size);
						$status = StatusCode($file);

						switch (StatusCode($file)) {
							case -1: // waiting
								$status = 'class="progress-bar progress-bar-warning"';
								break;
							case 0: // downloading
								$status = 'class="progress-bar progress-bar-info"';
								break;
							case 1: // paused
								$status ='class="progress-bar progress-bar-info"';
								break;
							default: // paused
								$status ='class="progress-bar progress-bar-danger"';
								break;
						}
						echo '	<div class="progress" style="margin: 0px;"
						            data-toggle="popover" data-placement="bottom" data-title="Segments"
								    data-html="true" data-trigger="hover" data-content='. "'" . $file->progress . "'" . '>
								    <div '.$status.' role="progressbar" aria-valuenow="'.$done.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$done.'%"></div>
								</div>';
					}
					function create_tooltip($name) {
						echo '	<div class="texte" style="margin: 0px;"
									data-toggle="popoverTooltip" data-placement="bottom"
									data-html="true" data-trigger="hover" >
									<b>&nbsp;'. $name .'</b>
								
								</div>
								<div class="popper-content hide">&nbsp;'. $name .'</div>';
					}
					// perform command before processing content
					if ( ($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0) ) {
						foreach ( $HTTP_GET_VARS as $name => $val) {
							// this is file checkboxes
							if ( (strlen($name) == 32) and ($val == "on") ) {
								
								amule_do_download_cmd($name, $HTTP_GET_VARS["command"]);
							}
						}
						// check "filter-by-status" settings
						if ( $HTTP_GET_VARS["command"] == "filter") {
							
							$_SESSION["filter_status"] = $HTTP_GET_VARS["status"];
							$_SESSION["filter_cat"] = $HTTP_GET_VARS["category"];
						}
					}
					if ( $_SESSION["filter_status"] == "") $_SESSION["filter_status"] = "all";
					if ( $_SESSION["filter_cat"] == "") $_SESSION["filter_cat"] = "all";
					$countSize = 0;
					$countCompleted = 0;
					$countSpeed = 0;
					$downloads = amule_load_vars("downloads");
					$fakevar=0;
					$sort_order = $HTTP_GET_VARS["sort"];

					if ( $sort_order == "" ) {
						$sort_order = $_SESSION["download_sort"];
					} else {
						if ( $_SESSION["download_sort_reverse"] == "" ) {
							$_SESSION["download_sort_reverse"] = 0;
						} else {
							if ( $HTTP_GET_VARS["sort"] != '') {
								$_SESSION["download_sort_reverse"] = !$_SESSION["download_sort_reverse"];
							}
						}
					}
					
					$sort_reverse = $_SESSION["download_sort_reverse"];
					if ( $sort_order != "" ) {
						$_SESSION["download_sort"] = $sort_order;
						usort(&$downloads, "my_cmp");
					}
					// Prepare categories index array
					$cats = amule_get_categories();
					foreach($cats as $i => $c) {
						$cat_idx[$c] = $i;
					}

					foreach ($downloads as $file) {
						$filter_status_result = ($_SESSION["filter_status"] == "all") or
							($_SESSION["filter_status"] == StatusString($file));

						$filter_cat_result = ($_SESSION["filter_cat"] == "all") or
							($cat_idx[ $_SESSION["filter_cat"] ] == $file->category);

						if ( $filter_status_result and $filter_cat_result) {
							echo "<div class='card'>";
							echo "<div class='card-body'>";
							echo "<input type='checkbox' class='form-check-input me-2' name='", ($file->hash), "'>";
							//File name
							echo "<h5 class='card-title d-inline'>", ($file->name), "</h5><div class='d-block'></div>";
							//Size - Completed
							echo "<span class='text-success'>&darr; ", CastToXBytes($file->size_done, $countCompleted), "</span>";
							echo "<span> of </span>";
							echo "<span class='text-primary'>", CastToXBytes($file->size, $countSize), "</span>";
							echo "<span> / ", ($file->size_done*100)/($file->size), "%</span>";
							//Sources
							echo "<span> | 	&harr; ";
							if ( $file->src_count_not_curr != 0 ) {
								echo $file->src_count - $file->src_count_not_curr, " / ";
							}
							echo $file->src_count, " ( ", $file->src_count_xfer, " ) ";
							if ( $file->src_count_a4af != 0 ) {
								echo "+ ", $file->src_count_a4af;
							}
							echo "</span>";
							//Priority
							echo "<span> | " , PrioString($file), "</span>";
							//Status
							echo "<span> | " , StatusString($file), "</span>";
							//Speed
							echo "<span> | ", ($file->speed > 0) ? (CastToXBytes($file->speed, $countSpeed) . "/s") : "0 b/s","</span>";
							
							echo  "</div>";
							echo "</div>";
							
						}
					}
					if (count($downloads)==0) {
						echo "<div class='container-fluid text-dark bg-dark-subtle px-3 py-3'>";
						echo "<span>0 Downloads</span>";
						echo "</div>";
					} else {
						echo "<div class='container-fluid text-dark bg-dark-subtle px-3 py-3'>";
						echo "<span> ", count($downloads), " Downloads | &darr; ", CastToXBytes($countCompleted, $fakevar)," of " , CastToXBytes($countSize, $fakevar) , " | ",($countSpeed > 0) ? (CastToXBytes($countSpeed, $fakevar) . "/s" ) : "0 b/s","</span>";
						echo "</div>";
					}
					?>
			</div>
		</div>
	</form>
	<div class="shadow container-lg g-0">
		<div class="text-bg-dark px-3 py-3 border-top border-light-subtle">
    			<h5 class="card-title">Uploads</h5>
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
					function utf8_rawurldecode($raw_url_encoded){
						$enc = rawurldecode($raw_url_encoded);
						if(utf8_encode(utf8_decode($enc))==$enc){;
							return rawurldecode($raw_url_encoded);
						}else{
							return utf8_encode(rawurldecode($raw_url_encoded));
						}
					}
					function create_tooltip($name) {
						echo '	<div class="texte" style="margin: 0px;"
									data-toggle="popoverTooltip" data-placement="bottom"
									data-html="true" data-trigger="hover" >
									<b>&nbsp;'. $name .'</b>
								
								</div>
								<div class="popper-content hide">&nbsp;'. $name .'</div>';
					}
					$countUploadDimension = 0;
					$countSpeed = 0;
					$uploads = amule_load_vars("uploads");
					$fakevar=0;

					foreach ($uploads as $file) {

						echo "<div class='card'>";
						echo "<div class='card-body'>";
						echo "<h5 class='card-title'>", ($file->name), "</h5>";
						echo "<span class='text-primary'>&uarr; ", CastToXBytes($file->xfer_up, $countUploadDimension),"</span>";
						echo "<span> | ", ($file->xfer_speed > 0) ? (CastToXBytes($file->xfer_speed, $countSpeed) . "/s") : "0 b/s","</span>";
						echo  "</div>";
						echo "</div>";
					}
					if (count($uploads)==0) {
						echo "<div class='container-fluid text-dark bg-dark-subtle px-3 py-3'>";
						echo "<span>0 Uploads</span>";
						echo "</div>";
					} else {
						echo "<div class='container-fluid text-dark bg-dark-subtle px-3 py-3'>";
							echo "<span> ", count($uploads) ," Uploads | &uarr; ", CastToXBytes($countUploadDimension, $fakevar), " | ",($countSpeed > 0) ? (CastToXBytes($countSpeed, $fakevar) . "/s" ) : "0 b/s","</span>";
						echo "</div>";
					}
				?>

	</div>
</body>
</html>

