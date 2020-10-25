<?php
// $Id: redirect.php,v 1.1 2006/03/10 20:06:33 mikhail Exp $

require __DIR__ . '/header.php';

redirect_header($_GET['url'], 2, $_GET['url']);
