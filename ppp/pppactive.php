<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
	echo '
<html>
<head><title>403 Forbidden</title></head>
<body bgcolor="white">
<center><h1>403 Forbidden</h1></center>
<hr><center>nginx/1.14.0</center>
</body>
</html>
';
} else {


	// get ppp profile
	$getactive = $API->comm("/ppp/active-connection/print");
	$TotalReg = count($getactive);
	// count ppp profile
	$countactive = $API->comm("/ppp/active-connection/print", array(
		"count-only" => "",
	));
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header align-middle">
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="overflow box-bordered" style="max-height: 75vh">
                    <table id="tFilter" class="table table-bordered table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="min-width:50px;" class="text-center">
                                    <?php
									if ($countactive < 2) {
										echo "$countactive item  ";
									} elseif ($countactive > 1) {
										echo "$countactive items   ";
									}
									?></th>
                                <th class="align-middle"><?= $_name ?></th>
                                <th class="align-middle">Local<br>Address</th>
                                <th class="align-middle">Remote<br>Address</th>
                                <th class="align-middle">Bridge</th>
                                <th class="align-middle">Rate<br>Limit</th>
                                <th class="align-middle">Only<br>One</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

							for ($i = 0; $i < $TotalReg; $i++) {

								$profiledetalis = $getactive[$i];
								$pid = $profiledetalis['.id'];
								$aname = $profiledetalis['name'];
								$service = $profiledetalis['service'];
								$caller_id = $profiledetalis['caller-id'];
								$encoding = $profiledetalis['encoding'];
								$address = $profiledetalis['address'];
								$uptime = $profiledetalis['uptime'];
								
								if (empty($aname) || $aname == "true") {
									$moncolor = "text-orange";
								} else {
									$moncolor = "text-green";
								}
							?>
                            <td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer'
                                    onclick="if(confirm('Are you sure to delete profile (<?= $aname; ?>)?')){loadpage('./?remove-pactive=<?= $pid; ?>&aname=<?= $aname ?>&session=<?= $session; ?>')}else{}"
                                    title='Remove <?= $aname; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <?php
								echo "</td>";
								echo "<td><a title='Open User Profile " . $aname . "' href='./?ppp=edit-profile=" . $pid . "&session=" . $session . "'><i class='fa fa-edit'></i> <i class='fa fa-ci fa-circle " . $moncolor . "'></i> $aname</a></td>";
								//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
								echo "<td>" . $service;
								echo "</td>";
								echo "<td>" . $caller_id;
								echo "</td>";
								echo "<td>" . $encoding;
								echo "</td>";
								echo "<td>" . $address;
								echo "</td>";
								echo "<td>" . $uptime;
								echo "</td>";
								echo "</tr>";
							}
								?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>