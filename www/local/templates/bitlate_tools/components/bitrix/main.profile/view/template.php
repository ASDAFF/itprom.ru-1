<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="column profile-column-item contact-information" data-order="1">
    <div class="profile-block">
        <div class="profile-block-caption">
            <svg class="icon">
                <use xlink:href="#svg-icon-profile"></use>
            </svg>
            <?=GetMessage('PROFILE_TITLE')?>
        </div>
        <div class="profile-block-wrap">
            <table>
                <tr>
                    <th><?=GetMessage('FAM_NAME')?>:</th>
                    <td><?=implode(' ', array($arResult["arUser"]['LAST_NAME'], $arResult["arUser"]['NAME']))?></td>
                </tr>
                <tr>
                    <th><?=GetMessage('EMAIL')?>:</th>
                    <td><?=$arResult["arUser"]["EMAIL"]?></td>
                </tr>
                <tr>
                    <th><?=GetMessage('USER_PHONE')?>:</th>
                    <td><?=$arResult["arUser"]["PERSONAL_PHONE"]?></td>
                </tr>
            </table>
            <div class="profile-table-button">
                <a href="#profile-data" class="button small secondary fancybox"><?=GetMessage('PROFILE_EDIT')?></a>
                <a href="#profile-pass" class="button small secondary fancybox"><?=GetMessage('PASSWORD_EDIT')?></a>
            </div>
        </div>
    </div>
</div>