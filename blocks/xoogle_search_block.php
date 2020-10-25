<?php
// $Id: xoogle_search_block.php,v 1.1 2006/03/10 20:06:31 mikhail Exp $

require_once XOOPS_ROOT_PATH . '/modules/xoogle/include/xoogle.php';

function XoogleBlockSearch($options)
{
    global $_GET;

    $gconf = getGoogleConfig();

    if ($gconf['lrinblock']) {
        $block['lr_select'] = makeLangSelect();
    }

    if ($gconf['slinblock']) {
        $block['sl_select'] = makeSLSelect($gconf);
    }

    if ('' != $_GET['query']) {
        $block['query'] = $_GET['query'];
    }

    $block['SEARCH_LABEL'] = _XO_SEARCH_LABEL;

    $block['SEARCH_BUTTON'] = _XO_SEARCH_BUTTON;

    $block['ADVANCED_SEARCH'] = _XO_ADVANCED_SEARCH;

    return $block;
}
