<?php
/*
Plugin Name: Personal Plugin
*/

if (!defined('PHPWG_ROOT_PATH')) {
  die('Hacking attempt!');
}

defined('AMM_DIR') || define('AMM_DIR', basename(dirname(__FILE__)));
defined('AMM_PATH') || define('AMM_PATH', PHPWG_PLUGINS_PATH . AMM_DIR . '/');

add_event_handler('loc_end_page_header', 'add_features');

function console_log($data)
{
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}

/*
Callback für das event loc_end_page_header
*/
function add_features()
{
  global $template;
  global $user;

  $template->set_prefilter('header', 'scroll_to_top_pref', 100);

  if ($user["level"] != 8) {
    $template->set_prefilter('header', 'adjust_admin_pages', 100);
  }
}

/*
Nur Nutzer mit Datenschutzlevel Administrator dürfen Bilder oder Alben löschen. 
*/
function adjust_admin_pages($content)
{
  global $pwg_loaded_plugins;

  $adminToolsInstalled = false;
  if (isset($pwg_loaded_plugins['AdminTools'])) {
    console_log("test");
    $adminToolsInstalled = true;
  }

  console_log($adminToolsInstalled);

  $search = '<body id="{$BODY_ID}">';
  $scroll = '
  <script type="text/JavaScript" src="plugins/PersonalPlugin/main.js"></script>
  {footer_script}
  {literal}
  $( document ).ready(function() {
    //console.log( "ready!" );
    adjustAdminPages();
    adjustPluginAdminTools(' . $adminToolsInstalled . ');
  });
  {/literal}{/footer_script}
  ';

  return str_replace($search, $search . $scroll, $content);
}

/*
Scollt der Nutzer runter wird rechts unten ein Pfeil angezeigt um schnell
wieder nach oben zu springen 
*/

function scroll_to_top_pref($content)
{
  $search = '<body id="{$BODY_ID}">';
  $scroll = '
    {html_style}{literal}
      .scrollup {
          width:64px; height:64px; opacity:0.7; position:fixed; border-radius:24px;
          bottom:4px; right:50px; display:none; text-indent:-9999px;
          background: transparent url("piwigo-logos/up_arrow.png") no-repeat;
          z-index:1000; border:none !important; text-decoration:none !important;
      }
      .scrollup:hover { opacity:1; }
    {/literal}{/html_style}
    {footer_script}{literal}
      jQuery(window).scroll(function(){
        if (jQuery(this).scrollTop() > 100) {
          jQuery(".scrollup").fadeIn();
        } else {
          jQuery(".scrollup").fadeOut();
        }
      });
      jQuery(".scrollup").click(function(){
        jQuery("html, body").animate({ scrollTop: 0 }, 600);
        return false;
      });
    {/literal}{/footer_script}
    <a href="#" class="scrollup">Scroll</a>';

  return str_replace($search, $search . $scroll, $content);
}

?>