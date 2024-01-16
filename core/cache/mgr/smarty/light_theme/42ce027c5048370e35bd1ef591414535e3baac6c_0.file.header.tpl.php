<?php
/* Smarty version 3.1.44, created on 2023-11-22 16:19:34
  from '/home/c80080/lpubm.na4u.ru/www/manager/templates/light_theme/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.44',
  'unifunc' => 'content_655dffe63752a3_45686832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42ce027c5048370e35bd1ef591414535e3baac6c' => 
    array (
      0 => '/home/c80080/lpubm.na4u.ru/www/manager/templates/light_theme/header.tpl',
      1 => 1674502724,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655dffe63752a3_45686832 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_direction'];?>
" lang="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_lang_attribute'];?>
" xml:lang="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_lang_attribute'];?>
">
<head>
<title><?php if ($_smarty_tpl->tpl_vars['_pagetitle']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_pagetitle']->value, ENT_QUOTES, 'UTF-8', true);?>
 | <?php }
echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['_config']->value['site_name']), ENT_QUOTES, 'UTF-8', true);?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['_config']->value['modx_charset'];?>
" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php if ($_smarty_tpl->tpl_vars['_config']->value['manager_favicon_url']) {?><link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_favicon_url'];?>
" /><?php }?>

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/resources/css/ext-all-notheme-min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['indexCss']->value;?>
?v=<?php echo $_smarty_tpl->tpl_vars['versionToken']->value;?>
" />

<?php if ((isset($_smarty_tpl->tpl_vars['_config']->value['ext_debug'])) && $_smarty_tpl->tpl_vars['_config']->value['ext_debug']) {
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/adapter/ext/ext-base-debug.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/ext-all-debug.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php } else {
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/adapter/ext/ext-base.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/ext-all.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php }
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/modext/core/modx.js?v=<?php echo $_smarty_tpl->tpl_vars['versionToken']->value;?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['connectors_url'];?>
lang.js.php?ctx=mgr&topic=topmenu,file,resource,trash,<?php echo $_smarty_tpl->tpl_vars['_lang_topics']->value;?>
&action=<?php echo htmlspecialchars((($tmp = @$_GET['a'])===null||$tmp==='' ? '' : $tmp));?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['connectors_url'];?>
modx.config.js.php?action=<?php echo htmlspecialchars((($tmp = @$_GET['a'])===null||$tmp==='' ? '' : $tmp));
if ($_smarty_tpl->tpl_vars['_ctx']->value) {?>&wctx=<?php echo $_smarty_tpl->tpl_vars['_ctx']->value;
}?>&HTTP_MODAUTH=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['_authToken']->value)===null||$tmp==='' ? '' : $tmp));?>
"><?php echo '</script'; ?>
>


<style>
:root {
<?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_txt_color']) {?>--color_one:<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_txt_color'];?>
;<?php } else { ?> --color_one:#333;<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_txt_color_ok']) {?>--color_two:<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_txt_color_ok'];?>
;<?php } else { ?>--color_two:#6fb61d;<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_color']) {?>--color_three:<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_bg_color'];?>
;<?php } else { ?>--color_three:#283593;<?php }?>   
 --font_one:<?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 1) {?>Gilroy<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 2) {?>"Open Sans"<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 3) {?>"Roboto"<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 4) {?>"Circe"<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 5) {?>"GothamPro"<?php }?>;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/css/style.css?v=<?php echo $_smarty_tpl->tpl_vars['versionToken']->value;?>
" />

<?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 1) {?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/css/Gilroy.css" />
<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 2) {?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet"> 
<?php }?>   
<?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 3) {?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet"> 
<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 4) {?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/css/circe.css" />
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['maincssjs']->value;?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cssjs']->value, 'scr');
$_smarty_tpl->tpl_vars['scr']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['scr']->value) {
$_smarty_tpl->tpl_vars['scr']->do_else = false;
echo $_smarty_tpl->tpl_vars['scr']->value;?>

<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php echo '<script'; ?>
 type="text/javascript">
    Ext.onReady(function() {
        // Enable site name tooltip (on overflow only)
        if( Ext.get('site_name').dom.scrollWidth > Ext.get('site_name').dom.clientWidth ){
          new Ext.ToolTip({
              title: Ext.get('site_name').dom.title
              ,target: Ext.get('site_name')
          });
        }
        <?php if ($_smarty_tpl->tpl_vars['_search']->value) {?>
        new MODx.SearchBar;
        <?php }?>
    });
<?php echo '</script'; ?>
>

</head>
<body id="modx-body-tag">

<div id="modx-browser"></div>
<div id="modx-container">
    <div id="modx-header">
        <div id="modx-navbar">
            <ul id="modx-user-menu">
                                <?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['userNav']->value, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
            </ul>

            <ul id="modx-topnav">
                
                    <?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_logo']) {?><li class="lg_theme_auth_logo"><a href="?"><img src="<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_logo'];?>
" ></a><?php } else { ?><li id="modx-home-dashboard"><a href="?" title="MODX <?php echo $_smarty_tpl->tpl_vars['_config']->value['settings_version'];?>
 (<?php echo $_smarty_tpl->tpl_vars['_config']->value['settings_distro'];?>
)
<?php echo $_smarty_tpl->tpl_vars['_lang']->value['dashboard'];?>
"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['dashboard'];?>
</a><?php }?>
                </li>
                <li id="modx-site-info">
                    <div id="site_name" class="info-item site_name" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['_config']->value['site_name']), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['_config']->value['site_name']), ENT_QUOTES, 'UTF-8', true);?>
</div>
                                        <div class="info-item full_appname">MODX Revolution <?php echo $_smarty_tpl->tpl_vars['_config']->value['settings_version'];?>
</div>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['_search']->value) {?>
                <li id="modx-manager-search-icon">
                    <a href="javascript:;" onclick="Ext.getCmp('modx-uberbar').toggle()" title="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['search'];?>
">
                        <span class="icon-stack icon-lg">
                          <i class="icon icon-square icon-stack-2x"></i>
                          <i class="icon icon-search icon-stack-1x"></i>
                        </span>
                    </a>
                </li>
                <?php }?>
                <?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['navb']->value, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
            </ul>
            <?php if ($_smarty_tpl->tpl_vars['_search']->value) {?>
            <div id="modx-manager-search" role="search"></div>
            <?php }?>
        </div>
    </div>
        <div id="modAB"></div>
        <div id="modx-leftbar"></div>
        <div id="modx-action-buttons-container"></div>
        <div id="modx-content">
            <div id="modx-panel-holder"></div>
<?php }
}
