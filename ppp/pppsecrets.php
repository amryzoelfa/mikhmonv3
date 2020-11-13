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


	// get user secret
	$getsecret = $API->comm("/ppp/secret/print");
	$TotalReg = count($getsecret);
	// count user secret
	$countsecret = $API->comm("/ppp/secret/print", array(
		"count-only" => "",
	));
}
?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header align-middle">
				<h3><i class=" fa fa-pie-chart"></i> PPP Secrets
					&nbsp; | &nbsp; <a href="./?ppp=add-secret&session=<?= $session; ?>" title="Add Secrets"><i class="fa fa-user-plus"></i> Add</a>
				</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="overflow box-bordered" style="max-height: 75vh">
					<table id="tFilter" class="table table-bordered table-hover text-nowrap">
						<thead>
							<tr>
								<th style="min-width:50px;" class="text-center">
									<?php
									if ($countsecret < 2) {
										echo "$countsecret item  ";
									} elseif ($countsecret > 1) {
										echo "$countsecret items   ";
									}
									?></th>
								<th class="align-middle"><?= $_name ?></th>
								<th class="align-middle">Password</th>
								<th class="align-middle">Service</th>
								<th class="align-middle">Caller Id</th>
								<th class="align-middle">Profile</th>
								<th class="align-middle">Local Address</th>
								<th class="align-middle">Remote Address</th>
								<th class="align-middle">Last<br>Logged<br>Out</th>
							</tr>
						</thead>
						<tbody>
							<?php

							for ($i = 0; $i < $TotalReg; $i++) {

								$secretdetail = $getsecret[$i];
								$sid = $secretdetail['.id'];
								$sname = $secretdetail['name'];
								$password = $secretdetail['password'];
								$service = $secretdetail['service'];
								$callerid = $secretdetail['caller-id'];
								$profile = $secretdetail['profile'];
								$localaddress = $secretdetail['local-address'];
								$remoteaddress = $secretdetail['remote-address'];
								$lastloggedout = $secretdetail['last-logged-out'];
							?>
								<td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete profile (<?= $pname; ?>)?')){loadpage('./?remove-ppp-profile=<?= $sid; ?>&pname=<?= $pname ?>&session=<?= $session; ?>')}else{}" title='Remove <?= $pname; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<?php
								echo "<a title='Open User by secret " . $sname . "'  href='./?ppp=users&profile=" . $sname . "&session=" . $session . "'><i class='fa fa-users'></i></a></td>";
								echo "<td><a title='Open User secret " . $sname . "' href='./?user-profile=" . $sid . "&session=" . $session . "'><i class='fa fa-edit'></i> $sname</a></td>";
								//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
								echo "<td>" . $password;
								echo "</td>";
								echo "<td>" . $service;
								echo "</td>";
								echo "<td>" . $callerid;
								echo "</td>";
								echo "<td>" . $profile;
								echo "</td>";
								echo "<td>" . $localaddress;
								echo "</td>";
								echo "<td>" . $remoteaddress;
								echo "</td>";
								echo "<td>" . $lastloggedout;
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