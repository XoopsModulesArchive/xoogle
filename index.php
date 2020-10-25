<?php
// $Id: index.php,v 1.1 2006/03/10 20:06:33 mikhail Exp $

require __DIR__ . '/header.php';

//redirect to search.php

$gconf = getGoogleConfig();
// if a search has been submitted fetch results
if ('' != $_GET['query']) {
    $_GET['query'] = str_replace(' ', '+', $_GET['query']);

    if (mb_strstr($gconf['google_key'], '000000') || !$gconf['google_key']) {
        $xoogle_error = _XO_KEY_ERROR;
    } else {
        $xoogle_results = xoogleSearch($_GET);
    }

    if (!$_GET['search']) {
        $_GET['search'] = $gconf['sldefault'];
    }
}

// make sure we have a search location else set default

if ('xoops' == $_GET['search']) {
    // sample search.php string

    // query=xoogle+blend&andor=AND&action=results&submit=Search

    $str = 'query=' . $_GET['query'] . '&andor=AND&action=results&submit=Search';

    redirect_header(XOOPS_URL . '/search.php?' . $str, 1, _XO_XOOPS_SEARCH_MSG);
}

// check to see if we need a language restriction select box.
if ('show_form' == $gconf['google_lr']) {
    $lr_select = makeLangSelect($gconf);
}

$sl_select = makeSLRadio($gconf);

// We must always set our main template before including the header
$GLOBALS['xoopsOption']['template_main'] = 'xoogle.html';
// Include the page header
require XOOPS_ROOT_PATH . '/header.php';

// if there are results assign them to the template
if ($xoogle_results) {
    $xoopsTpl->assign('xoogle_results', $xoogle_results);
}

if ($lr_select) {
    $xoopsTpl->assign('lr_select', $lr_select);
}
$xoopsTpl->assign('sl_select', $sl_select);

if ($_GET) {
    $xoopsTpl->assign('post', $_GET);
}

if ($xoogle_error) {
    $xoopsTpl->assign('xoogle_error', $xoogle_error);
}

// assign the content labels.
$xoopsTpl->assign('PAGE_TITLE', _XO_PAGE_TITLE);
$xoopsTpl->assign('PAGE_DESC', _XO_PAGE_DESC);

$xoopsTpl->assign('SEARCH_LABEL', _XO_SEARCH_LABEL);
$xoopsTpl->assign('SEARCH_BUTTON', _XO_SEARCH_BUTTON);
$xoopsTpl->assign('SEARCH_THE_WEB', _XO_SEARCH_THE_WEB);
$xoopsTpl->assign('SEARCH_THIS_SITE', _XO_SEARCH_THIS_SITE);

// Include the page footer
require XOOPS_ROOT_PATH . '/footer.php';
