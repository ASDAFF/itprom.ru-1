<?IncludeTemplateLangFile(__FILE__);?>
	<!--    Bottom info here -->
    <div class="wrapper info-wrapper">
      <div class="information-block">
        <div class="col-left">
          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/footer/site.php"));?>
			<p style="margin-top: 25px;"><a href="http://www.webfly.pro" target="_blank"><?=GetMessage("WF_DEVELOPMENT")?></a>:<br/>
          webfly.pro</p>
        </div>
        <div class="contacts">
          <div class="col20">
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/footer/social.php"));?>
          </div>
          <div class="col20">
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/footer/paytext.php"));?>
          </div>
          <div class="col20">
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/footer/callblock.php"));?>
            <p><span class="small-text"><a href="#"><?=GetMessage("WF_FOOTER_CALL_ME");?></a></span></p>
          </div>
        </div>
        <div class="text">
          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/footer/disclaimer.php"));?>
        </div>
      </div>
    </div>
    <!-- Footer fixed -->
    <div class="footer-row">
      <div class="footer-center">
        <div class="block-feedback">
          <a href="#" class="link-feedback"><span><?=GetMessage("WF_FOOTER_FEEDBACK");?></span></a>
          <div class="popup-feedback" mode="" mode-mess="">
            <?$APPLICATION->IncludeComponent(
              "webfly:message.add", 
              "main_feed", 
              array(
                "OK_TEXT" => GetMessage("WF_OK_TEXT"),
                "EMAIL_TO" => "",
                "IBLOCK_TYPE" => "feedback",
                "IBLOCK_ID" => "#WF_IB_FEEDBACK#",
                "EVENT_MESSAGE_ID" => array(
                  0 => "#WF_FEEDBACK_EVENT#",
                ),
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "SET_TITLE" => "N"
              ),
              false
            );?>
          </div>
        </div>
        <span class="link-top-hold">
          <a href="#" class="link-top">&nbsp;</a> 
          <span class="arrow-grey">&nbsp;</span> 
        </span>
        <?$APPLICATION->IncludeComponent(
          "bitrix:sale.basket.basket.line",
          "footer",
          Array(
            "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "SHOW_PERSONAL_LINK" => "N",
            "SHOW_NUM_PRODUCTS" => "Y",
            "SHOW_TOTAL_PRICE" => "Y",
            "SHOW_EMPTY_VALUES" => "N",
            "SHOW_PRODUCTS" => "N",
            "POSITION_FIXED" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",	
              
          )
        );?>
        <ul class="info">
          <?
          $ant = $APPLICATION->GetCurDir();
          if(substr_count($ant,"/catalog/")>0) $showCompare = true;
          else $showCompare = false;
          $Fav = new wfHighLoadBlock("#HLB_FAV#");
          $favList = $Fav->elemGet();
          $favCount = count($favList);
          ?>
          <li <?=($showCompare?'':'style="border-right: 1px solid #c2c2c2"')?>>
            <a href="<?=SITE_DIR?>favorites/"><?=GetMessage("WF_FAVORITES")?>:</a>
            <?if($favCount > 0):?>
              <span class="favCount favCount--active"><?=$favCount?></span>
            <?else:?>
              <span class="favCount">0</span>
            <?endif;?>
            <span id="fav" class="add-block new"> <?=GetMessage("WF_FAVORITES_ADDED")?> </span>
          </li>
          <?if($showCompare){
            $APPLICATION->ShowViewContent("wf_compare_list");
          }
          ?>      
        </ul>
      </div>
    </div>

    <!-- Other -->
    <div class="bg">&nbsp;</div>
    <div class="bg2">&nbsp;</div>
    <div id="virtual" class="link-basket"></div>
    <div id="virt_checked"></div>
    <div class="loader_bg">
      <div class="loader" title="7">
      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="60px" height="40px" viewBox="0 0 60 40" style="enable-background:new 0 0 50 50;" xml:space="preserve">
        <rect x="0" y="40" width="6" height="15" fill="#333" opacity="0.2">
          <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0s" dur="0.75s" repeatCount="indefinite" />
        </rect>
        <rect x="12" y="40" width="6" height="15" fill="#333"  opacity="0.2">
          <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.15s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.15s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.15s" dur="0.75s" repeatCount="indefinite" />
        </rect>
        <rect x="24" y="40" width="6" height="15" fill="#333"  opacity="0.2">
          <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.3s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.3s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.3s" dur="0.75s" repeatCount="indefinite" />
        </rect>
        <rect x="36" y="40" width="6" height="15" fill="#333"  opacity="0.2">
          <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.45s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.45s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.45s" dur="0.75s" repeatCount="indefinite" />
        </rect>
        <rect x="48" y="40" width="6" height="15" fill="#333"  opacity="0.2">
          <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.6s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.6s" dur="0.75s" repeatCount="indefinite" />
          <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.6s" dur="0.75s" repeatCount="indefinite" />
        </rect>
      </svg>
    </div>
  </body>
</html>