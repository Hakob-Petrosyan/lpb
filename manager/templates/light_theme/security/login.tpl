<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $_config.manager_direction EQ 'rtl'}dir="rtl"{/if} lang="{$_config.manager_lang_attribute}" xml:lang="{$_config.manager_lang_attribute}">
<head>
    <title>{$_lang.login_title} | {$_config.site_name|strip_tags|escape}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$_config.modx_charset}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {if $_config.manager_favicon_url}<link rel="shortcut icon" type="image/x-icon" href="{$_config.manager_favicon_url}" />{/if}

    <link rel="stylesheet" type="text/css" href="{$_config.manager_url}assets/ext3/resources/css/ext-all-notheme-min.css" />
	<link rel="stylesheet" type="text/css" href="{$_config.manager_url}templates/default/css/index{if $_config.compress_css}-min{/if}.css" />
    <link rel="stylesheet" type="text/css" href="{$_config.manager_url}templates/default/css/login{if $_config.compress_css}-min{/if}.css" />
    
{if !$modx->config['lg_theme_font']==1}
<link rel="stylesheet" type="text/css" href="{$_config.manager_url}templates/light_theme/css/Gilroy.css" />
{/if}
{if !$modx->config['lg_theme_font']==2}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet"> 
{/if}
{if $modx->config['lg_theme_font']==3}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet"> 
{/if}

    <link rel="stylesheet" type="text/css" href="{$_config.manager_url}templates/light_theme/css/login_custom.css" />

{if isset($_config.ext_debug) && $_config.ext_debug}
    <script src="{$_config.manager_url}assets/ext3/adapter/ext/ext-base-debug.js" type="text/javascript"></script>
    <script src="{$_config.manager_url}assets/ext3/ext-all-debug.js" type="text/javascript"></script>
{else}
    <script src="{$_config.manager_url}assets/ext3/adapter/ext/ext-base.js" type="text/javascript"></script>
    <script src="{$_config.manager_url}assets/ext3/ext-all.js" type="text/javascript"></script>
{/if}
    <script src="assets/modext/core/modx.js" type="text/javascript"></script>

    <script src="assets/modext/core/modx.component.js" type="text/javascript"></script>
    <script src="assets/modext/util/utilities.js" type="text/javascript"></script>
    <script src="assets/modext/widgets/core/modx.panel.js" type="text/javascript"></script>
    <script src="assets/modext/widgets/core/modx.window.js" type="text/javascript"></script>
    <script src="assets/modext/sections/login.js" type="text/javascript"></script>

    <meta name="robots" content="noindex, nofollow" />
    
<style>
:root {
{if $modx->config['lg_theme_bg_txt_color']}--color_one:{$modx->config['lg_theme_bg_txt_color']};{else} --color_one:#333;{/if}
{if $modx->config['lg_theme_bg_txt_color_ok']}--color_two:{$modx->config['lg_theme_bg_txt_color_ok']};{else}--color_two:#6fb61d;{/if}
{if $modx->config['lg_theme_bg_color']}--color_three:{$modx->config['lg_theme_bg_color']};{else}--color_three:#283593;{/if}   
--font_one:{if $modx->config['lg_theme_font']==1}Gilroy{/if}{if $modx->config['lg_theme_font']==2}"Open Sans"{/if}{if $modx->config['lg_theme_font']==3}"Roboto"{/if};
}
</style>

</head>

<body id="login">
{$onManagerLoginFormPrerender}


