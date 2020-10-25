<?php
// $Id: xoogle.php,v 1.1 2006/03/10 20:10:39 mikhail Exp $

// this page contains functions used by xoogle
function xoogleSearch($post)
{
    global $Xoogle;

    if ('site' == $post['search']) {
        $url = str_replace('http://', '', XOOPS_URL);

        $post['query'] .= ' site:' . $url;
    }

    //  print_r($post);

    if ($post['page'] < 1) {
        $post['page'] = 1;

        $post['start'] = 0;
    } else {
        $post['start'] = ($post['page'] * 10);
    }

    //	echo('<br>');

    //   print_r($post);

    $gconf = getGoogleConfig();

    //print_r($gconf);

    //echo('<br>');

    if ('no_lr' == $gconf['google_lr'] || 'show_form' == $gconf['google_lr']) {
        if ('show_form' == $gconf['google_lr']) {
            $lr = $post['lr'];
        }
    } else {
        $lr = $gconf['google_lr'];
    }

    if (!$lr) {
        $lr = '';
    }

    $options = [
        'key' => $gconf['google_key'], // the Developer's key
        'q' => $post['query'], // the search query
        'start' => $post['start'],      // the point in the search results should Google start
        'maxResults' => 10, // the number of search results (max 10)
        'filter' => true, // should the results be filtered?
        'restrict' => '',
        'safeSearch' => false,
        'lr' => $lr,
        'ie' => '',
        'oe' => '',
    ];

    //echo('// options xoogleSearch -> <br>');

    //print_r($options);

    //echo('<- // <br>');

    $mycall = getGoogleResults($options);

    return $mycall;
}

function xoopsXoogleSearch($queryarray, $andor, $limit, $offset, $userid)
{
    global $Xoogle;

    if (!$Xoogle) {
        require_once XOOPS_ROOT_PATH . '/modules/xoogle/class/nusoap.php';

        $Xoogle = new soapclient(
            'http://api.google.com/search/beta2'
        );
    }

    //echo('in -> // '.$queryarray .'|'. $andor .'|'. $limit .'|'. $offset .'|'. $userid);

    if ($limit > 10) {
        $limit = 10;
    }

    //print_r($queryarray);

    //echo('<br>');

    $thisquery = implode('+', $queryarray);

    //print_r($thisquery);

    $gconf = getGoogleConfig();

    if ('no_lr' == $gconf['google_lr'] || 'show_form' == $gconf['google_lr']) {
        $lr = '';
    } else {
        $lr = $gconf['google_lr'];
    }

    if (!$lr) {
        $lr = '';
    }

    $options = [
        'key' => $gconf['google_key'], // the Developer's key
        'q' => $thisquery, // the search query
        'start' => $offset,      // the point in the search results should Google start
        'maxResults' => $limit, // the number of search results (max 10)
        'filter' => true, // should the results be filtered?
        'restrict' => '',
        'safeSearch' => false,
        'lr' => $lr,
        'ie' => '',
        'oe' => '',
    ];

    //echo('// options xoopsXoogleSearch -> <br>');

    //print_r($options);

    //echo('<- // <br>');

    $mycall = getGoogleResults($options);

    //echo('<br>');

    //print_r($mycall);

    //echo('<br>');

    if ('' != $mycall['soap_error']) {
        $ret[0]['link'] = '';

        $ret[0]['title'] = $mycall['soap_error'];
    } else {
        $i = 0;

        foreach ($mycall['results']['resultElements'] as $result) {
            $ret[$i]['link'] = 'redirect.php?url=' . $result['URL'];

            $ret[$i]['title'] = strip_tags($result['title']);

            $i++;
        }
    }

    return $ret;
}

function getGoogleResults($options)
{
    global $Xoogle;

    if (!$Xoogle) {
        require_once XOOPS_ROOT_PATH . '/modules/xoogle/class/nusoap.php';

        $Xoogle = new soapclient(
            'http://api.google.com/search/beta2'
        );
    }

    $namespace = 'urn:GoogleSearch';

    /* Call the taxCalc() function, passing the parameter list. */

    if (!$mycall['results'] = $Xoogle->call('doGoogleSearch', $options, $namespace)) {
        $mycall['soap_error'] = 'soap error : ' . $Xoogle->error_str;
    }

    $total = $mycall['results']['estimatedTotalResultsCount'];

    $mycall['paginate'] = xoogle_paginate($total, 10, $_GET['page'], $total);

    $mycall['soap_call'] = htmlentities($Xoogle->request, ENT_QUOTES | ENT_HTML5);

    $mycall['soap_response'] = htmlentities($Xoogle->response, ENT_QUOTES | ENT_HTML5);

    $mycall['page'] = $post['page'];

    /*/
    echo('<pre>soap call //-> ');
    // print_r($mycall['soap_call']);
    echo('</pre>');
    echo('<pre>soap response //-> ');
    // print_r($mycall['soap_response']);
    echo('</pre>');
    echo('<pre>result //-> ');
    //print_r($mycall['results']);
    print_r($mycall['results']);
    echo('</pre>');
    /*/

    return $mycall;
}

