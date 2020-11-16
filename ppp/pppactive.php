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
	$getprofile = $API->comm("/ppp/profile/print");
	$TotalReg = count($getprofile);
	// count ppp profile
	$countprofile = $API->comm("/ppp/profile/print", array(
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
									if ($countprofile < 2) {
										echo "$countprofile item  ";
									} elseif ($countprofile > 1) {
										echo "$countprofile items   ";
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

								$profiledetalis = $getprofile[$i];
								$pid = $profiledetalis['.id'];
								$pname = $profiledetalis['name'];
								$local_address = $profiledetalis['local-address'];
								$remote_address = $profiledetalis['remote-address'];
								$bridge = $profiledetalis['bridge'];
								$rate_limit = $profiledetalis['rate-limit'];
								$only_one = $profiledetalis['only-one'];
								$getmonexpired = $API->comm("/system/scheduler/print", array(
									"?name" => "$pname",
								));
								$monexpired = $getmonexpired[0];
								$monid = $monexpired['.id'];
								$pmon = $monexpired['name'];
								$chkpmon = $monexpired['disabled'];
								if (empty($pmon) || $chkpmon == "true") {
									$moncolor = "text-orange";
								} else {
									$moncolor = "text-green";
								}
							?>
                            <td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer'
                                    onclick="if(confirm('Are you sure to delete profile (<?= $pname; ?>)?')){loadpage('./?remove-ppp-profile=<?= $pid; ?>&pname=<?= $pname ?>&session=<?= $session; ?>')}else{}"
                                    title='Remove <?= $pname; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <?php
								echo "<a title='Open User by profile " . $pname . "'  href='./?ppp=users&profile=" . $pname . "&session=" . $session . "'><i class='fa fa-users'></i></a></td>";
								echo "<td><a title='Open User Profile " . $pname . "' href='./?ppp=edit-profile=" . $pid . "&session=" . $session . "'><i class='fa fa-edit'></i> <i class='fa fa-ci fa-circle " . $moncolor . "'></i> $pname</a></td>";
								//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
								echo "<td>" . $local_address;
								echo "</td>";
								echo "<td>" . $remote_address;
								echo "</td>";
								echo "<td>" . $bridge;
								echo "</td>";
								echo "<td>" . $rate_limit;
								echo "</td>";
								echo "<td>" . $only_one;
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