<?php
// $Id: header.php,v 1.1 2006/03/10 20:06:33 mikhail Exp $

require dirname(__DIR__, 2) . '/mainfile.php';
require_once __DIR__ . '/include/xoogle.php';
require_once __DIR__ . '/class/nusoap.php';
$Xoogle = new soapclient(
    'http://api.google.com/search/beta2'
);
