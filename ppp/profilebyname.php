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
session_start();
// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {


  if (substr($userprofile, 0, 1) == "*") {
    $userprofile = $userprofile;
  } elseif (substr($userprofile, 0, 1) != "") {
    $getprofile = $API->comm("/ppp/profile/print", array(
      "?name" => "$userprofile",
    ));
    $userprofile = $getprofile[0]['.id'];
    if ($userprofile == "") {
      echo "<b>User Profile not found</b>";
    }
  }

  $getprofile = $API->comm("/ppp/profile/print", array(
    "?.id" => "$userprofile"
  ));
  $profiledetalis = $getprofile[0];
  $pid = $profiledetalis['.id'];
  $pname = $profiledetalis['name'];
  $localaddress = $profiledetalis['localaddress'];
  $remoteaddress = $profiledetalis['remoteaddress'];
  $bridge = $profiledetalis['bridge'];
  $ratelimit = $profiledetalis['ratelimit'];
  $onlyone = $profiledetalis['onlyone'];
  $bridgeportpriority = $profiledetalis['bridgeportpriority'];
  $bridgepathcost = $profiledetalis['bridgepathcost'];
  $bridgehorizon = $profiledetalis['bridgehorizon'];
  $incomingfilter = $profiledetalis['incomingfilter'];
  $outgoingfilter = $profiledetalis['outgoingfilter'];
  $addresslist = $profiledetalis['addresslist'];
  $interfacelist = $profiledetalis['interfacelist'];
  $dnsserver = $profiledetalis['dnsserver'];
  $winsserver = $profiledetalis['winsserver'];
  $changetcp = $profiledetalis['changetcp'];

  if (isset($_POST['name'])) {
    $name = (preg_replace('/\s+/', '-', $_POST['name']));
    $localaddress = ($_POST['localaddress']);
    $remoteaddress = ($_POST['remoteaddress']);
    $bridge = ($_POST['bridge']);
    $ratelimit = ($_POST['ratelimit']);
    $onlyone = ($_POST['onlyone']);
    $bridgeportpriority = ($_POST['bridgeportpriority']);
    $bridgepathcost = ($_POST['bridgepathcost']);
    $bridgehorizon = ($_POST['bridgehorizon']);
    $incomingfilter = ($_POST['incomingfilter']);
    $outgoingfilter = ($_POST['outgoingfilter']);
    $addresslist = ($_POST['addresslist']);
    $interfacelist = ($_POST['interfacelist']);
    $dnsserver = ($_POST['dnsserver']);
    $winsserver = ($_POST['winsserver']);
    $changetcp = ($_POST['changetcp']);


    $API->comm("/ppp/profile/set", array(
      /*"add-mac-cookie" => "yes",*/
      ".id" => "$pid",
      "name" => "$name",
      "local-address" => "$localaddress",
      "remote-address" => "$remoteaddress",
      "bridge" => "$bridge",
      "rate-limit" => "$ratelimit",
      "only-one" => "$onlyone",
      "bridge-port-priority" => "$bridgeportpriority",
      "bridge-path-cost" => "$bridgepathcost",
      "bridge-horizon" => "$bridgehorizon",
      "incoming-filter" => "$incomingfilter",
      "outgoing-filter" => "$outgoingfilter",
      "address-list" => "$addresslist",
      "interface-list" => "$interfacelist",
      "dns-server" => "$dnsserver",
      "wins-server" => "$winsserver",
      "change-tcp-mss" => "$changetcp",
    ));

    echo "<script>window.location='./?user-profile=" . $pid . "&session=" . $session . "'</script>";
  }
}
?>
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-edit"></i> Edit PPP Profiles </h3>
            </div>
            <div class="card-body">
                <form autocomplete="off" method="post" action="">
                    <div>
                        <a class="btn bg-warning" href="./?hotspot=user-profiles&session=<?= $session; ?>"> <i
                                class="fa fa-close"></i> <?= $_close ?></a>
                        <button type="submit" name="save" class="btn bg-primary"><i class="fa fa-save"></i>
                            <?= $_save ?></button>
                    </div>
                    <table class="table">
                        <tr>
                            <td class="align-middle"><?= $_name ?></td>
                            <td><input class="form-control" type="text" onchange="remSpace();" autocomplete="off"
                                    name="name" value="?= $pname; ?>" required="1" autofocus></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Local Address</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $localaddress; ?>"
                                    autocomplete="off" name="localaddress" required="1"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Remote Address</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $remoteaddress; ?>"
                                    autocomplete="off" name="remoteaddress" required="1"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Bridge</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $bridge; ?>"
                                    autocomplete="off" name="bridge" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Bridge Port Priority</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $bridgeportpriority; ?>"
                                    autocomplete="off" name="bridgeportpriority" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Bridge Port Cost</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $bridgepathcost; ?>"
                                    autocomplete="off" name="bridgepathcost" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Bridge Horizon</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $bridgehorizon; ?>"
                                    autocomplete="off" name="bridgehorizon" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Incoming Filter</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $incomingfilter; ?>"
                                    autocomplete="off" name="incomingfilter" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Outgoing Filter</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $outgoingfilter; ?>"
                                    autocomplete="off" name="outgoingfilter" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Address List</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $addresslist; ?>"
                                    autocomplete="off" name="addresslist" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Interface List</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $interfacelist; ?>"
                                    autocomplete="off" name="interfacelist" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">DNS Server</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $dnsserver; ?>"
                                    autocomplete="off" name="dnsserver" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">WINS Server</td>
                            <td><input class="form-control" type="text" size="4" value="<?= $winsserver; ?>"
                                    autocomplete="off" name="winsserver" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Change TCP MSS</td>
                            <td>
                                <?php if ($changetcp != 'No') { ?>
                                <input type="radio" id="" name="changetcp" value="Default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="changetcp" checked="1" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="changetcp" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php  } elseif ($changetcp == 'Yes') { ?>
                                <input type="radio" id="" name="changetcp" value="Default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="changetcp" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="changetcp" checked="1" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php } else { ?>
                                <input type="radio" id="" name="changetcp" checked="1" value="Default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="changetcp" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="changetcp" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Rate Limit</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="retelimit"
                                    placeholder="example: rx/tx" required="1"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Only One</td>
                            <td>
                                <?php if ($onlyone != 'No') { ?>
                                <input type="radio" id="" name="onlyone" value="default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="onlyone" checked="1" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="onlyone" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php  } elseif ($onlyone == 'Yes') { ?>
                                <input type="radio" id="" name="onlyone" value="default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="onlyone" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="onlyone" checked="1" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php } else { ?>
                                <input type="radio" id="" name="onlyone" checked="1" value="default">
                                <label for="">Default</label><br>
                                <input type="radio" id="no" name="onlyone" value="no">
                                <label for="no">No</label><br>
                                <input type="radio" id="yes" name="onlyone" value="yes">
                                <label for="yes">Yes</label><br>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-book"></i> <?= $_readme ?></h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td colspan="2">
                            <p style="padding:0px 5px;">
                                <?= $_details_user_profile ?>
                            </p>
                            <p style="padding:0px 5px;">
                                <?= $_format_validity ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>