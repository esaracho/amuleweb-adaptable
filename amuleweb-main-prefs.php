<!DOCTYPE html>

<html lang="en">
<head>
	<title>aMule | Settings</title>
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
  function formCommandSubmit(command) {
    let frm=document.forms.mainform
    frm.command.value=command
    frm.submit()
  }

  let initvals = new Object;

  <?php
    // apply new options before proceeding

    if ( ($HTTP_GET_VARS["Submit"] == "Apply") && ($_SESSION["guest_login"] == 0) ) {
      $file_opts = array("check_free_space", "extract_metadata",
        "ich_en","aich_trust", "preview_prio","save_sources", "resume_same_cat",
        "min_free_space", "new_files_paused", "alloc_full", "alloc_full_chunks",
        "new_files_auto_dl_prio", "new_files_auto_ul_prio"
      );
      $conn_opts = array("max_line_up_cap","max_up_limit",
        "max_line_down_cap","max_down_limit", "slot_alloc",
        "tcp_port","udp_dis","max_file_src","max_conn_total","autoconn_en");
      $webserver_opts = array("use_gzip", "autorefresh_time");

      $all_opts;
      foreach ($conn_opts as $i) {
        $curr_value = $HTTP_GET_VARS[$i];
        if ( $curr_value == "on") $curr_value = 1;
        if ( $curr_value == "") $curr_value = 0;

        $all_opts["connection"][$i] = $curr_value;
      }
      foreach ($file_opts as $i) {
        $curr_value = $HTTP_GET_VARS[$i];
        if ( $curr_value == "on") $curr_value = 1;
        if ( $curr_value == "") $curr_value = 0;

        $all_opts["files"][$i] = $curr_value;
      }
      foreach ($webserver_opts as $i) {
        $curr_value = $HTTP_GET_VARS[$i];
        if ( $curr_value == "on") $curr_value = 1;
        if ( $curr_value == "") $curr_value = 0;

        $all_opts["webserver"][$i] = $curr_value;
      }
      amule_set_options($all_opts);
    }

    $opts = amule_get_options();

    $opt_groups = array("connection", "files", "webserver");

    foreach ($opt_groups as $group) {
      $curr_opts = $opts[$group];
      foreach ($curr_opts as $opt_name => $opt_val) {
        echo 'initvals["', $opt_name, '"] = "', $opt_val, '";';
      }
    }
  ?>

  function focusName(name) {
    document.getElementsByName(name)[0].focus();
  }


  function toggleStatus(object, target) {
    check = document.getElementsByName(object)[0];
    text = document.getElementsByName(target)[0];
    if (check.checked) {
      text.disabled = false;
    } else {
      text.disabled = true;
    }
  }

  function init_data() {
    let frm = document.forms.mainform

    let str_param_names = new Array(
      "max_line_down_cap", "max_line_up_cap",
      "max_up_limit", "max_down_limit", "max_file_src",
      "slot_alloc", "max_conn_total",
      "tcp_port", "udp_port",
      "min_free_space",
      "autorefresh_time"
      )
    for(i = 0; i < str_param_names.length; i++) {
      frm[str_param_names[i]].value = initvals[str_param_names[i]];
    }
    let check_param_names = new Array(
      "autoconn_en", "reconn_en", "udp_dis", "new_files_paused",
      "aich_trust", "alloc_full", "alloc_full_chunks",
      "check_free_space", "extract_metadata", "ich_en",
      "new_files_auto_dl_prio", "new_files_auto_ul_prio",
      "use_gzip"
      )
    for(i = 0; i < check_param_names.length; i++) {
      frm[check_param_names[i]].checked = initvals[check_param_names[i]] == "1" ? true : false;
      console.log(check_param_names[i]);
    }
    frm["min_free_space"].disabled = initvals["check_free_space"] == "1" ? false : true;
  }

  document.addEventListener("DOMContentLoaded", () => {
    init_data();
  });
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
						<a class="nav-link d-flex justify-content-end" href="./amuleweb-main-servers.php">Servers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex active justify-content-end" href="./amuleweb-main-prefs.php">Settings</a>
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


    <!-- Center body -->

      <!-- Commands -->
      <form name="mainform" action="amuleweb-main-prefs.php" method="post">
      <div class="shadow container-lg g-0">
		  	<div class="text-bg-dark">
	     		<div class="row align-items-center g-0 px-3 py-2">
	  				<div class="col-auto col-md-1 col-xl-auto me-2"><h5 class="">Settings</h5></div>
	  				<div class="col-8 col-md-11 col-xl-11">
          <?php
              if ($_SESSION["guest_login"] == 0) {
                echo '<input class="btn btn-outline-light mb-2" type="submit" name="Submit" value="Apply" role="button">';
              } else {
                echo '<input class="btn btn-outline-light mb-2" type="submit" name="Submit" value="Apply" disabled>';
                echo '<br><br><span class="label label-warning">You logged in as guest - commands are disabled</span>';
              }
            ?>
	  		  	</div>
  				</div>
        </div>
        <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			<h5 class="">Webserver</h5>
		    </div>
        
          <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Page refresh interval</div>
                <input type="text" name="autorefresh_time" class="form-control" placeholder="Page refresh interval" aria-label="Page refresh interval">
            </div>
            </div>
            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="use_gzip" id="gzip" autocomplete="off">
              <label class="btn btn-outline-primary" for="gzip">Use gzip compression</label>
            </div>
          </div>

          <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			  <h5 class="">Bandwidth limits</h5>
		      </div>
          <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max download rate</div>
                <input type="text" name="max_down_limit" class="form-control" placeholder="Max download rate" aria-label="Max download rate">
            </div>
            </div>
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max upload rate</div>
                <input type="text" name="max_up_limit" class="form-control" placeholder="Max Upload Rate" aria-label="Max Upload Rate">
              </div>
            </div>
            <div class="col-sm-6 p-2">
             <div class="input-group">
                <div class="input-group-text">Slot allocation</div>
                <input type="text" name="slot_alloc" class="form-control" placeholder="Slot Allocation" aria-label="Slot Allocation">
             </div>
            </div>
          </div>
          
          <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			  <h5 class="">Connection settings</h5>
		      </div>
          <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max total connections</div>
                <input type="text" name="max_conn_total" class="form-control" placeholder="Max total connections" aria-label="Max total connections">
            </div>
            </div>
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max sources per file</div>
                <input type="text" name="max_file_src" class="form-control" placeholder="Max sources per file" aria-label="Max sources per file">
              </div>
            </div>
            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="autoconn_en" id="autoc" autocomplete="off">
              <label class="btn btn-outline-primary" for="autoc">Autoconnect at startup</label>
            </div>
            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="reconn_en" id="reconn" autocomplete="off">
              <label class="btn btn-outline-primary" for="reconn">Reconnect when connection lost</label>
            </div>
          </div>

          <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			  <h5 class="">Port settings</h5>
		      </div>
          <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">TCP Port</div>
                <input type="text" name="tcp_port" class="form-control" placeholder="TCP Port" aria-label="TCP Port">
            </div>
            </div>
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">UDP Port</div>
                <input type="text" name="udp_port" class="form-control" placeholder="UDP Port" aria-label="UDP Port">
              </div>
            </div>
            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="udp_dis" id="dis_udp" autocomplete="off">
              <label class="btn btn-outline-primary" for="dis_udp">Disable UDP connections</label>
            </div>
          </div>
         
        <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			<h5 class="">Line capacity (Statistics)</h5>
		    </div>
        <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max download rate</div>
                <input type="text" name="max_line_down_cap" class="form-control" placeholder="Max download rate" aria-label="Max download rate">
            </div>
            </div>
            <div class="col-sm-6 p-2">
              <div class="input-group">
                <div class="input-group-text">Max upload rate</div>
                <input type="text" name="max_line_up_cap" class="form-control" placeholder="Max upload rate" aria-label="Max upload rate">
              </div>
            </div>
          </div>
         
          <div class="text-bg-dark px-3 py-2 border-top border-light-subtle">
    			  <h5 class="">File settings</h5>
		      </div>
          <div class="row align-items-center g-0 p-2">
            <div class="col-sm-6 p-2">
              <div class="input-group">
                  <div class="input-group-text p-0">
                    <input type="checkbox" class="btn-check" name="check_free_space" id="check_free_space" autocomplete="off" onclick="javascript:toggleStatus('check_free_space','min_free_space')">
                    <label class="btn btn-outline-primary rounded-0 rounded-start" for="check_free_space">Check free minimum space (MB)</label>
                </div>
                  <input type="text" name="min_free_space" class="form-control" placeholder="Free minimum space (MB)" aria-label="Free minimum space (MB)">
              </div>
            </div>
            
            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="new_files_auto_dl_prio" id="new_files_auto_dl_prio" autocomplete="off">
              <label class="btn btn-outline-primary" for="new_files_auto_dl_prio">Added download with auto priority</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="new_files_auto_ul_prio" id="new_files_auto_ul_prio" autocomplete="off">
              <label class="btn btn-outline-primary" for="new_files_auto_ul_prio">New shared files with auto priority</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="ich_en" id="ich_en" autocomplete="off">
              <label class="btn btn-outline-primary" for="ich_en">I.C.H. active</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="aich_trust" id="aich_trust" autocomplete="off">
              <label class="btn btn-outline-primary" for="aich_trust">AICH trusts every hash (not recommended)</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="alloc_full_chunks" id="alloc_full_chunks" autocomplete="off">
              <label class="btn btn-outline-primary" for="alloc_full_chunks">Alloc full chunks for <code>.part</code> files</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="alloc_full" id="alloc_full" autocomplete="off">
              <label class="btn btn-outline-primary" for="alloc_full">Alloc full disk space for <code>.part</code> files</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="new_files_paused" id="new_files_paused" autocomplete="off">
              <label class="btn btn-outline-primary" for="new_files_paused">Add files to download in pause</label>
            </div>

            <div class="col-sm-6 p-2">
              <input type="checkbox" class="btn-check" name="extract_metadata" id="extract_metadata" autocomplete="off">
              <label class="btn btn-outline-primary" for="extract_metadata">Extract MetaData tags</label>
            </div>
          </div>
       </form>
     </div>

</body>
</html>
