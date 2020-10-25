<?php
// $Id: admin.php,v 1.1 2006/03/10 20:15:07 mikhail Exp $

/* Main Info */
define('_XO_ADMIN_TITLE', 'XoOgle Admin');
define(
    '_XO_GOOGLE_KEY_INFO',
    '<p>In order to use Google Web APIs you first must register with Google to
receive an authentication key. You can do this online at the url below.
 Your key will have a limit on the number of requests a day that you can make.</p><p> The default limit is 1000 queries per day. If you have
problems with your key or getting the correct the daily quota of queries, please contact api-support@google.com.</p><p>Get your google key here: <a href=\'http://www.google.com/apis/\'>http://www.google.com/apis/</a>.</p>'
);

define('_XO_KEY_LABEL', 'Enter your Google Developer Key');

define('_XO_UPDATE_SUCCESS', 'Update Successful');
define('_XO_XOOGLE_BUTTON', 'Update XoOgle Settings');

define('_XO_NO_RESTRICTIONS', 'No Restrictions');
define('_XO_SHOW_IN_FORM', 'No Restrictions, Show in Form');

define('_XO_GOOGLE_LANG_INFO', '<p>To search for documents within a particular language, select that language from the list above.</p>');
define('_XO_LANG_LABEL', 'Select a Langugage Restriction');

define('_XO_LRINBLOCK_LABEL', 'Show language select in xoogle search block.');

define('_XO_SLOCATION_LABEL', 'Search Location Settings');
define('_XO_SLINBLOCK_LABEL', 'Show location select in xoogle search block.');
define('_XO_SLOCATION_DESC', 'Configure these options to set which locations you will allow your users to search.');
define('_XO_SEARCH_THIS_SITE', 'Search this site using the google api');
define('_XO_SEARCH_THE_WEB', 'Search the web using the google api');
define('_XO_XOOPS_SEARCH', 'Search using xoops module and system features');

define('_XO_LB_ACTIVE', 'Visible');
define('_XO_LB_DEFAULT', 'Default');
define('_XO_LB_SEARCH_FUNCTION', 'Search Location');
define('_XO_LB_LOCATION_LABEL', 'Label / Name');
