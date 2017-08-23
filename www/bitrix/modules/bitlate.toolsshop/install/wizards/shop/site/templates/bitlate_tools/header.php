<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
if (!CModule::IncludeModule('bitlate.toolsshop')) return false;
$templateOptions = NLApparelshopUtils::initTemplateOptions();
global $USER;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?$APPLICATION->SetAdditionalCSS("https://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic,900,900italic&subset=cyrillic-ext,cyrillic,latin");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/".SITE_TEMPLATE_ID."/themes/".$templateOptions['theme']."/css/main.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/".SITE_TEMPLATE_ID."/css/custom.css");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/jquery.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/foundation.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/isotope.pkgd.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/slideout.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/owl.carousel.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/fancybox.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/fancybox-thumbs.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/zoomsl.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/selectbox.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/mask.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/yandex.maps.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/main.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/colorpicker.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/jquery.validate.min.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/custom.js");?>
    <?$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/site.js");?>
    <?if (strpos($APPLICATION->GetCurDir(), SITE_DIR . 'company/contacts') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'company/shops') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'shop/delivery') === 0):?>
        <?$APPLICATION->AddHeadScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU");?>
    <?endif;?>
    <?$APPLICATION->ShowHead()?>
    <title><?$APPLICATION->ShowTitle();?></title>
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <div style="height: 0; width: 0; position: absolute; visibility: hidden">
        <!-- inject:svg -->
        <svg xmlns="http://www.w3.org/2000/svg"><symbol id="svg-icon-cart" viewBox="0 0 30 26"><path d="M24.3 24c.8 0 1.5-.7 1.5-1.5s-.7-1.5-1.5-1.5c-.5 0-1.5.5-1.5 1.5 0 .6.6 1.5 1.5 1.5m-11.9 0c.8 0 1.5-.7 1.5-1.5 0-.2 0-.4-.1-.6-.3-.5-.7-.9-1.5-.9-.5 0-.8.3-.8.3-.4.3-.6.7-.6 1.2 0 .8.7 1.5 1.5 1.5m12.4-10L27 8l.4-1c.1-.1-.1.1 0 0h-20l2.8 7H24.4m-.1 12c-1.9 0-3.5-1.6-3.5-3.5 0-.5.1-1 .3-1.5h-5.6c.2.5.3 1 .3 1.5 0 1.9-1.6 3.5-3.5 3.5s-3.5-1.6-3.5-3.5c0-1.2.6-2.2 1.4-2.8L8.9 16v-.1L3.4 2H0V0h4.9l1.9 5h21.9c1.5 0 1.3.6.4 3.2-.2.4.2-.4 0 0L26.7 15c-.4 1-.9 1-.9 1H11l1.1 3H24.3c1.9 0 3.5 1.6 3.5 3.5-.1 1.9-1.6 3.5-3.5 3.5z"/></symbol><symbol id="svg-icon-colorpicker" viewBox="0 0 38 38"><path d="M19.55 15.987L22 18.438l-5.865 5.871-3.268 1.686-.867-.866 1.685-3.272zm4.614.072l1.361-1.359a1.591 1.591 0 0 0-2.255-2.246l-1.361 1.356-.564-.562a.8.8 0 0 0-1.129 1.123l3.384 3.374a.8.8 0 0 0 1.127 0 .793.793 0 0 0 0-1.124z" fill-rule="evenodd"/></symbol><symbol id="svg-icon-compare-hover" viewBox="0 0 13 15"><path d="M7 15V0h6v15H7zm4-13H9v11h2V2zM0 6h6v9H0V6zm2 7h2V8H2v5z"/></symbol><symbol id="svg-icon-compare" viewBox="0 0 21 26"><path d="M19 24V2h-5v22h5M7 24V11H2v13h5m14 2h-9V0h9v26zM9 26H0V9h9v17z"/></symbol><symbol id="svg-icon-delivery" viewBox="0 0 27 24"><path class="st0" d="M25 24H2c-1.1 0-2-.9-2-2V2C0 .9.9 0 2 0h23c1.1 0 2 .9 2 2v20c0 1.1-.9 2-2 2zM18 2H9v6h9V2zm7 0h-5v8H7V2H2v20h23V2z"/></symbol><symbol id="svg-icon-doc" viewBox="0 0 32 39"><path d="M21.62 0H0v39h32V10.41L21.62 0zM22 3l7 7h-7V3zM2 37V2h18v10h10v25H2z"/></symbol><symbol id="svg-icon-history" viewBox="0 0 26 28"><path class="st0" d="M24 28H2c-1.1 0-2-.9-2-2V2C0 .9.9 0 2 0h22c1.1 0 2 .9 2 2v24c0 1.1-.9 2-2 2zm0-26H2v24h22V2zm-5 7H7V7h12v2zm0 6H7v-2h12v2zm0 6H7v-2h12v2z"/></symbol><symbol id="svg-icon-liked-hover" viewBox="0 0 18 16"><path d="M17.4 6.7C16.2 9.5 9 15.9 9 16c0-.1-7.2-6.5-8.4-9.3C0 5.5 0 4.2.4 3.1.9 2 1.8 1 3 .5 4.1 0 5.3-.1 6.3.2c1.1.3 2 1.2 2.7 2.1.7-1 1.6-1.8 2.7-2.1 1.1-.3 2.2-.2 3.3.3 1.2.5 2.1 1.5 2.6 2.6.4 1.1.4 2.4-.2 3.6zm-1.7-2.4c-.4-.8-.9-1.8-1.9-2.2-.8-.4-1.6 0-2.8.9-1.1.8-2 1.7-2 1.7s-1.1-1-2-1.9c-.8-.8-1.9-1-2.7-.5-1 .4-1.7 1.1-2 2-.2.4-.4.8 0 1.8 1 2 6.7 6.8 6.7 6.9 0-.1 5.8-4.9 6.7-6.9.2-.7.4-1.2 0-1.8z"/></symbol><symbol id="svg-icon-liked" viewBox="0 0 30 26"><path d="M29.2 11.4C27.2 16 15 25.8 15 26c-.1-.2-12.3-10-14.3-14.6-.9-2.2-.9-4.9-.1-6.8.7-1.9 2.2-2.8 4.3-3.8 1.8-.9 3.8-1 5.6-.4 1.8.5 3.4 1.8 4.5 3.4C16.1 2.1 17.7.9 19.5.4c1.8-.5 3.8-.4 5.6.4 2.1 1 3.6 2.1 4.3 4 .8 1.8.8 4.4-.2 6.6zM25 3c-2.4-1.8-6-1.5-10 3-4.2-4.5-7.1-4.6-10-3-1.1.5-3 2.3-3 4 0 2.1.2 2.8 1 4 3.4 5.4 11.9 11.8 12 12 .1-.2 9.2-7 12-12 .8-1.4 1-2.2 1-4 0-1.4-1.3-2.8-3-4z"/></symbol><symbol id="svg-icon-load-more" viewBox="0 0 41 41"><path d="M40.243 25.6a.779.779 0 0 0-.164-.444.777.777 0 0 0-.11-.114.941.941 0 0 0-.893-.183l-.028.01a.77.77 0 0 0-.272.173l-8.11 4.614a.873.873 0 0 0 1.077 1.375l5.792-2.784a18.679 18.679 0 0 1-35.069-2.8.869.869 0 0 0-1.682.453 20.41 20.41 0 0 0 38.038 3.676l.436 5.3a.872.872 0 0 0 1.742-.15zm-.03-10.486a20.411 20.411 0 0 0-38.037-3.678L1.74 6.142A.872.872 0 0 0 0 6.285l.752 9.122a.777.777 0 0 0 .166.452.823.823 0 0 0 .115.119.867.867 0 0 0 .778.209.9.9 0 0 0 .11-.027l.032-.012a.764.764 0 0 0 .268-.169l8.112-4.616A.873.873 0 0 0 9.26 9.988l-5.792 2.785a18.679 18.679 0 0 1 35.07 2.8.869.869 0 0 0 1.676-.461z"/></symbol><symbol id="svg-icon-m-toggle" viewBox="0 0 23 19"><path fill-rule="evenodd" d="M0 19v-3h23v3H0zM0 8h23v3H0V8zm0-8h23v3H0V0z"/></symbol><symbol id="svg-icon-menu-more" viewBox="0 0 33 9"><path fill-rule="evenodd" d="M28.5 9A4.5 4.5 0 0 1 24 4.5C24 2.02 26.02 0 28.5 0a4.5 4.5 0 0 1 0 9zm0-7a2.5 2.5 0 0 0 0 5 2.5 2.5 0 0 0 0-5zm-12 7A4.5 4.5 0 0 1 12 4.5C12 2.02 14.02 0 16.5 0a4.5 4.5 0 0 1 0 9zm0-7a2.5 2.5 0 0 0 0 5 2.5 2.5 0 0 0 0-5zm-12 7A4.5 4.5 0 0 1 0 4.5C0 2.02 2.02 0 4.5 0a4.5 4.5 0 0 1 0 9zm0-7a2.5 2.5 0 0 0 0 5 2.5 2.5 0 0 0 0-5z"/></symbol><symbol id="svg-icon-metro" viewBox="0 0 16 11"><path d="M8 11l2.6-4.411 1.079 2.987h-.871v1.315H16V9.577h-.991L11.279 0 8 5.9 4.721 0 .991 9.577H0v1.315h5.192V9.577h-.871L5.4 6.589z"/></symbol><symbol id="svg-icon-phone" viewBox="0 0 21 32"><path class="st0" d="M18 32H3c-1.7 0-3-1.3-3-3V3c0-1.7 1.3-3 3-3h15c1.7 0 3 1.3 3 3v26c0 1.7-1.3 3-3 3zm1-29c0-.6-.4-1-1-1H3c-.6 0-1 .4-1 1v26c0 .6.4 1 1 1h15c.6 0 1-.4 1-1V3zM7 5h7v2H7V5zm3.5 19c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5S9 26.3 9 25.5s.7-1.5 1.5-1.5z"/></symbol><symbol id="svg-icon-placemark" viewBox="0 0 40 47"><circle cx="20" cy="20" r="9" fill="#fff"/><path d="M32.011 7.974A16.989 16.989 0 0 0 7.972 31.986L19.992 44l12.02-12.01a16.956 16.956 0 0 0-.001-24.016zM26 25.983a8.487 8.487 0 1 1 2.491-6 8.479 8.479 0 0 1-2.491 6z" fill-rule="evenodd"/></symbol><symbol id="svg-icon-plus-delivery" viewBox="60 -30 132 71"><path class="icon-secondary" d="M185-.5l1.5-1.5 3.5 3.5-1.5 1.5L185-.5zm7 18.9c0 6-2.4 11.7-6.7 16S175.1 41 169 41c-6.1 0-11.9-2.4-16.3-6.6-4.3-4.3-6.7-9.9-6.7-16 0-6 2.4-11.7 6.7-16 3.9-3.8 7.9-6 13.3-6.4v-4h6v4c5.4.5 9.4 2.7 13.3 6.4 4.3 4.3 6.7 10 6.7 16zM170-6h-2v2h2v-2zm-1 3.8c-11.6 0-21 9.3-21 20.7s9.4 20.7 21 20.7 21-9.3 21-20.7-9.4-20.7-21-20.7zm1 23.2v2c0 .6-.4 1-1 1s-1-.4-1-1v-2c-1.1-.4-2-1.7-2-3s.9-2.6 2-3V3c0-.6.4-1 1-1s1 .4 1 1v12c1.1.4 2 1.7 2 3 0 1.2-.9 2.6-2 3zm-1-4c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1z"/><path class="icon-primary" d="M106 24c0-2.2 1.8-4 4-4s4 1.8 4 4-1.8 4-4 4-4-1.8-4-4zm6 0c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm4 0c0-2.2 1.8-4 4-4s4 1.8 4 4-1.8 4-4 4-4-1.8-4-4zm6 0c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm57-28v-24h-26v17c0 1-1 2-2 2h-24c-1 0-2-1-2-2v-17H99v63h52l2 2H99c-1 0-2-1-2-2v-63c0-.9 1.1-2 2-2h80c1 0 2 1.1 2 2v25l-2-1zm-28-24h-24v17h24v-17zM89.5 25h-20c-.3 0-.5-.2-.5-.5v-1c0-.3.2-.5.5-.5h20c.3 0 .5.2.5.5v1c0 .3-.2.5-.5.5zm0-10h-25c-.3 0-.5-.2-.5-.5v-1c0-.3.2-.5.5-.5h25c.3 0 .5.2.5.5v1c0 .3-.2.5-.5.5zm0-10h-29c-.3 0-.5-.2-.5-.5v-1c0-.3.2-.5.5-.5h29c.3 0 .5.2.5.5v1c0 .3-.2.5-.5.5zm0-10h-25c-.3 0-.5-.2-.5-.5v-1c0-.3.2-.5.5-.5h25c.3 0 .5.2.5.5v1c0 .3-.2.5-.5.5zm0-10h-20c-.3 0-.5-.2-.5-.5v-1c0-.3.2-.5.5-.5h20c.3 0 .5.2.5.5v1c0 .3-.2.5-.5.5z"/></symbol><symbol id="svg-icon-plus-discount" viewBox="48 -40 108 90"><path class="icon-primary" d="M113.5 45c-6.5 0-12.7-1.5-18.2-4.1l1.1-1.7c5.2 2.4 11 3.8 17.2 3.8C135.9 43 154 24.9 154 2.5S135.9-38 113.5-38c-20.8 0-38 15.8-40.2 36h-2c2.2-21.4 20.3-38 42.3-38C137-40 156-21 156 2.5S137 45 113.5 45zM94-9.5c0-4.1 3.4-7.5 7.5-7.5s7.5 3.4 7.5 7.5-3.4 7.5-7.5 7.5S94-5.4 94-9.5zm7.5 5.5c3 0 5.5-2.5 5.5-5.5s-2.5-5.5-5.5-5.5S96-12.5 96-9.5 98.5-4 101.5-4zM132 13.5c0 4.1-3.4 7.5-7.5 7.5s-7.5-3.4-7.5-7.5 3.4-7.5 7.5-7.5 7.5 3.4 7.5 7.5zm-13 0c0 3 2.5 5.5 5.5 5.5s5.5-2.5 5.5-5.5-2.5-5.5-5.5-5.5-5.5 2.5-5.5 5.5zm-19.7.8l31-31 1.4 1.4-31 31-1.4-1.4z"/><path class="icon-secondary" d="M73 49.9c-13.8 0-24.9-11.2-24.9-24.9C48.1 11.2 59.2.1 73 .1 86.8.1 97.9 11.3 97.9 25c0 13.8-11.1 24.9-24.9 24.9zM73 2C60.3 2 50 12.3 50 25s10.3 23 23 23 23-10.3 23-23S85.7 2 73 2zm7.3 30.4c-2.5 0-4.1-.9-5.2-2.4l1.1-1.2c1 1.2 2.2 1.9 4 1.9 2 0 3.6-1.4 3.8-3.2.1-2-1.7-3.1-3.7-3.1-1.3 0-2.4.4-3.4 1.4L76 25v-8h9v2h-7v5c.7-.7 1.4-1.1 2.8-1.1 2.5 0 5.3 1.7 5.1 4.7-.1 2.9-2.7 4.8-5.6 4.8zM70 20l-2.2 2.4L66 21l4-4h2v15h-2V20zm-4 8h-6v-2h6v2z"/></symbol><symbol id="svg-icon-plus-payment" viewBox="52 -35 116 81"><path class="icon-secondary" d="M163-1h-1v11c0 3.2-1.8 5-5 5h-19v-2h19c2 0 3-1 3-3V-1h-12c-3.2 0-5-1.8-5-5v-7c0-3.2 1.8-5 5-5h12v-12c0-2-1-3-3-3h-50c-2 0-3 1-3 3v17h-2v-17c0-3.2 1.8-5 5-5h50c3.2 0 5 1.8 5 5v12h1c3.2 0 5 1.8 5 5v7c0 3.2-1.8 5-5 5zm3-12c0-2-1-3-3-3h-15c-2 0-3 1-3 3v7c0 2 1 3 3 3h15c2 0 3-1 3-3v-7zm-15.5 5c-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5 1.5.7 1.5 1.5-.7 1.5-1.5 1.5z"/><path class="icon-primary" d="M132 46H56c-2.2 0-4-1.8-4-4V-7c0-2.2 1.8-4 4-4h76c2.2 0 4 1.8 4 4v49c0 2.2-1.8 4-4 4zm2-53c0-1.1-.9-2-2-2H56c-1.1 0-2 .9-2 2v8h80v-8zm0 10H54v7h80V3zm0 9H54v30c0 1.1.9 2 2 2h76c1.1 0 2-.9 2-2V12zm-18 12h11v11h-11V24zm2 9h7v-7h-7v7zm-58-8h38v2H60v-2zm22 9H60v-2h22v2z"/></symbol><symbol id="svg-icon-plus-return" viewBox="35 -41 82 92"><path class="icon-primary" d="M115 39H89v-2h26v-57H61V3h-2v-23c0-1.1.9-2 2-2h11v-3.5C72-34.1 78.9-41 87.5-41h1c8.6 0 15.5 6.9 15.5 15.5v3.5h11c1.1 0 2 .9 2 2v57c0 1.1-.9 2-2 2zm-13-64.7C102-33 95.9-39 88.4-39h-.9C80.1-39 74-33.1 74-25.7v3.7h28v-3.7z"/><path class="icon-secondary" d="M86 51H36.8c-.5 0-.9-.2-1.3-.5-.3-.3-.5-.8-.5-1.3V6s0-1 1-1h6c1 0 1 0 1 1s0 1-1 1h-5v9h48V7h-4c-1 0-1 0-1-1s0-1 1-1h5c-.1 0 1-.1 1 1v44c0 .5-.5 1-1 1zm-1-33H37v31h48V18zM66 7h-9c-1 0-1 0-1-1s0-1 1-1h9c1 0 1 0 1 1s0 1-1 1zm-17 4c-1 0-1 0-1-1V1c0-1 0-1 1-1s1 0 1 1v9c0 1 0 1-1 1zm24 0c-1 0-1 0-1-1V0c0-1 0-1 1-1s1 0 1 1v10c0 1 0 1-1 1zM53 42V27l-2.6 3.1-1.3-1.3L53 24h2v18h-2zm17-5v5h-2v-5h-9v-2l8-11h3v11h2v2h-2zm-2-11l-7 9h7v-9z"/></symbol><symbol id="svg-icon-profile" viewBox="0 0 16 19"><path class="st0" d="M16 14.3c0 2.6-3 4.7-8 4.7s-8-2.1-8-4.7c0-1.8 1-4.3 3.7-5.7C3.2 7.5 3 6.1 3 5c0-2.8 2.3-5 5-5s5 2.2 5 5c0 1.1-.2 2.4-.8 3.6 2.7 1.4 3.8 4 3.8 5.7zM8 1C5.9 1 4 2.8 4 5.2 4 7.5 5.9 11 8 11s4-3.5 4-5.8C12 2.8 10.1 1 8 1zm3.5 9c-.8 1.2-2 2-3.5 2-1.7 0-2.8-.8-3.6-2-2.5.3-3.4 3.2-3.4 4.5C1 16 3.7 18 8 18s7-1.9 7-3.5c0-1.4-.8-4.3-3.5-4.5z"/></symbol><symbol id="svg-icon-question" viewBox="0 0 29 56"><path d="M2 7c3.28-4 6.68-5 11-5a13.737 13.737 0 0 1 14 14c.16 9.2-7.6 14.2-16 15v16h2c.08-4-.08-10 0-14 9.84-1.44 15.92-8.2 16-17 .08-9.52-8-16-16-16A16.065 16.065 0 0 0 0 6zm11 49v-2h-2v2h2z"/></symbol><symbol id="svg-icon-ruble" viewBox="0 0 12 17"><path class="st0" d="M11.5 2.6c-.3-.7-.7-1.1-1.1-1.5C10 .7 9.2.3 8.6.2 8.2 0 7.5 0 6.7 0H1v8H0v2h1v2H0v2h1v3h2v-3h6v-2H3v-2h4c1.8 0 2.9-.9 3.7-1.9.8-.9 1.3-1.7 1.3-3.2 0-1.2-.2-1.7-.5-2.3zM9 7.1c-.4.5-.9.9-2 .9H3V2h4c.8 0 1.1 0 1.4.1.6.2.8.5 1.1.9.3.5.5 1 .5 2s-.5 1.5-1 2.1z"/></symbol><symbol id="svg-icon-search" viewBox="0 0 14 14"><path class="st0" d="M14 12.8l-3.4-3.4c.8-1 1.3-2.3 1.3-3.6 0-3.2-2.7-5.8-6-5.8C2.7 0 0 2.6 0 5.9c0 3.2 2.7 5.9 5.9 5.9 1.3 0 2.5-.4 3.5-1.1l3.4 3.4 1.2-1.3zm-8.1-2.7c-2.4 0-4.3-1.9-4.3-4.2 0-2.3 1.9-4.2 4.3-4.2s4.3 1.9 4.3 4.2c0 1.3-.6 2.4-1.5 3.2-.8.7-1.8 1-2.8 1z"/></symbol><symbol id="svg-icon-social-facebook" viewBox="0 0 8 15"><path class="st0" d="M8 5H5V3c0-.6.7-1 1-1h2V0H5.3C2.4 0 2 1.8 2 3v2H0v2h2v8h3V7h3V5z"/></symbol><symbol id="svg-icon-social-google" viewBox="0 0 15 15"><path class="st0" d="M7.5.7c.1.1.2.2.4.3.2.2.3.3.5.6.1.2.3.5.4.7.1.3.1.6.1 1 0 .7-.2 1.3-.5 1.7-.2.3-.3.5-.5.6l-.6.6-.4.4c-.1.1-.1.3-.1.5s.1.4.2.5c.1.2.2.3.3.4l.7.5c.4.3.8.7 1.1 1.1.3.4.5 1 .5 1.6 0 1-.4 1.8-1.3 2.5-.9.9-2.3 1.3-4 1.3-1.4 0-2.5-.3-3.2-.9-.7-.5-1.1-1.2-1.1-1.9 0-.4.1-.8.4-1.2.2-.4.6-.8 1.2-1.2.7-.4 1.4-.6 2.1-.7.7-.1 1.3-.2 1.8-.2-.2-.2-.3-.4-.4-.6-.1-.2-.2-.5-.2-.8 0-.2 0-.3.1-.4 0-.1.1-.2.1-.3h-.7c-1.1 0-1.9-.3-2.5-1-.6-.6-.9-1.3-.9-2.1 0-1 .4-1.8 1.3-2.6C2.9.6 3.5.3 4.1.2 4.8.1 5.3 0 5.9 0H10L8.7.7H7.5zm.8 11.4c0-.5-.2-.9-.5-1.3-.4-.4-1-.8-1.7-1.4H4.8c-.4.1-.9.2-1.3.3-.1.1-.3.1-.5.2s-.4.2-.6.4c-.2.2-.4.4-.5.6-.2.3-.2.6-.2.9 0 .7.3 1.3 1 1.7.6.4 1.5.7 2.6.7 1 0 1.7-.2 2.2-.6.5-.4.8-.9.8-1.5zM5.4 6.3c.5 0 1-.2 1.4-.6.1-.2.2-.5.3-.8v-.7c0-.8-.2-1.6-.6-2.3-.2-.3-.4-.7-.8-.9C5.4.8 5 .7 4.6.7c-.6 0-1 .2-1.4.6-.3.4-.4.9-.4 1.5 0 .7.2 1.4.6 2.2.2.4.5.7.8.9.4.3.8.4 1.2.4z"/><path class="st1" d="M12 5h1v5h-1V5z"/><path class="st1" d="M15 7v1h-5V7h5z"/></symbol><symbol id="svg-icon-social-instagram" viewBox="0 0 16 16"><path class="st0" d="M2.1 0H14c1.1 0 2 .9 2 2.1V14c0 1.1-.9 2.1-2.1 2.1H2.1C.9 16 0 15.1 0 13.9V2.1C0 .9.9 0 2.1 0zm10.4 2c-.2 0-.5.3-.5.5v1c0 .2.3.5.5.5h1c.2 0 .5-.3.5-.5v-1c0-.2-.3-.5-.5-.5h-1zM14 6l-1.2.4c.1.4.2 1.3.2 1.7 0 2.7-2.2 4.8-5 4.8-2.7 0-5-2.2-5-4.8 0-.5 0-1.3.2-1.7L2 6v7c0 .4.7 1 1 1h10c.4 0 1-.7 1-1V6zM8 5C6.3 5 5 6.3 5 8s1.3 3 3 3 3-1.3 3-3-1.4-3-3-3z"/></symbol><symbol id="svg-icon-social-ok" viewBox="0 0 8 14"><path class="st0" d="M4 7.2C2 7.2.4 5.6.4 3.6S2 0 4 0s3.6 1.6 3.6 3.6S6 7.2 4 7.2zm0-5.1c-.8 0-1.5.7-1.5 1.5S3.2 5.1 4 5.1s1.5-.7 1.5-1.5S4.8 2.1 4 2.1zm3.5 7.2c-.6.4-1.3.7-2.1.9l2 2c.4.4.4 1.1 0 1.5-.4.4-1.1.4-1.5 0l-2-2-2 2c-.1.2-.3.3-.6.3s-.5-.1-.7-.3c-.4-.4-.4-1.1 0-1.5l2-2c-.8-.2-1.5-.5-2.1-.9C0 9-.2 8.3.2 7.8c.3-.5 1-.6 1.4-.3 1.5.9 3.3.9 4.8 0 .5-.3 1.1-.2 1.4.3.4.5.2 1.2-.3 1.5z"/></symbol><symbol id="svg-icon-social-twitter" viewBox="0 0 14 12"><path class="st0" d="M14 1.4c-.5.2-1.1.4-1.7.5.6-.4 1.1-1 1.3-1.7-.6.3-1.2.6-1.8.7-.5-.6-1.3-1-2.1-1C8.1 0 6.8 1.4 6.8 3c0 .2 0 .5.1.7C4.5 3.6 2.4 2.4 1 .6c-.3.4-.4.9-.4 1.5 0 1 .5 2 1.3 2.5-.5 0-.9-.1-1.3-.4 0 1.5 1 2.7 2.3 3-.3.1-.5.1-.8.1-.2 0-.4 0-.5-.1.3 1.3 1.4 2.2 2.7 2.2-1 .8-2.2 1.3-3.6 1.3H0c1.3.8 2.8 1.3 4.4 1.3 5.3 0 8.2-4.6 8.2-8.6V3c.5-.4 1-1 1.4-1.6z"/></symbol><symbol id="svg-icon-social-vk" viewBox="0 0 9 13"><path class="st0" d="M8.4 6.9c-.4-.5-1-.9-1.7-1v-.1c.5-.2.9-.6 1.1-1.1.3-.5.5-1 .5-1.7 0-.5-.1-1-.3-1.5-.2-.4-.5-.8-.9-1C6.7.3 6.3.2 5.9.1 5.4 0 4.8 0 4 0H0v13h4.5c.8 0 1.4-.1 1.9-.2.5-.2 1-.4 1.4-.8.4-.3.6-.7.9-1.2.2-.6.3-1.1.3-1.8 0-.9-.2-1.6-.6-2.1zM5.3 4.4c-.1.2-.3.4-.5.5-.2.1-.4.2-.6.2H2.8V2.4h1.3c.3 0 .5.1.7.2.2 0 .3.2.4.4.1.2.1.4.1.6.1.4 0 .6 0 .8zm.6 5.4c-.1.2-.3.4-.6.6-.3.1-.6.2-.9.2H2.8V7.4h1.7c.3 0 .5.1.7.1.3.1.5.3.7.5.1.2.2.6.2 1 0 .3-.1.6-.2.8z"/></symbol><symbol id="svg-icon-subscribe" viewBox="0 0 26 19"><path class="st0" d="M26 9.3s0-.1 0 0c0-.1 0-.1 0 0v-.1s0-.1-.1-.1L20 1c-.1-.2-1.6-1-3-1H9C7.5 0 6.1.8 6 1L.1 9s0 .1-.1.1V18.3c0 .4.3.7.8.7h24.5c.4 0 .8-.3.8-.8L26 9.3zM8 2h10l6 7h-8c-.4 0 0 .6 0 1 0 1.8-1.1 3-3 3s-3-1.2-3-3c0-.4-.6-1-1-1H2l6-7zm16 15H2v-6h6c.4 2.3 2.5 4 5 4s4.6-1.7 5-4h6v6z"/></symbol><symbol id="svg-icon-timer" viewBox="0 0 20 22"><path class="st0" d="M20 12c0 5.5-4.5 10-10 10S0 17.5 0 12c0-5.2 3.9-9.4 9-9.9V0h2v2.1c1.8.2 3.5.9 4.9 1.9L17 2l1.8 1.1-1.3 2.3C19 7.1 20 9.4 20 12zM10 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM9 8h2v5H9V8z"/></symbol><symbol id="svg-icon-up-down" viewBox="-1 -2 12 21"><path class="st0" d="M4 19V-2h2v21H4zM9.6 5L6 1v-3l5 5.6L9.6 5zM.4 5L-1 3.6 4-2v3L.4 5z"/></symbol><symbol id="svg-icon-view-list" viewBox="0 0 15 15"><path d="M0 3V0h3v3H0zm5 0V0h10v3H5zM0 9V6h3v3H0zm5 0V6h10v3H5zm-5 6v-3h3v3H0zm5 0v-3h10v3H5z"/></symbol><symbol id="svg-icon-view-mini" viewBox="0 0 15 14"><path d="M0 2V0h15v2H0zm0 4V4h15v2H0zm0 4V8h15v2H0zm0 4v-2h15v2H0z"/></symbol><symbol id="svg-icon-view-tile" viewBox="0 0 15 15"><path d="M0 3V0h3v3H0zm6 0V0h3v3H6zM0 9V6h3v3H0zm6 0V6h3v3H6zm-6 6v-3h3v3H0zm6 0v-3h3v3H6zm6-12V0h3v3h-3zm0 6V6h3v3h-3zm0 6v-3h3v3h-3z"/></symbol></svg>
        <!-- endinject -->
    </div>
    
    <nav id="mobile-menu" class="mobile-menu hide-for-xlarge">
        <div class="mobile-menu-wrapper">
            <a href="<?=SITE_DIR?>personal/" class="button mobile-menu-profile relative">
                <svg class="icon">
                    <use xlink:href="#svg-icon-profile"></use>
                </svg>
                <?=getMessage('PERSONAL_CABINET')?>
            </a>
            <div class="is-drilldown">
                <?$APPLICATION->IncludeComponent('bitrix:menu', "mobile_menu_main", array(
                        "ROOT_MENU_TYPE" => "main",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "USE_EXT" => "Y",
                        "ALLOW_MULTI_SELECT" => "N",
                        "SUB_CLASS" => "mobile-menu-main",
                    )
                );?>
                <?$APPLICATION->IncludeComponent('bitrix:menu', "mobile_menu_main", array(
                        "ROOT_MENU_TYPE" => "site",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "USE_EXT" => "Y",
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "bottom",
                        "DELAY" => "N",
                    )
                );?>
                <form action="<?=$templateOptions['url_catalog_search']?>" class="mobile-menu-search relative">
                    <button type="submit">
                        <svg class="icon">
                            <use xlink:href="#svg-icon-search"></use>
                        </svg>
                    </button>
                    <input type="text" placeholder="<?=getMessage('SEARCH_STRING')?>" name="q" />
                </form>
            </div>
        </div>
    </nav>
    <div id="page">
        <div id="bx_custom_menu">
            <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_custom_menu", false);
            $frame->begin();?>
                <?if ($USER->IsAdmin() && $APPLICATION->GetCurDir() == SITE_DIR):?>
                    <?$APPLICATION->IncludeComponent("bitlate:custom.menu","",Array(
                        'CUR_THEME' => $templateOptions['theme'],
                        'MODULE_NAME' => 'bitlate.toolsshop',
                    ));?>
                <?endif;?>
            <?$frame->beginStub();?>
            <?$frame->end();?>
        </div>
        <header>
            <div class="header-line-top hide-for-small-only hide-for-medium-only hide-for-large-only">
                <div class="container row">
                    <?$APPLICATION->IncludeComponent('bitrix:menu', "top", array(
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "36000000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "1",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N"
                        )
                    );?>
                    <div class="float-right inline-block-container">
                        <?if ($templateOptions['use_compare'] == "Y"):?>
                            <div class="inline-block-item relative">
                                <?$APPLICATION->IncludeFile(
                                    SITE_DIR . "include/compare_list.php",
                                    Array()
                                );?>
                            </div>
                        <?endif;?>
                        <div class="inline-block-item relative">
                            <?$APPLICATION->IncludeComponent("bitlate:catalog.favorite.line","",Array());?>
                        </div>
                        <div class="inline-block-item relative" id="bx_personal_menu">
                            <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_personal_menu", false);
                            $frame->begin();?>
                                <a href="<?if ($USER->IsAuthorized()):?><?=SITE_DIR?>personal/<?else:?>#login<?endif;?>" class="button transparent header-line-top-profile fancybox" data-toggle="profile-dropdown">
                                    <svg class="icon">
                                        <use xlink:href="#svg-icon-profile"></use>
                                    </svg>
                                    <?=getMessage('PERSONAL_CABINET')?>
                                </a>
                                <div class="dropdown-pane bottom" id="profile-dropdown" data-dropdown data-hover="true" data-hover-pane="true">
                                    <ul>
                                        <?if ($USER->IsAuthorized()):?>
                                            <li><a href="<?=SITE_DIR?>personal/"><?=getMessage('PERSONAL_CABINET')?></a></li>
                                            <li><a href="<?=$APPLICATION->GetCurPageParam('logout=yes', array('logout'));?>"><?=getMessage('EXIT')?></a></li>
                                        <?else:?>
                                            <li><a href="#login" class="fancybox"><?=getMessage('PERSONAL_CABINET')?></a></li>
                                            <li><a href="#login" class="fancybox"><?=getMessage('ENTER')?></a></li>
                                        <?endif;?>
                                    </ul>
                                </div>
                            <?$frame->beginStub();?>
                                <a href="#" class="button transparent header-line-top-profile">
                                    <svg class="icon">
                                        <use xlink:href="#svg-icon-profile"></use>
                                    </svg>
                                    <?=getMessage('PERSONAL_CABINET')?>
                                </a>
                            <?$frame->end();?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="advanced-container inline-block-container relative">
                <a href="javascript:;" class="header-mobile-toggle inline-block-item vertical-middle hide-for-xlarge">
                    <svg class="icon">
                        <use xlink:href="#svg-icon-m-toggle"></use>
                    </svg>
                </a>
                <a href="<?=SITE_DIR?>" class="header-logo inline-block-item vertical-middle">
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR . "include/logo.php",
                        Array(
                            "PATH_TO_LOGO" => "/local/templates/" . SITE_TEMPLATE_ID . "/themes/" . $templateOptions['theme'] . "/images/logo.png",
                        )
                    );?>
                </a>
                <div class="header-block-right show-for-xlarge">
                    <div class="inline-block-item" id="title-search">
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR . "include/search_title.php",
                            Array()
                        );?>
                    </div>
                    <div class="header-phone inline-block-item">
                        <div class="inline-block-container">
                            <svg class="icon">
                                <use xlink:href="#svg-icon-phone"></use>
                            </svg>
                            <div class="inline-block-item">
                                <div class="header-phone-number"><?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "PATH" => SITE_DIR . "include/phone.php"
                                    )
                                );?></div>
                                <div class="header-phone-link"><a href="#request-callback" class="fancybox"><?=getMessage('REQUEST_CALL')?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="header-cart header-block-info inline-block-item">
                        <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "SHOW_PERSONAL_LINK" => "N",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_TOTAL_PRICE" => "Y",
                                "SHOW_PRODUCTS" => "Y",
                                "POSITION_FIXED" =>"N",
                                "HIDE_ON_BASKET_PAGES" => "N",
                            ),
                            false,
                            array()
                        );?>
                    </div>
                </div>
                <ul class="header-fixed-block">
                    <li class="header-cart header-block-info header-fixed-item">
                        <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "mini", array(
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "SHOW_PERSONAL_LINK" => "N",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_TOTAL_PRICE" => "Y",
                                "SHOW_PRODUCTS" => "Y",
                                "POSITION_FIXED" =>"N",
                                "HIDE_ON_BASKET_PAGES" => "N",
                            ),
                            false,
                            array()
                        );?>
                    </li>
                    <li class="header-liked header-block-info header-fixed-item">
                        <?$APPLICATION->IncludeComponent("bitlate:catalog.favorite.line","mini",Array());?>
                    </li>
                    <?if ($templateOptions['use_compare'] == "Y"):?>
                        <li class="header-compare header-block-info header-fixed-item">
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/compare_list.php",
                                Array(
                                    'TYPE' => 'mini',
                                )
                            );?>
                        </li>
                    <?endif;?>
                </ul>
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:menu", "header_main_menu", array(
                    "ROOT_MENU_TYPE" => "main",
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "2",
                    "USE_EXT" => "Y",
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                ),
                false
            );?>
        </header>
        <?$classSection = "";
        if ($APPLICATION->GetCurDir() == SITE_DIR) {
        } elseif (strpos($APPLICATION->GetCurDir(), SITE_DIR . 'company/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'shop/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'info/') === 0 || strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog_search']) === 0) {
            $classSection = "inner";
        } elseif (($APPLICATION->GetCurDir() == SITE_DIR . 'personal/' || $APPLICATION->GetCurDir() == SITE_DIR . 'personal/profile/') && $USER->IsAuthorized()) {
            $classSection = "profile";
        } elseif ($APPLICATION->GetCurDir() == SITE_DIR . 'personal/cart/' || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'personal/order/') === 0) {
            $classSection = "cart";
        } elseif (ERROR_404 == "Y") {
            $classSection = "not-found";
        } else {
            $classSection = "fancy";
        }
        if (ERROR_404 != "Y" && (strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog']) === false || strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog_search']) === 0)):?>
            <section class="<?=$classSection?>">
                <?if ($APPLICATION->GetCurDir() == SITE_DIR):?>
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR . "include/main_banner.php",
                        Array(
                            'MAIN_SLIDER_TYPE' => " lapping",
                        )
                    );?>
                    <div class="main-product-tabs">
                        <div class="advanced-container-medium">
                            <select class="select-tabs hide-for-large">
                                <option value="#product-tab-recomend"><?=getMessage('TITLE_TAB_RECOMEND')?></option>
                                <option value="#product-tab-news"><?=getMessage('TITLE_TAB_NEWS')?></option>
                                <option value="#product-tab-hits"><?=getMessage('TITLE_TAB_HITS')?></option>
                                <option value="#product-tab-discount"><?=getMessage('TITLE_TAB_DISCOUNT')?></option>
                            </select>
                            <ul class="tabs inline-block-container text-center show-for-large" id="main-product-tabs" data-tabs>
                                <li class="tabs-title inline-block-item float-none is-active"><a href="#product-tab-recomend"><span><?=getMessage('TITLE_TAB_RECOMEND')?></span></a></li>
                                <li class="tabs-title inline-block-item float-none"><a href="#product-tab-news"><span><?=getMessage('TITLE_TAB_NEWS')?></span></a></li>
                                <li class="tabs-title inline-block-item float-none"><a href="#product-tab-hits"><span><?=getMessage('TITLE_TAB_HITS')?></span></a></li>
                                <li class="tabs-title inline-block-item float-none"><a href="#product-tab-discount"><span><?=getMessage('TITLE_TAB_DISCOUNT')?></span></a></li>
                            </ul>
                        </div>
                        <div class="container row tabs-content" data-tabs-content="main-product-tabs">
                            <?$arTabs = array('recomend', 'news', 'hits', 'discount');
                            foreach ($arTabs as $type):?>
                                <div class="tabs-panel<?if ($type == 'recomend'):?> is-active<?endif;?>" id="product-tab-<?=$type?>">
                                    <div class="products-flex-grid product-grid product-grid-<?=$type?>">
                                        <?$APPLICATION->IncludeFile(
                                            SITE_DIR . "include/popup/product_tab.php",
                                            Array(
                                                'TYPE' => $type,
                                            )
                                        );?>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR . "include/news_advantages_brands.php",
                        Array(
                            'NEWS_TYPE' => 3,
                        )
                    );?>
                <?elseif (strpos($APPLICATION->GetCurDir(), SITE_DIR . 'company/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'shop/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'info/') === 0):?>
                    <div class="advanced-container-medium">
                        <nav>
                            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
                                    "START_FROM" => "0", 
                                    "PATH" => "", 
                                )
                            );?>
                        </nav>
                        <article class="inner-container">
                            <h1><?$APPLICATION->ShowTitle(false)?></h1>
                            <?$APPLICATION->IncludeComponent("bitrix:menu", "left", array(
                                    "ROOT_MENU_TYPE" => "left",
                                    "MENU_CACHE_TYPE" => "Y",
                                    "MENU_CACHE_TIME" => "36000000",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MAX_LEVEL" => "1",
                                    "USE_EXT" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "DELAY" => "N",
                                ),
                                false
                            );?>
                            <div class="inner-content columns">
                <?elseif (($APPLICATION->GetCurDir() == SITE_DIR . 'personal/' || $APPLICATION->GetCurDir() == SITE_DIR . 'personal/profile/') && $USER->IsAuthorized()):?>
                    <div class="inner-bg">
                        <div class="advanced-container-medium">
                            <article class="profile-container">
                                <h1 class="text-center"><?$APPLICATION->ShowTitle(false)?></h1>
                <?elseif ($APPLICATION->GetCurDir() == SITE_DIR . 'personal/cart/' || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'personal/order/') === 0):?>
                    <div class="inner-bg">
                        <div class="advanced-container-medium">
                <?elseif (strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog_search']) === 0):?>
                    <div class="advanced-container-medium">
                        <nav>
                            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
                                    "START_FROM" => "0", 
                                    "PATH" => "", 
                                )
                            );?>
                        </nav>
                        <article class="inner-container">
                            <h1><?$APPLICATION->ShowTitle(false)?></h1>
                <?else:?>
                    <div class="inner-bg">
                        <article class="inner-container float-center table-container">
                <?endif;?>
        <?endif;?>