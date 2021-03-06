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

// remove secret
if ($removesecr != "") {
    $API->comm("/ppp/secret/remove", array(
        ".id" => "$removesecr",
    ));

    date_default_timezone_set('Asia/Jakarta');
    $hari = date('d/M/Y');
    $hariini = strtolower(date('M/d/Y H:i:s'));

    $name = "coba_enabled";
    $start_date = date('M/d/Y');
    $start_time = date('H:i:s');
    $interval = "00:00:01";
    $on_event = "/system scheduler remove [find name=" . $name . "] \r /system scheduler enable [find name=" . $rempname . "]";

    $API->comm("/system/scheduler/add", array(
        /*"add-mac-cookie" => "yes",*/
        "name" => "$name",
        "start-date" => "$start_date",
        "start-time" => "$start_time",
        "interval" => "$interval",
        "on-event" => "$on_event",
    ));

    $name2 = "coba_remove";
    $start_date2 = date('M/d/Y');
    $start_time2 = date('H:i:s');
    $interval2 = "00:00:01";
    $on_event2 = "/system scheduler remove [find name=" . $name2 . "] \r /system scheduler remove [find name=" . $rempname . "]";
    $API->comm("/system/scheduler/add", array(
        /*"add-mac-cookie" => "yes",*/
        "name" => "$name2",
        "start-date" => "$start_date2",
        "start-time" => "$start_time2",
        "interval" => "$interval2",
        "on-event" => "$on_event2",
    ));

    echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
}
// enable secret
elseif ($enablesecr != "") {
    $API->comm("/ppp/secret/set", array(
        ".id" => "$enablesecr",
        "disabled" => "no",
    ));
    date_default_timezone_set('Asia/Jakarta');
    $hari = date('d/M/Y');
    $hariini = strtolower(date('M/d/Y H:i:s'));

    $name = "coba_enabledd";
    $start_date = date('M/d/Y');
    $start_time = date('H:i:s');
    $interval = "00:00:01";
    $on_event = "/system scheduler enable [find name=" . $secretsheduler . "] \r /system scheduler remove [find name=" . $name . "]";

    $API->comm("/system/scheduler/add", array(
        /*"add-mac-cookie" => "yes",*/
        "name" => "$name",
        "start-date" => "$start_date",
        "start-time" => "$start_time",
        "interval" => "$interval",
        "on-event" => "$on_event",
    ));


    echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
}

// disable secret
elseif ($disablesecr != "") {
    $API->comm("/ppp/secret/set", array(
        ".id" => "$disablesecr",
        "disabled" => "yes",
    ));
    $name = "coba_disabled";
    $start_date = date('M/d/Y');
    $start_time = date('H:i:s');
    $interval = "00:00:01";
    $on_event = "/system scheduler disable [find name=" . $secretsheduler . "] \r /system scheduler remove [find name=" . $name . "]";

    $API->comm("/system/scheduler/add", array(
        /*"add-mac-cookie" => "yes",*/
        "name" => "$name",
        "start-date" => "$start_date",
        "start-time" => "$start_time",
        "interval" => "$interval",
        "on-event" => "$on_event",
    ));

    echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
}