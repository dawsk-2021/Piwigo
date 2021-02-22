<?php
/*
Plugin Name: DAW Hidden Field
Version: 11.0.a
Description: Allows to add additional description in the admin pages
Has Settings: webmaster
*/

// +-----------------------------------------------------------------------+
// | Hidden Description plugin for Piwigo by DAW                           |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2021 Digitales Archiv Woerrstadt                    |
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

if (!defined('PHPWG_ROOT_PATH'))
  die('Hacking attempt!');

global $prefixeTable, $page;

define('daw_hidden_DIR', basename(dirname(__FILE__)));
define('daw_hidden_PATH', PHPWG_PLUGINS_PATH . daw_hidden_DIR . '/');
define('daw_hidden_TABLE', $prefixeTable . 'meta');
define('daw_hidden_img_TABLE', $prefixeTable . 'daw_hidden_img');
define('daw_hidden_cat_TABLE', $prefixeTable . 'daw_hidden_cat');

add_event_handler('loading_lang', 'daw_hidden_loading_lang');
function daw_hidden_loading_lang()
{
  load_language('plugin.lang', daw_hidden_PATH);
}

// Plugin for admin
if (script_basename() == 'admin') {
  include_once(dirname(__FILE__) . '/initadmin.php');
}

//handle hidden description part
add_event_handler('loc_end_page_header', 'add_hiddencat', 61);
add_event_handler('loc_end_page_header', 'add_hiddenimg', 71);

function add_hiddencat()
{
  global $template, $page, $daw_hidden_infos;
  if (!empty($page['category']['id'])) {
    $query = 'SELECT id,hiddencat FROM ' . daw_hidden_cat_TABLE . ' WHERE id = \'' . $page['category']['id'] . '\';';
    $result = pwg_query($query);
    $row = pwg_db_fetch_assoc($result);
    if ($row != null) {
      $albumKeyED = trigger_change('AP_render_content', $row['hiddencat']);
      if (!empty($row['hiddencat'])) {
        $template->append('related_tags', array('name' => $albumKeyED));
      }
    }
  }
}

function add_hiddenimg()
{
  global $template, $page, $daw_hidden_infos;
  if (!empty($page['image_id'])) {
    $query = 'SELECT id,hiddenimg FROM ' . daw_hidden_img_TABLE . ' WHERE id = \'' . $page['image_id'] . '\';';
    $result = pwg_query($query);
    $row = pwg_db_fetch_assoc($result);
    if ($row != null) {
      $photoKeyED = trigger_change('AP_render_content', $row['hiddenimg']);
      if (!empty($row['hiddenimg'])) {
        $template->append('related_tags', array('name' => $photoKeyED));
      }
      $photoDesED = trigger_change('AP_render_content', $row['hiddenimg']);
    }
    if (!empty($row['metadesimg'])) {
      $template->assign('PLUG_META', $photoDesED);
    } else {
      $daw_hidden_infosph = array();
      $daw_hidden_infosph['title'] = $template->get_template_vars('PAGE_TITLE');
      $daw_hidden_infosph['gt'] = $template->get_template_vars('GALLERY_TITLE');
      $daw_hidden_infosph['descimg'] = $template->get_template_vars('COMMENT_IMG');
      if (!empty($daw_hidden_infosph['descimg'])) {
        $template->assign('PLUG_META', strip_tags($daw_hidden_infosph['descimg']) . ' - ' . $daw_hidden_infosph['title']);
      } else {
        $template->assign('PLUG_META', $daw_hidden_infosph['title'] . ' - ' . $daw_hidden_infosph['gt']);
      }
    }
  }
}