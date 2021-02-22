<?php
// +-----------------------------------------------------------------------+
// | Hidden plugin for Piwigo by DAW                                      |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2021 ddtddt               http://temmii.com/piwigo/ |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

class daw_hidden_maintain extends PluginMaintain
{
    function install($plugin_version, &$errors = array())
    {
        global $conf, $prefixeTable;

        if (!defined('daw_hidden_img_TABLE'))
            define('daw_hidden_img_TABLE', $prefixeTable . 'daw_hidden_img');
        $query = "CREATE TABLE IF NOT EXISTS " . daw_hidden_img_TABLE . " (
            id SMALLINT( 5 ) UNSIGNED NOT NULL ,
            hiddenimg LONGTEXT NOT NULL ,
            PRIMARY KEY (id))DEFAULT CHARSET=utf8;";
        $result = pwg_query($query);

        if (!defined('daw_hidden_cat_TABLE'))
            define('daw_hidden_cat_TABLE', $prefixeTable . 'daw_hidden_cat');
        $query = "CREATE TABLE IF NOT EXISTS " . daw_hidden_cat_TABLE . " (
            id SMALLINT( 5 ) UNSIGNED NOT NULL ,
            hiddencat LONGTEXT NOT NULL ,
            PRIMARY KEY (id))DEFAULT CHARSET=utf8;";
        $result = pwg_query($query);

        $majm1 = 'DAW Hidden 1.0.0';
        $query = 'INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("' . $majm1 . '",1,"MAJ daw hidden");';
        pwg_query($query);

        if (empty($conf['contactmeta'])) {
            conf_update_param('contactmeta', '');
        }
    }

    function update($old_version, $new_version, &$errors = array())
    {
        global $prefixeTable, $template;
 
        if (!isset($conf['contactmeta'])) {
            conf_update_param('contactmeta', ',');
        }

        //Gestion MAJ2
        $majm2 = 'DAW Hidden 1.0.0';
        $query = '
            select param,value
	        FROM ' . CONFIG_TABLE . '
            WHERE param = \'' . $majm2 . '\'
	        ;';
        $result = pwg_query($query);

        $row = pwg_db_fetch_assoc($result);
        $majparam2 = $row['param'];
        $majvalue2 = $row['value'];

        if (!$majvalue2 == 1) {

            //Gestion MAJ1
            $majm1 = 'DAW Hidden 1.0.0';
            $query = '
            select param,value
	        FROM ' . CONFIG_TABLE . '
            WHERE param = \'' . $majm1 . '\'
	        ;';
            $result = pwg_query($query);

            $row = pwg_db_fetch_assoc($result);
            $majparam1 = $row['param'];
            $majvalue1 = $row['value'];

            if (!$majvalue1 == 1) {
                if (!defined('daw_hidden_img_TABLE'))
                    define('daw_hidden_img_TABLE', $prefixeTable . 'daw_hidden_img');
                $query = "CREATE TABLE IF NOT EXISTS " . daw_hidden_img_TABLE . " (
                    id SMALLINT( 5 ) UNSIGNED NOT NULL ,
                    hiddenimg LONGTEXT NOT NULL ,
                    PRIMARY KEY (id))DEFAULT CHARSET=utf8;";
                $result = pwg_query($query);

                if (!defined('daw_hidden_cat_TABLE'))
                    define('daw_hidden_cat_TABLE', $prefixeTable . 'daw_hidden_cat');
                $query = "CREATE TABLE IF NOT EXISTS " . daw_hidden_cat_TABLE . " (
                    id SMALLINT( 5 ) UNSIGNED NOT NULL ,
                    hiddencat LONGTEXT NOT NULL ,
                    PRIMARY KEY (id))DEFAULT CHARSET=utf8;";
                $result = pwg_query($query);

                $query = '
                select id
                FROM ' . CATEGORIES_TABLE . '
                ORDER BY id DESC;';
                $result = pwg_query($query);
                $row = pwg_db_fetch_assoc($result);

                $comp = $row['id'] + 1;
                $i = 1;

                while ($i < $comp) {
                    $query = '
                    select id,hiddenKeywords
                    FROM ' . CATEGORIES_TABLE . '
                    WHERE id = \'' . $i . '\'';
                    $result = pwg_query($query);
                    $row = pwg_db_fetch_assoc($result);

                    if (!$row['id'] == 0 and !$row['hiddenKeywords'] == 0) {
                        $query = '
                        INSERT INTO ' . $prefixeTable . 'daw_hidden_cat(id,hiddencat)VALUES (' . $row['id'] . ',"' . $row['hiddenKeywords'] . '");';
                        $result = pwg_query($query);
                    }
                    ++$i;
                }

                $query = ' ALTER TABLE ' . CATEGORIES_TABLE . ' DROP COLUMN `hiddenKeywords`';
                pwg_query($query);

                $query = 'INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("' . $majm1 . '",1,"MAJ daw hidden");';
                pwg_query($query);
                $majvalue1 == 1;
                $maj = 0;
            }

            $query = 'INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("' . $majm2 . '",1,"MAJ daw hidden");';
            pwg_query($query);

            $template->delete_compiled_templates(array('plugin_admin_content' => dirname(__FILE__) . '/admin.tpl'));

            $majvalue2 == 1;
            $maj = 0;
        }
    }

    function uninstall()
    {
        $majm1 = 'DAW Hidden 1.0.0';
        $majm2 = 'DAW Hidden 1.0.0';

        global $prefixeTable;

        $q = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE param="' . $majm1 . '" LIMIT 1;';
        pwg_query($q);

        $q = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE param="' . $majm2 . '" LIMIT 1;';
        pwg_query($q);

        $q = 'DROP TABLE ' . $prefixeTable . 'daw_hidden_img;';
        pwg_query($q);

        $q = 'DROP TABLE ' . $prefixeTable . 'daw_hidden_cat;';
        pwg_query($q);

        conf_delete_param('contactmeta');
    }
}
