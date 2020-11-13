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

  if (isset($_POST['name'])) {
    $name = (preg_replace('/\s+/', '-', $_POST['name']));
    $localaddress = ($_POST['localaddress']);
    $remoteaddress = ($_POST['remoteaddress']);
    $bridge = ($_POST['bridge']);
    $ratelimit = ($_POST['ratelimit']);
    $onlyone = ($_POST['onlyone']);

    $API->comm("/ppp/profile/add", array(
      /*"add-mac-cookie" => "yes",*/
      "name" => "$name",
      "local-address" => "$localaddress",
      "remote-address" => "$remoteaddress",
      "bridge" => "$bridge",
      "rate-limit" => "$ratelimit",
      "only-one" => "$onlyone",
    ));
  }
}
?>
<div class="row">
  <div class="col-8">
    <div class="card box-bordered">
      <div class="card-header">
        <h3><i class="fa fa-plus"></i> Add PPP Profiles <small id="loader" style="display: none;"><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i></small></h3>
      </div>
      <div class="card-body">
        <form autocomplete="off" method="post" action="">
          <div>
            <a class="btn bg-warning" href="./?hotspot=user-profiles&session=<?= $session; ?>"> <i class="fa fa-close btn-mrg"></i> <?= $_close ?></a>
            <button type="submit" name="save" class="btn bg-primary btn-mrg"><i class="fa fa-save btn-mrg"></i> <?= $_save ?></button>
          </div>
          <table class="table">
            <tr>
              <td class="align-middle"><?= $_name ?></td>
              <td><input class="form-control" type="text" onchange="remSpace();" autocomplete="off" name="name" value="" required="1" autofocus></td>
            </tr>
            <tr>
              <td class="align-middle">Local Address</td>
              <td><input class="form-control" type="text" size="4" autocomplete="off" name="localaddress" required="1"></td>
            </tr>
            <tr>
              <td class="align-middle">Remote Address</td>
              <td><input class="form-control" type="text" size="4" autocomplete="off" name="remoteaddress" required="1"></td>
            </tr>
            <tr>
              <td class="align-middle">Bridge</td>
              <td><input class="form-control" type="text" size="4" autocomplete="off" name="bridge" required="0"></td>
            </tr>
            <tr>
              <td class="align-middle">Rate Limit</td>
              <td><input class="form-control" type="text" size="4" autocomplete="off" name="retelimit" placeholder="example: rx/tx" required="1"></td>
            </tr>
            <tr>
              <td class="align-middle">Only One</td>
              <td>
                <input type="radio" id="" name="onlyone" value="default">
                <label for="">Default</label><br>
                <input type="radio" id="no" name="onlyone" value="no">
                <label for="no">No</label><br>
                <input type="radio" id="yes" name="onlyone" value="yes">
                <label for="yes">Yes</label><br>
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
<script type="text/javascript">
  function remSpace() {
    var upName = document.getElementsByName("name")[0];
    var newUpName = upName.value.replace(/\s/g, "-");
    //alert("<?php if ($currency == in_array($currency, $cekindo['indo'])) {
                echo "Nama Profile tidak boleh berisi spasi";
              } else {
                echo "Profile name can't containing white space!";
              } ?>");
    upName.value = newUpName;
    upName.focus();
  }
</script>