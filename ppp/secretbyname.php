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

    $getprofile = $API->comm("/ppp/profile/print");

    if (substr($secretbyname, 0, 1) == "*") {
        $secretbyname = $secretbyname;
    } elseif (substr($secretbyname, 0, 1) != "") {
        $getsecret = $API->comm("/ppp/secret/print", array(
            "?name" => "$secretbyname",
        ));
        $secretbyname = $getsecret[0]['.id'];
        if ($secretbyname == "") {
            echo "<b>Secrets not found</b>";
        }
    } else {
        $secretbyname = substr($secretbyname, 7);
    }


    $getsecret = $API->comm("/ppp/secret/print", array(
        "?.id" => "$secretbyname"
    ));
    $secretdetail = $getsecret[0];
    $sid = $secretdetail['.id'];
    $sname = $secretdetail['name'];
    $password = $secretdetail['password'];
    $service = $secretdetail['service'];
    $callerid = $secretdetail['caller-id'];
    $profile = $secretdetail['profile'];
    $localaddress = $secretdetail['local-address'];
    $remoteaddress = $secretdetail['remote-address'];
    $routes = $secretdetail['routes'];
    $limitbytesin = $secretdetail['limit-by-tesin'];
    $limitbytesout = $secretdetail['limit-by-tesout'];
    $lastloggedout = $secretdetail['last-logged-out'];

    if (isset($_POST['name'])) {
        $name = (preg_replace('/\s+/', '-', $_POST['name']));
        $password = ($_POST['password']);
        $service = ($_POST['service']);
        $callerid = ($_POST['callerid']);
        $profile = ($_POST['profile']);
        $localaddress = ($_POST['localaddress']);
        $remoteaddress = ($_POST['remoteaddress']);
        $routes = ($_POST['routes']);
        $limitbytesin = ($_POST['limitbytesin']);
        $limitbytesout = ($_POST['limitbytesout']);
        $lastloggedout = ($_POST['lastloggedout']);


        $API->comm("/ppp/secret/set", array(
            /*"add-mac-cookie" => "yes",*/
            ".id" => "$sid",
            "name" => "$name",
            "password" => "$password",
            "service" => "$service",
            "caller-id" => "$callerid",
            "profile" => "$profile",
            "local-address" => "$localaddress",
            "remote-address" => "$remoteaddress",
            "routes" => "$routes",
            "limit-bytes-in" => "$limitbytesin",
            "limit-bytes-out" => "$limitbytesout",
            "last-logged-out" => "$lastloggedout",
        ));

        echo "<script>window.location='./?secret=" . $sid . "&session=" . $session . "'</script>";
    }
}
?>
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-edit"></i> Edit PPP Secrets </h3>
            </div>
            <div class="card-body">
                <form autocomplete="off" method="post" action="">
                    <div>
                        <a class="btn bg-warning" href="./?ppp=secrets&session=<?= $session; ?>"> <i class="fa fa-close"></i> <?= $_close ?></a>
                        <button type="submit" name="save" class="btn bg-primary"><i class="fa fa-save"></i>
                            <?= $_save ?></button>
                    </div>
                    <table class="table">
                        <tr>
                            <td class="align-middle"><?= $_name ?></td>
                            <td><input class="form-control" type="text" onchange="remSpace();" autocomplete="off" name="name" value="<?= $sname; ?>" required="1" autofocus></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Password</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="password" value="<?= $password; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Service</td>
                            <td>
                                <?php if ($service == 'any') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any" selected>any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == 'async') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async" selected>async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == '12tp') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp" selected>l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == 'ovpn') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn" selected>ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == 'pppoe') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe" selected>pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == 'pptp') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp" selected>pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } elseif ($service == 'sstp') { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp" selected>sstp</option>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control" name="service" required="1">
                                        <option value="any">any</option>
                                        <option value="async">async</option>
                                        <option value="l2tp">l2tp</option>
                                        <option value="ovpn">ovpn</option>
                                        <option value="pppoe">pppoe</option>
                                        <option value="pptp">pptp</option>
                                        <option value="sstp">sstp</option>
                                    </select>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Caller ID</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="callerid" value="<?= $callerid; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Profile</td>
                            <td>
                                <select class="form-control" name="profile" required="1">
                                    <?php $TotalReg = count($getprofile);
                                    for ($i = 0; $i < $TotalReg; $i++) {
                                        if ($getprofile[$i]['name'] == $profile) {
                                            echo "<option selected>" . $getprofile[$i]['name'] . "</option>";
                                        } else {
                                            echo "<option>" . $getprofile[$i]['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                    <!-- <option value="default">default</option>
                                    <option value="default-encryption">default-encryption</option> -->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Local Address</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="localaddress" value="<?= $localaddress; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Remote Address</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="remoteaddress" value="<?= $remoteaddress; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Routes</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="routes" value="<?= $routes; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Limit Bytes In</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="limitbytesin" value="<?= $limitbytesin; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Limit Bytes Out</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="limitbytesout" value="<?= $limitbytesout; ?>"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Last Logged Out</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="lastloggedout" value="<?= $lastloggedout; ?>"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="col-4">
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
    </div> -->
</div>