function getGoogleConfig()
{
    global $xoopsDB;

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xoogle_config');

    $sql .= ' WHERE xoogleid = 1';

    if (!$result = $xoopsDB->query($sql)) {
        echo($xoopsDB->error() . ' <br>');
    }

    $key = $xoopsDB->fetchArray($result);

    return $key;
}

function updateGoogleKey($post)
{
    global $xoopsDB;

    $sql = 'UPDATE ' . $xoopsDB->prefix('xoogle_config');

    $sql .= " SET google_key = '" . $post['google_key'] . "',";

    $sql .= " google_lr = '" . $post['lr'] . "',";

    $sql .= " siteactive = '" . $post['siteactive'] . "',";

    $sql .= " webactive = '" . $post['webactive'] . "',";

    $sql .= " xoopsactive = '" . $post['xoopsactive'] . "',";

    $sql .= " sldefault = '" . $post['sldefault'] . "',";

    $sql .= " lrinblock = '" . $post['lrinblock'] . "',";

    $sql .= " sitelabel = '" . $post['sitelabel'] . "',";

    $sql .= " weblabel = '" . $post['weblabel'] . "',";

    $sql .= " xoopslabel = '" . $post['xoopslabel'] . "',";

    $sql .= " slinblock = '" . $post['slinblock'] . "'";

    $sql .= ' WHERE xoogleid = 1';

    if (!$result = $xoopsDB->query($sql)) {
        echo($xoopsDB->error() . '<br>');
    }

    return $post['google_key'];
}

// provides pagination by determining first record
function xoogle_paginate($items, $limit, $page, $total_items)
{
    if (!$page) {
        $page = 1;
    }

    $paginate['total_matched'] = $total_items;

    if ($total_items > $items) {
        $paginate['filter_on'] = true;
    }

    $paginate['count'] = ceil($items / $limit);

    if ($page > 1) {
        $paginate['start'] = $limit * ($page - 1);
    } else {
        $paginate['start'] = 0;
    }

    $paginate['first_rec'] = $paginate['start'] + 1;

    $paginate['last_rec'] = $paginate['start'] + $limit;

    if ($paginate['last_rec'] > $items) {
        $paginate['last_rec'] = $items;
    }

    $paginate['limit'] = $limit;

    $paginate['page'] = $page;

    if ($paginate['page'] <= $paginate['count'] and $paginate['count'] > 1) {
        $paginate['prev'] = $paginate['page'] - 1;
    } else {
        $paginate['prev'] = 0;
    }

    if ($paginate['page'] >= 1 and $paginate['count'] > 1 and $paginate['page'] < $paginate['count']) {
        $paginate['next'] = $paginate['page'] + 1;
    } else {
        $paginate['next'] = 0;
    }

    return $paginate;
}

