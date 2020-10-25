<?php
// $Id: index.php,v 1.2 2006/03/19 20:06:20 mikhail Exp $

include '../../../mainfile.php';
include '../../../include/cp_header.php';
require_once '../include/xoogle.php';

// get our configs
$gconf = getGoogleConfig();

if ('' != $_POST['google_key']) {
    $google_key = updateGoogleKey($_POST);

    $updated = true;
} else {
    $google_key = $gconf['google_key'];
}

// if updated, let's update our configs array
if ($updated) {
    $gconf = getGoogleConfig();
}

if ($gconf['siteactive']) {
    $siteactive = 'checked';
}
if ($gconf['webactive']) {
    $webactive = 'checked';
}
if ($gconf['xoopsactive']) {
    $xoopsactive = 'checked';
}

if ('site' == $gconf['sldefault']) {
    $sitedefault = 'checked';
}
if ('web' == $gconf['sldefault']) {
    $webdefault = 'checked';
}
if ('xoops' == $gconf['sldefault']) {
    $xoopsdefault = 'checked';
}

if (1 == $gconf['lrinblock']) {
    $lrinblock = 'checked';
}
if (1 == $gconf['slinblock']) {
    $slinblock = 'checked';
}

// get the google language restrictions to display in form
$google_lr = googleLangRestrictions();

xoops_cp_header();

if ($updated) {
    echo('<p><b>' . _XO_UPDATE_SUCCESS . '</b></p>');
}

echo('<h2>' . _XO_ADMIN_TITLE . '</h2>');
?>
    <table class="outer" cellpadding="10" cellspacing="1">
        <form action="<?php print XOOPS_URL ?>/modules/xoogle/admin/index.php" method="post">
            <tr>
                <td class="odd">
                    <?php
                    echo('<b>' . _XO_KEY_LABEL . '</b>');
                    ?>

                    <input type="text" name="google_key" size="50" value="<?php print $google_key; ?>">

                    <?php
                    echo(_XO_GOOGLE_KEY_INFO);
                    ?>
                </td>
            </tr>
            <tr>
                <td class="even">
                    <p><b>
                            <?php
                            echo(_XO_LANG_LABEL);
                            ?></b> &nbsp;
                        <select name="lr">
                            <option value='no_lr'<?php if ('no_lr' == $gconf['google_lr']) {
                                print ' selected';
                            } ?>><?php print _XO_NO_RESTRICTIONS ?></option>
                            <option value='show_form'<?php if ('show_form' == $gconf['google_lr']) {
                                print ' selected';
                            } ?>><?php print _XO_SHOW_IN_FORM ?></option>
                            <?php
                            foreach ($google_lr as $lr) {
                                print "<option value='" . $lr['code'] . "'";

                                if ($gconf['google_lr'] == $lr['code']) {
                                    print ' selected';
                                }

                                print '>' . $lr['label'] . '</option>';
                            }
                            ?>
                        </select><br>
                    <p>
                        <?php
                        echo(_XO_GOOGLE_LANG_INFO);
                        ?></p>
                    <p>
                        <input type="checkbox" name="lrinblock" value="1" <?php print $lrinblock ?>><?php
                        echo(_XO_LRINBLOCK_LABEL); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="odd">
                    <b><?php print(_XO_SLOCATION_LABEL); ?></b>
                    <p><?php print(_XO_SLOCATION_DESC); ?></p>
                    <p><input type="checkbox" name="slinblock" value="1" <?php print $slinblock ?>><?php
                        echo(_XO_SLINBLOCK_LABEL); ?></p>

                    <table cellpadding="5">
                        <tr>
                            <td><b><?php print(_XO_LB_ACTIVE); ?></b></td>
                            <td><b><?php print(_XO_LB_DEFAULT); ?></b></td>
                            <td><b><?php print(_XO_LB_SEARCH_FUNCTION); ?></b></td>
                            <td><b><?php print(_XO_LB_LOCATION_LABEL); ?></b></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="siteactive" value="1" <?php print $siteactive ?>></td>
                            <td><input type="radio" name="sldefault" value="site" <?php print $sitedefault ?>></td>
                            <td><?php print(_XO_SEARCH_THIS_SITE); ?></td>
                            <td><input type="text" name="sitelabel" value="<?php print($gconf['sitelabel']); ?>"></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="webactive" value="1" <?php print $webactive ?>></td>
                            <td><input type="radio" name="sldefault" value="web" <?php print $webdefault ?>></td>
                            <td><?php print(_XO_SEARCH_THE_WEB); ?></td>
                            <td><input type="text" name="weblabel" value="<?php print($gconf['weblabel']); ?>"></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="xoopsactive" value="1" <?php print $xoopsactive ?>></td>
                            <td><input type="radio" name="sldefault" value="xoops" <?php print $xoopsdefault ?>></td>
                            <td><?php print(_XO_XOOPS_SEARCH); ?></td>
                            <td><input type="text" name="xoopslabel" value="<?php print $gconf['xoopslabel']; ?>"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="<?php print _XO_XOOGLE_BUTTON ?>">
                </td>
            </tr>
        </form>
    </table>


<?php
xoops_cp_footer();
?>
