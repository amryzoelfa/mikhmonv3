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


    if (substr($secret, 0, 1) == "*") {
        $secret = $secret;
    } elseif (substr($secret, 0, 1) != "") {
        $getsecret = $API->comm("/ppp/secret/print", array(
            "?name" => "$secret",
        ));
        $secret = $getsecret[0]['.id'];
        if ($secret == "") {
            echo "<b>Secrets not found</b>";
        }
    }

    $getsecret = $API->comm("/ppp/secret/print", array(
        "?.id" => "$secret"
    ));
    $secretdetail = $getsecret[0];
    $sid = $secretdetail['.id'];
    $sname = $secretdetail['name'];
    $password = $secretdetail['password'];
    $service = $secretdetail['service'];
    $callerid = $secretdetail['callerid'];
    $profile = $secretdetail['profile'];
    $localaddress = $secretdetail['localaddress'];
    $remoteaddress = $secretdetail['remoteaddress'];
    $routes = $secretdetail['routes'];
    $limitbytesin = $secretdetail['limitbytesin'];
    $limitbytesout = $secretdetail['limitbytesout'];
    $lastloggedout = $secretdetail['lastloggedout'];

    $getprofile = $API->comm("/ppp/profile/print", array(
        "?name" => "$profile"
    ));

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
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="password" value="<?= $password; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Service</td>
                            <td>
                                <select class="form-control" name="service" required="1">
                                    <option value="any">any</option>
                                    <option value="async">async</option>
                                    <option value="l2tp">l2tp</option>
                                    <option value="ovpn">ovpn</option>
                                    <option value="pppoe">pppoe</option>
                                    <option value="pptp">pptp</option>
                                    <option value="sstp">sstp</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Caller ID</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="callerid" value="<?= $callerid; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Profile</td>
                            <td>
                                <select class="form-control" name="profile" required="1">
                                    <option value="default">default</option>
                                    <option value="default-encryption">default-encryption</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Local Address</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="localaddress" value="<?= $localaddress; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Remote Address</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="remoteaddress" value="<?= $remoteaddress; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Routes</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="routes" value="<?= $routes; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Limit Bytes In</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="limitbytesin" value="<?= $limitbytesin; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Limit Bytes Out</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="limitbytesout" value="<?= $limitbytesout; ?>" required="0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">Last Logged Out</td>
                            <td><input class="form-control" type="text" size="4" autocomplete="off" name="lastloggedout" value="<?= $lastloggedout; ?>" required="0"></td>
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