function googleLangRestrictions()
{
    $lr[1]['label'] = 'Arabic';

    $lr[1]['code'] = 'lang_ar';

    $lr[2]['label'] = 'Chinese (S)';

    $lr[2]['code'] = 'lang_zh-CN';

    $lr[3]['label'] = 'Chinese (T)';

    $lr[3]['code'] = 'lang_zh-TW';

    $lr[4]['label'] = 'Czech';

    $lr[4]['code'] = 'lang_cs';

    $lr[5]['label'] = 'Danish';

    $lr[5]['code'] = 'lang_da';

    $lr[6]['label'] = 'Dutch';

    $lr[6]['code'] = 'lang_nl';

    $lr[7]['label'] = 'English';

    $lr[7]['code'] = 'lang_en';

    $lr[8]['label'] = 'Estonian';

    $lr[8]['code'] = 'lang_et';

    $lr[9]['label'] = 'Finnish';

    $lr[9]['code'] = 'lang_fi';

    $lr[10]['label'] = 'French';

    $lr[10]['code'] = 'lang_fr';

    $lr[11]['label'] = 'German';

    $lr[11]['code'] = 'lang_de';

    $lr[12]['label'] = 'Greek';

    $lr[12]['code'] = 'lang_el';

    $lr[13]['label'] = 'Hebrew';

    $lr[13]['code'] = 'lang_iw';

    $lr[14]['label'] = 'Hungarian';

    $lr[14]['code'] = 'lang_hu';

    $lr[15]['label'] = 'Icelandic';

    $lr[15]['code'] = 'lang_is';

    $lr[16]['label'] = 'Italian';

    $lr[16]['code'] = 'lang_it';

    $lr[17]['label'] = 'Japanese';

    $lr[17]['code'] = 'lang_ja';

    $lr[18]['label'] = 'Korean';

    $lr[18]['code'] = 'lang_ko';

    $lr[19]['label'] = 'Latvian';

    $lr[19]['code'] = 'lang_lv';

    $lr[20]['label'] = 'Lithuanian';

    $lr[20]['code'] = 'lang_lt';

    $lr[21]['label'] = 'Norwegian';

    $lr[21]['code'] = 'lang_no';

    $lr[22]['label'] = 'Portuguese';

    $lr[22]['code'] = 'lang_pt';

    $lr[23]['label'] = 'Polish';

    $lr[23]['code'] = 'lang_pl';

    $lr[24]['label'] = 'Romanian';

    $lr[24]['code'] = 'lang_ro';

    $lr[25]['label'] = 'Russian';

    $lr[25]['code'] = 'lang_ru';

    $lr[26]['label'] = 'Spanish';

    $lr[26]['code'] = 'lang_es';

    $lr[27]['label'] = 'Swedish';

    $lr[27]['code'] = 'lang_sv';

    $lr[28]['label'] = 'Turkish';

    $lr[28]['code'] = 'lang_tr';

    return $lr;
}

function makeLangSelect($gconf)
{
    $lr_list = googleLangRestrictions();

    $lr_select = "<select name='lr'>";

    $lr_select .= "<option value=''>" . _XO_ANY_LANGUAGE . '</option>';

    if (!$_GET['lr']) {
        $_GET['lr'] = $gconf['google_lr'];
    }

    foreach ($lr_list as $v) {
        $lr_select .= "<option value='" . $v['code'] . "'";

        if ($_GET['lr'] == $v['code']) {
            $lr_select .= ' selected';
        }

        $lr_select .= '>' . $v['label'] . '</option>';
    }

    $lr_select .= '</select>';

    return $lr_select;
}

function makeSLSelect($gconf)
{
    if ($_GET['search']) {
        $gconf['sldefault'] = $_GET['search'];
    }

    $sl_select = "<select name='search'>";

    if ($gconf['webactive']) {
        $sl_select .= "<option value='web'";

        if ('web' == $gconf['sldefault']) {
            $sl_select .= ' selected';
        }

        $sl_select .= '>' . $gconf['weblabel'] . '</option>';
    }

    if ($gconf['siteactive']) {
        $sl_select .= "<option value='site'";

        if ('site' == $gconf['sldefault']) {
            $sl_select .= ' selected';
        }

        $sl_select .= '>' . $gconf['sitelabel'] . '</option>';
    }

    if ($gconf['xoopsactive']) {
        $sl_select .= "<option value='xoops'";

        if ('xoops' == $gconf['sldefault']) {
            $sl_select .= ' selected';
        }

        $sl_select .= '>' . $gconf['xoopslabel'] . '</option>';
    }

    $sl_select .= '</select>';

    return $sl_select;
}

function makeSLRadio($gconf)
{
    if ($_GET['search']) {
        $gconf['sldefault'] = $_GET['search'];
    }

    if ($gconf['webactive']) {
        $sl_select .= "<input type='radio' name='search' value='web'";

        if ('web' == $gconf['sldefault']) {
            $sl_select .= ' checked';
        }

        $sl_select .= '>' . $gconf['weblabel'] . ' &nbsp; ';
    }

    if ($gconf['siteactive']) {
        $sl_select .= "<input type='radio' name='search' value='site'";

        if ('site' == $gconf['sldefault']) {
            $sl_select .= ' checked';
        }

        $sl_select .= '>' . $gconf['sitelabel'] . ' &nbsp; ';
    }

    if ($gconf['xoopsactive']) {
        $sl_select .= "<input type='radio' name='search' value='xoops'";

        if ('xoops' == $gconf['sldefault']) {
            $sl_select .= ' checked';
        }

        $sl_select .= '>' . $gconf['xoopslabel'] . ' &nbsp; ';
    }

    return $sl_select;
}
