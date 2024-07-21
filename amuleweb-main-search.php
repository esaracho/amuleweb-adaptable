<!DOCTYPE html>

<html lang="en">

<head>

	<title>aMule | Search</title>
	<meta charset="UTF-8">
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
				<a class="nav-link d-flex active justify-content-end" href="./amuleweb-main-search.php">Search</a>
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
	</div>


    <!-- Commands -->
    <form action="amuleweb-main-search.php" method="post" name="mainform">
    <input type="hidden" name="command">
	<div class="shadow container-lg g-0">
		<div class="text-bg-dark">
			<div class="row align-items-center g-0 px-3 pb-2">
				<div class="col-12 col-sm-12 col-md-2 col-xl-1"><h5 class="">Search</h5></div>
				<div class="col-12 col-sm-12 col-md-12 col-xl-11">
					<div class="input-group">
						<input class="form-control w-50" type="text" placeholder="Text query..." name="searchval">
						<select class="form-select w-25" name="searchtype">
    					<option>Local</option>
    					<option selected>Global</option>
    					<option>Kad</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row align-items-center g-0 px-3 pb-2">
				<div class="col-12 col-sm-12 col-md-8 col-xl-8">
					<div class="input-group mb-2">
						<div class="input-group-text">Avail</div>
               		 	<input type="text" name="avail" class="form-control" value="0" aria-label="Availability">
						<div class="input-group-text">MinSz</div>
                		<input type="text" name="minsize" class="form-control" value="1" aria-label="Min size">
						<select class="form-select" name="minsizeu">
    					<option>Byte</option>
						<option>KByte</option>
						<option selected>MByte</option>
						<option>GByte</option>
    					</select>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-4 col-xl-4">
					<div class="input-group mb-2">
						<div class="input-group-text">MaxSz</div>
                		<input type="text" name="maxsize" class="form-control" value="10000" aria-label="Max size">
						<select class="form-select" name="maxsizeu">
    					<option>Byte</option>
						<option>KByte</option>
						<option selected>MByte</option>
						<option>GByte</option>
    					</select>
					</div>
				</div>
			</div>
		

			<div class="row align-items-center g-0 px-3 pb-2">
				<div class="col-12 col-sm-12 col-md-4 col-xl-2">
					<div class="input-group mb-2">
						<input class="btn btn-outline-light w-auto" name="Search" type="submit" value="Search" onClick="javascript:formCommandSubmit('search');">
						<a class="btn btn btn-outline-success w-auto" href="amuleweb-main-search.php?search_sort=name" role="button">Show results</a>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-8 col-xl-10">
					<div class="input-group mb-2">
						<input class="btn btn-outline-light" name="Download" type="submit" value="Download" onClick="javascript:formCommandSubmit('download');">
						<select class="form-select" name="targetcat">
          				<?php
                			$cats = amule_get_categories();
               			 	foreach($cats as $c) {
                			echo "<option>", $c, "</option>";
                			}
              	 		 ?>
        				</select>
					</div>
				</div>
			</div>	
		</div>
	
		<div class="table-responsive">
				<table class="table">
				<thead class="table-light">
					<tr>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-search.php?sort=name">File name&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-search.php?sort=size">Size&nbsp;&darr;&uarr;</a></th>
						<th scope="col"><a class="text-decoration-none text-dark" href="amuleweb-main-search.php?sort=sources">Sources&nbsp;&darr;&uarr;</a></th>
					</tr>
				</thead>
				<tbody>

				<?php
					function CastToXBytes($size) {
						if ( $size < 1024 ) {
							$result = $size . " b";
						} elseif ( $size < 1048576 ) {
							$result = ($size / 1024.0) . "kb";
						} elseif ( $size < 1073741824 ) {
							$result = ($size / 1048576.0) . "mb";
						} else {
							$result = ($size / 1073741824.0) . "gb";
						}
						return $result;
					}

					$sort_order;$sort_reverse;

					function my_cmp($a, $b) {
						global $sort_order, $sort_reverse;

						switch ( $sort_order) {
							case "size": $result = $a->size > $b->size; break;
							case "name": $result = $a->name > $b->name; break;
							case "sources": $result = $a->sources > $b->sources; break;
						}

						if ( $sort_reverse ) {
							$result = !$result;
						}

						return $result;
					}

					function str2mult($str) {
						$result = 1;
						switch($str) {
							case "Byte":	$result = 1; break;
							case "KByte":	$result = 1024; break;
							case "MByte":	$result = 1012*1024; break;
							case "GByte":	$result = 1012*1024*1024; break;
						}
						return $result;
					}

					function cat2idx($cat) {
					        	$cats = amule_get_categories();
					        	$result = 0;
					        	foreach($cats as $i => $c) {
					        		if ( $cat == $c) $result = $i;
					        	}
					    		return $result;
					}

					if ($_SESSION["guest_login"] == 0) {
						if ( $HTTP_GET_VARS["command"] == "search") {
							$search_type = -1;
							switch($HTTP_GET_VARS["searchtype"]) {
								case "Local": $search_type = 0; break;
								case "Global": $search_type = 1; break;
								case "Kad": $search_type = 2; break;
							}
							$min_size = $HTTP_GET_VARS["minsize"] == "" ? 0 : $HTTP_GET_VARS["minsize"];
							$max_size = $HTTP_GET_VARS["maxsize"] == "" ? 0 : $HTTP_GET_VARS["maxsize"];

							$min_size *= str2mult($HTTP_GET_VARS["minsizeu"]);
							$max_size *= str2mult($HTTP_GET_VARS["maxsizeu"]);

							amule_do_search_start_cmd($HTTP_GET_VARS["searchval"],
								"", "",
								$search_type, $HTTP_GET_VARS["avail"], $min_size, $max_size);
						} elseif ( $HTTP_GET_VARS["command"] == "download") {
							foreach ( $HTTP_GET_VARS as $name => $val) {
								// this is file checkboxes
								if ( (strlen($name) == 32) and ($val == "on") ) {
									$cat = $HTTP_GET_VARS["targetcat"];
									$cat_idx = cat2idx($cat);
									amule_do_search_download_cmd($name, $cat_idx);
								}
							}
						} else {
						}
					}
					$search = amule_load_vars("searchresult");

					$sort_order = $HTTP_GET_VARS["sort"];

					if ( $sort_order == "" ) {
						$sort_order = $_SESSION["search_sort"];
					} else {
						if ( $_SESSION["search_sort_reverse"] == "" ) {
							$_SESSION["search_sort_reverse"] = 0;
						} else {
							$_SESSION["search_sort_reverse"] = !$_SESSION["search_sort_reverse"];
						}
					}

					$sort_reverse = $_SESSION["search_sort_reverse"];
					if ( $sort_order != "" ) {
						$_SESSION["search_sort"] = $sort_order;
						usort(&$search, "my_cmp");
					}

					foreach ($search as $file) {
						echo '<tr>';
						echo '<td>', '<div class="form-check" style="margin: 0px;"><label><input class="form-check-input" type="checkbox" name="', $file->hash, '" >&nbsp;', $file->name, "</label></div></td>";
						echo '<td>', CastToXBytes($file->size), '</td>';
						echo '<td>', $file->sources, '</td>';
						echo '</tr>';
					}


				?>
				</tbody>
			</table>
		</div>
	</div>
	</form>
</body>
</html>
