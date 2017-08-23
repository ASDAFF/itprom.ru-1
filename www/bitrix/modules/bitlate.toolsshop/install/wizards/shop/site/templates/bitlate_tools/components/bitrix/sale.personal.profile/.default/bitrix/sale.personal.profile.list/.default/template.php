<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="column profile-column-item shipping" data-order="3">
    <div class="profile-block">
        <div class="profile-block-caption">
            <svg class="icon">
                <use xlink:href="#svg-icon-delivery"></use>
            </svg>
            <?=GetMessage("PROFILE_LIST_TITLE")?>
        </div>
        <div class="profile-block-wrap">
            <?if (count($arResult["PROFILES"]) > 0):?>
                <ul class="profile-block-list">
                    <?foreach($arResult["PROFILES"] as $i => $val):?>
                        <li data-id="<?=$val["ID"]?>">
                            <?if ($i == 0):?>
                                <span class="label secondary"><?=GetMessage("PROFILE_LIST_DEFAULT")?></span>
                            <?endif;?>
                            <div><?=$val["NAME"]?></div>
                            <div>
                                <a href="#edit-delivery-<?=$val["ID"]?>" class="padding fancybox"><?=GetMessage("PROFILE_UPDATE")?></a>
                                <a href="#del-delivery" class="padding fancybox show-del-delivery" data-id="<?=$val["ID"]?>"><?=GetMessage("PROFILE_DELETE")?></a>
                                <?$APPLICATION->IncludeComponent("bitlate:sale.personal.profile.detail","",Array(
                                    "PATH_TO_LIST" => "profile_list.php",
                                    "PATH_TO_DETAIL" => "profile_detail.php?ID=#ID#",
                                    "ID" => $val["ID"],
                                    "USE_AJAX_LOCATIONS" => "Y",
                                    "SET_TITLE" => "N"
                                ));?>
                            </div>
                        </li>
                    <?endforeach;?>
                </ul>
            <?else:?>
                <p><?=GetMessage("PROFILE_LIST_EMPTY")?></p>
            <?endif;?>
            <a href="#new-delivery" class="button small secondary fancybox"><?=GetMessage("PROFILE_ADD")?></a>
            <div id="profile-default-text" style="display: none;"><span class="label secondary"><?=GetMessage("PROFILE_LIST_DEFAULT")?></span></div>
            <div id="profile-empty-text" style="display: none;"><p><?=GetMessage("PROFILE_LIST_EMPTY")?></p></div>
        </div>
        <div id="del-delivery" class="fancybox-block">
            <div class="fancybox-block-wrap profile-block-confirm text-center">
                <svg class="icon fancybox-icon">
                    <use xlink:href="#svg-icon-question"></use>
                </svg>
                <div class="message-block profile-block-confirm-text hide"></div>
                <div class="confirm-block profile-block-confirm-text"><?=GetMessage("STPPL_DELETE_CONFIRM")?></div>
                <div class="confirm-block row small-up-2 hide">
                    <div class="column">
                        <a href="#" class="small-12 button small fancybox-button secondary fancybox-cancel"><?=GetMessage("STPPL_DELETE_CANCEL")?></a>
                    </div>
                    <div class="column">
                        <a href="#" class="small-12 column button small fancybox-button profile-remove"><?=GetMessage("STPPL_DELETE_OK")?></a>
                    </div>
                </div>
                <form method="post" action="<?=SITE_DIR?>nl_ajax/profile_remove.php">
                    <input type="hidden" name="id" value=""/>
                    <?=bitrix_sessid_post()?>
                </form>
            </div>
        </div>
    </div>
</div>