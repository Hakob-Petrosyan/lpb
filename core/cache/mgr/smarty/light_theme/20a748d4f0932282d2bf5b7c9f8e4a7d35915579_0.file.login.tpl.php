<?php
/* Smarty version 3.1.44, created on 2023-11-22 16:19:17
  from '/home/c80080/lpubm.na4u.ru/www/manager/templates/light_theme/security/login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.44',
  'unifunc' => 'content_655dffd5e34129_81069080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20a748d4f0932282d2bf5b7c9f8e4a7d35915579' => 
    array (
      0 => '/home/c80080/lpubm.na4u.ru/www/manager/templates/light_theme/security/login.tpl',
      1 => 1674502726,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655dffd5e34129_81069080 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/c80080/lpubm.na4u.ru/www/core/model/smarty/plugins/modifier.replace.php','function'=>'smarty_modifier_replace',),));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ($_smarty_tpl->tpl_vars['_config']->value['manager_direction'] == 'rtl') {?>dir="rtl"<?php }?> lang="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_lang_attribute'];?>
" xml:lang="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_lang_attribute'];?>
">
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_title'];?>
 | <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['_config']->value['site_name']), ENT_QUOTES, 'UTF-8', true);?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['_config']->value['modx_charset'];?>
" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php if ($_smarty_tpl->tpl_vars['_config']->value['manager_favicon_url']) {?><link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_favicon_url'];?>
" /><?php }?>

    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/resources/css/ext-all-notheme-min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/default/css/index<?php if ($_smarty_tpl->tpl_vars['_config']->value['compress_css']) {?>-min<?php }?>.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/default/css/login<?php if ($_smarty_tpl->tpl_vars['_config']->value['compress_css']) {?>-min<?php }?>.css" />
    
<?php if (!$_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 1) {?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/css/Gilroy.css" />
<?php }
if (!$_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 2) {?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet"> 
<?php }
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 3) {?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet"> 
<?php }?>

    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/css/login_custom.css" />

<?php if ((isset($_smarty_tpl->tpl_vars['_config']->value['ext_debug'])) && $_smarty_tpl->tpl_vars['_config']->value['ext_debug']) {?>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/adapter/ext/ext-base-debug.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/ext-all-debug.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php } else { ?>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/adapter/ext/ext-base.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
assets/ext3/ext-all.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php }?>
    <?php echo '<script'; ?>
 src="assets/modext/core/modx.js" type="text/javascript"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/modext/core/modx.component.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/modext/util/utilities.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/modext/widgets/core/modx.panel.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/modext/widgets/core/modx.window.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/modext/sections/login.js" type="text/javascript"><?php echo '</script'; ?>
>

    <meta name="robots" content="noindex, nofollow" />
    
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
if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_font'] == 3) {?>"Roboto"<?php }?>;
}
</style>

</head>

<body id="login">
<?php echo $_smarty_tpl->tpl_vars['onManagerLoginFormPrerender']->value;?>



<div class="row no-gutters min-vh-100">
    <div class="col-6 d-flex">
        <div class="bg_txt">
            
            
            <div id="container">
    <div id="modx-login-logo">
        <?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_logo']) {?>
            <div class="lg_logo"><img alt="MODX CMS/CMF" src="<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_logo'];?>
" class="lg_theme_auth_logo" /></div>
        <?php } else { ?>
        <img alt="MODX CMS/CMF" src="<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/default/images/modx-logo-color.svg" />
        <?php }?>
    </div>

    <div id="modx-panel-login-div" class="x-panel modx-form x-form-label-right">
        <form id="modx-login-form" action="" method="post">
            <input type="hidden" name="login_context" value="mgr" />
            <input type="hidden" name="modahsh" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['modahsh']->value)===null||$tmp==='' ? '' : $tmp);?>
" />
            <input type="hidden" name="returnUrl" value="<?php echo $_smarty_tpl->tpl_vars['returnUrl']->value;?>
" />

            <div class="x-panel x-panel-noborder">
                <div class="x-panel-bwrap">
                    <div class="x-panel-body x-panel-body-noheader">
                        <h2><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['_config']->value['site_name']), ENT_QUOTES, 'UTF-8', true);?>
</h2>
                        <br class="clear" />
                        <?php if ((isset($_smarty_tpl->tpl_vars['error_message']->value)) && $_smarty_tpl->tpl_vars['error_message']->value) {?>
                            <p class="error"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['error_message']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
                        <?php } elseif ((isset($_smarty_tpl->tpl_vars['success_message']->value)) && $_smarty_tpl->tpl_vars['success_message']->value) {?>
                            <p class="success"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['success_message']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="x-form-item login-form-item login-form-item-first">
                
                <div class="x-form-element login-form-element">
                    <input placeholder="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_username'];?>
" type="text" id="modx-login-username" name="username" autocomplete="on" autofocus value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_post']->value['username'])===null||$tmp==='' ? '' : $tmp);?>
" class="x-form-text x-form-field" aria-required="true" required />
                </div>
            </div>

            <div class="x-form-item login-form-item">
                <div class="x-form-element login-form-element">
                    <input  placeholder="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_password'];?>
" type="password" id="modx-login-password" name="password" autocomplete="on" class="x-form-text x-form-field" aria-required="true" required />
                </div>
            </div>

            <div class="login-cb-row">
                <div class="login-cb-col one">
                    <div class="modx-login-fl-link">
<?php if ((($tmp = @$_smarty_tpl->tpl_vars['allow_forgot_password']->value)===null||$tmp==='' ? '' : $tmp)) {?>
                        <a href="javascript:void(0);" id="modx-fl-link" style="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['_post']->value['username_reset'])===null||$tmp==='' ? '' : $tmp)) {?>display:none;<?php }?>"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_forget_your_login'];?>
</a>
<?php }?>
                    </div>
                </div>
                <div class="login-cb-col two">
                    <!--<div class="x-form-check-wrap modx-login-rm-cb">
                        <input type="checkbox" id="modx-login-rememberme" name="rememberme" autocomplete="on" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['_post']->value['rememberme'])===null||$tmp==='' ? '' : $tmp)) {?>checked="checked"<?php }?> class="x-form-checkbox x-form-field" value="1" />
                        <label for="modx-login-rememberme" class="x-form-cb-label"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_remember'];?>
</label>
                    </div>
                    -->
                    <button class="x-btn x-btn-small x-btn-icon-small-left primary-button x-btn-noicon login-form-btn" name="login" type="submit" value="1" id="modx-login-btn"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_button'];?>
</button>
                </div>
            </div>

            <?php echo $_smarty_tpl->tpl_vars['onManagerLoginFormRender']->value;?>

        </form>

<?php if ((($tmp = @$_smarty_tpl->tpl_vars['allow_forgot_password']->value)===null||$tmp==='' ? '' : $tmp)) {?>
        <div class="modx-forgot-login">
            <form id="modx-fl-form" action="" method="post">
                <div id="modx-forgot-login-form" style="<?php if (!(($tmp = @$_smarty_tpl->tpl_vars['_post']->value['username_reset'])===null||$tmp==='' ? '' : $tmp)) {?>display: none;<?php }?>">
                    <div class="x-form-item login-form-item">
                        <div class="x-form-element login-form-element">
                            <input type="text" id="modx-login-username-reset" name="username_reset" class="x-form-text x-form-field" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_post']->value['username_reset'])===null||$tmp==='' ? '' : $tmp);?>
" placeholder="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_username_or_email'];?>
" />
                        </div>
                        <div class="x-form-clear-left"></div>
                    </div>

                    <button class="x-btn x-btn-small x-btn-icon-small-left primary-button x-btn-noicon login-form-btn" name="forgotlogin" type="submit" value="1" id="modx-fl-btn"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['login_send_activation_email'];?>
</button>
                </div>
            </form>
        </div>
<?php }?>
        <br class="clear" />
    </div>

    <p class="loginLicense"><?php ob_start();
echo date('Y');
$_prefixVariable1 = ob_get_clean();
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['_lang']->value['login_copyright'],'[[+current_year]]',$_prefixVariable1);?>
</p>
</div>

<div id="modx-login-language-select-div">
    <label id="modx-login-language-select-label"><?php echo $_smarty_tpl->tpl_vars['language_str']->value;?>
:
        <select name="cultureKey" id="modx-login-language-select" aria-labeled-by="modx-login-language-select-label">
<?php echo preg_replace('!^!m',str_repeat(' ',12),$_smarty_tpl->tpl_vars['languages']->value);?>

        </select>
    </label>
</div>
            
            
        </div>
    </div>
    
    <div class="col-6 d-flex p_rv">
<?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_bgphoto']) {?>        
    <div class="bg" style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_bgphoto'];?>
')"></div>
<?php } else { ?>
    <div class="bg" style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['_config']->value['manager_url'];?>
templates/light_theme/images/login_bg.jpeg')"></div>
<?php }?>
        <div class="bg_txt">
            <div class="col_txt">
            <div class="small_txt"><?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_title'];?>
</div>
            <div class="big_txt"><?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_txt'];?>
</div>
            <?php if ($_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_web']) {?><div class="link_txt"><a href="<?php echo $_smarty_tpl->tpl_vars['modx']->value->config['lg_theme_auth_web'];?>
" target="_blank" >Перейти</a></div><?php }?>
            </div>
        </div>
    </div>
</div>


</body>
</html>
<?php }
}