<div class="row no-gutters min-vh-100">
    <div class="col-6 d-flex">
        <div class="bg_txt">
            
            
            <div id="container">
    <div id="modx-login-logo">
        {if $modx->config['lg_theme_auth_logo']}
            <div class="lg_logo"><img alt="MODX CMS/CMF" src="{$modx->config['lg_theme_auth_logo']}" class="lg_theme_auth_logo" /></div>
        {else}
        <img alt="MODX CMS/CMF" src="{$_config.manager_url}templates/default/images/modx-logo-color.svg" />
        {/if}
    </div>

    <div id="modx-panel-login-div" class="x-panel modx-form x-form-label-right">
        <form id="modx-login-form" action="" method="post">
            <input type="hidden" name="login_context" value="mgr" />
            <input type="hidden" name="modahsh" value="{$modahsh|default}" />
            <input type="hidden" name="returnUrl" value="{$returnUrl}" />

            <div class="x-panel x-panel-noborder">
                <div class="x-panel-bwrap">
                    <div class="x-panel-body x-panel-body-noheader">
                        <h2>{$_config.site_name|strip_tags|escape}</h2>
                        <br class="clear" />
                        {if isset($error_message) && $error_message}
                            <p class="error">{$error_message|default}</p>
                        {elseif isset($success_message) && $success_message}
                            <p class="success">{$success_message|default}</p>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="x-form-item login-form-item login-form-item-first">
                
                <div class="x-form-element login-form-element">
                    <input placeholder="{$_lang.login_username}" type="text" id="modx-login-username" name="username" autocomplete="on" autofocus value="{$_post.username|default}" class="x-form-text x-form-field" aria-required="true" required />
                </div>
            </div>

            <div class="x-form-item login-form-item">
                <div class="x-form-element login-form-element">
                    <input  placeholder="{$_lang.login_password}" type="password" id="modx-login-password" name="password" autocomplete="on" class="x-form-text x-form-field" aria-required="true" required />
                </div>
            </div>

            <div class="login-cb-row">
                <div class="login-cb-col one">
                    <div class="modx-login-fl-link">
{if $allow_forgot_password|default}
                        <a href="javascript:void(0);" id="modx-fl-link" style="{if $_post.username_reset|default}display:none;{/if}">{$_lang.login_forget_your_login}</a>
{/if}
                    </div>
                </div>
                <div class="login-cb-col two">
                    <!--<div class="x-form-check-wrap modx-login-rm-cb">
                        <input type="checkbox" id="modx-login-rememberme" name="rememberme" autocomplete="on" {if $_post.rememberme|default}checked="checked"{/if} class="x-form-checkbox x-form-field" value="1" />
                        <label for="modx-login-rememberme" class="x-form-cb-label">{$_lang.login_remember}</label>
                    </div>
                    -->
                    <button class="x-btn x-btn-small x-btn-icon-small-left primary-button x-btn-noicon login-form-btn" name="login" type="submit" value="1" id="modx-login-btn">{$_lang.login_button}</button>
                </div>
            </div>

            {$onManagerLoginFormRender}
        </form>

{if $allow_forgot_password|default}
        <div class="modx-forgot-login">
            <form id="modx-fl-form" action="" method="post">
                <div id="modx-forgot-login-form" style="{if NOT $_post.username_reset|default}display: none;{/if}">
                    <div class="x-form-item login-form-item">
                        <div class="x-form-element login-form-element">
                            <input type="text" id="modx-login-username-reset" name="username_reset" class="x-form-text x-form-field" value="{$_post.username_reset|default}" placeholder="{$_lang.login_username_or_email}" />
                        </div>
                        <div class="x-form-clear-left"></div>
                    </div>

                    <button class="x-btn x-btn-small x-btn-icon-small-left primary-button x-btn-noicon login-form-btn" name="forgotlogin" type="submit" value="1" id="modx-fl-btn">{$_lang.login_send_activation_email}</button>
                </div>
            </form>
        </div>
{/if}
        <br class="clear" />
    </div>

    <p class="loginLicense">{$_lang.login_copyright|replace:'[[+current_year]]':{'Y'|date}}</p>
</div>

<div id="modx-login-language-select-div">
    <label id="modx-login-language-select-label">{$language_str}:
        <select name="cultureKey" id="modx-login-language-select" aria-labeled-by="modx-login-language-select-label">
{$languages|indent:12}
        </select>
    </label>
</div>
            
            
        </div>
    </div>
    
    <div class="col-6 d-flex p_rv">
{if $modx->config['lg_theme_auth_bgphoto']}        
    <div class="bg" style="background-image:url('{$modx->config['lg_theme_auth_bgphoto']}')"></div>
{else}
    <div class="bg" style="background-image:url('{$_config.manager_url}templates/light_theme/images/login_bg.jpeg')"></div>
{/if}
        <div class="bg_txt">
            <div class="col_txt">
            <div class="small_txt">{$modx->config['lg_theme_auth_title']}</div>
            <div class="big_txt">{$modx->config['lg_theme_auth_txt']}</div>
            {if $modx->config['lg_theme_auth_web']}<div class="link_txt"><a href="{$modx->config['lg_theme_auth_web']}" target="_blank" >Перейти</a></div>{/if}
            </div>
        </div>
    </div>
</div>


</body>
</html>
