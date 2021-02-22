<?php
// +-----------------------------------------------------------------------+
// | DAW Hidden Description plugin for Piwigo by DAW                       |
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


//------- add prefiltre photo ----------------
add_event_handler('loc_begin_admin', 'hiddenDescPic', 55);
add_event_handler('loc_begin_admin_page', 'hiddenDescPicReadUpdate', 55);

function hiddenDescPic()
{
	global $template;
	$template->set_prefilter('picture_modify', 'hiddenDescPicShow');
}

function hiddenDescPicShow($content, &$smarty)
{
	$search = '#<input type="hidden" name="pwg_token"#';
	$replacement = '
	<p>
      <strong>{\'Hidden Description\'|@translate}</strong>
      <br>
	  <span">{\'Only visible on administration pages\'|@translate}</span>
	  <br>
      <span><textarea rows="2" cols="60" name="hiddenImgDesc" id="hiddenImgDesc" class="hiddenImgDesc">{$hiddenImgCONTENT}</textarea></span>
	</p>  
	<input type="hidden" name="pwg_token"';
	return preg_replace($search, $replacement, $content);
}

function hiddenDescPicReadUpdate()
{
	if (isset($_GET['image_id'])) {
		global $template, $prefixeTable, $pwg_loaded_plugins;
		$query = 'SELECT id,hiddenimg FROM ' . daw_hidden_img_TABLE . ' WHERE id = ' . $_GET['image_id'] . ';';
		$result = pwg_query($query);
		$row = pwg_db_fetch_assoc($result);
		if ($row != null) {
			$template->assign(
				array(
					'hiddenImgCONTENT' => $row['hiddenimg'],
				)
			);
		}
	}
	if (isset($_POST['hiddenImgDesc'])) {
		$query = 'DELETE FROM ' . daw_hidden_img_TABLE . ' WHERE id = ' . $_GET['image_id'] . ';';
		$result = pwg_query($query);
		$q = 'INSERT INTO ' . $prefixeTable . 'daw_hidden_img(id,hiddenimg)VALUES (' . $_GET['image_id'] . ',"' . $_POST['hiddenImgDesc'] . '");';
		pwg_query($q);
		$template->assign(
			array(
				'hiddenImgCONTENT' => $_POST['hiddenImgDesc'],
			)
		);
	}
}

//------- add prefiltre album --------------
add_event_handler('loc_begin_admin', 'hiddenDescCat');
add_event_handler('loc_begin_admin_page', 'hiddenDescCatReadUpdate');

function hiddenDescCat()
{
	global $template;
	$template->set_prefilter('album_properties', 'hiddenDescCatShow');
}

function hiddenDescCatShow($content, &$smarty)
{
	$search = '#<p style="margin:0">#';
	$replacement = '
	<p>
      <strong>{\'Hidden Description\'|@translate}</strong>
      <br>
	  <span>{\'Only visible on administration pages\'|@translate}</span>
	  <br>
      <span><textarea rows="2" cols="60" name="hiddenCatDesc" id="hiddenCatDesc" class="hiddenCatDesc">{$hiddenCatCONTENT}</textarea></span>
	</p>  
    <p style="margin:0">';
	return preg_replace($search, $replacement, $content);
}

function hiddenDescCatReadUpdate()
{
	if (isset($_GET['cat_id'])) {
		global $template, $prefixeTable, $pwg_loaded_plugins;
		$query = 'SELECT id,hiddenCat FROM ' . daw_hidden_cat_TABLE . ' WHERE id = ' . $_GET['cat_id'] . ';';
		$result = pwg_query($query);
		$row = pwg_db_fetch_assoc($result);
		if ($row != null) {
			$template->assign(
				array(
					'hiddenCatCONTENT' => $row['hiddenCat']
				)
			);
		}
	}

	if (isset($_POST['hiddenCatDesc'])) {
		$query = 'DELETE FROM ' . daw_hidden_cat_TABLE . ' WHERE id = ' . $_GET['cat_id'] . ';';
		$result = pwg_query($query);
		$q = 'INSERT INTO ' . $prefixeTable . 'daw_hidden_cat(id,hiddencat) VALUES (' . $_GET['cat_id'] . ',"' . $_POST['hiddenCatDesc'] . '");';
		pwg_query($q);
		$template->assign(
			array(
				'hiddenCatCONTENT' => $_POST['hiddenCatDesc']
			)
		);
	}
}
