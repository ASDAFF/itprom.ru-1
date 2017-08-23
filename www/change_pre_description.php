<?
if (isset($_REQUEST['work_start']))
{
    define("NO_AGENT_STATISTIC", true);
    define("NO_KEEP_STATISTIC", true);
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");
IncludeModuleLangFile(__FILE__);
$POST_RIGHT = $APPLICATION->GetGroupRight("main");
if ($POST_RIGHT == "D")
    $APPLICATION->AuthForm("Доступ запрещен");
$BID = 4;
$limit = 100;
if($_REQUEST['work_start'] && check_bitrix_sessid())
{
    $rsEl = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => $BID, ">ID" => $_REQUEST["lastid"]), false, array("nTopCount" => $limit));
    while ($arEl = $rsEl->Fetch())
    {
        $var = CIBlockElement::GetList(
            array(),
            array(
                "ID" => $arEl["ID"],
                "IBLOCK_ID" => 4,
                "IBLOCK_TYPE" => "catalog",
            ),
            false,
            false,
            array(
                "ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*", "IBLOCK_SECTION_ID"
            )
        );
        $var2 = CIBlockElement::GetList(
            array(),
            array(
                "ID" => $arEl["ID"],
                "IBLOCK_ID" => 4,
                "IBLOCK_TYPE" => "catalog",
            ),
            false,
            false,
            array(
                "ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*", "IBLOCK_SECTION_ID"
            )
        );
        $element = $var->GetNextElement();
        //AddMessage2Log($element);
        $props = $element->GetProperties();
        //AddMessage2Log($props);
        $element2 = $var2->Fetch();
        $section_id = $element2["IBLOCK_SECTION_ID"];
        //AddMessage2Log($section_id);
        //AddMessage2Log($o);
        //Fetch section property
        $uf_iblock_id = 4; //ID инфоблока
        $uf_section_id = $section_id;
        $uf_name = Array("UF_PRE_DESC_TEMPLATE");
        $PREDESCRIPTION = "";
        if (CModule::IncludeModule("iblock")): //подключаем модуль инфоблок для работы с классом CIBlockSection
            $uf_arresult = CIBlockSection::GetList(Array("SORT" => "­­ASC"), Array("IBLOCK_ID" => $uf_iblock_id, "ID" => $uf_section_id), false, $uf_name);
            if ($uf_value = $uf_arresult->GetNext()):
                if (strlen($uf_value["UF_PRE_DESC_TEMPLATE"]) > 0): //проверяем что поле заполнено
                    $PREDESCRIPTION = $uf_value["~UF_PRE_DESC_TEMPLATE"];
                    $string_to_find = "/#[A-Z_n]+#/";
                    $matches = Array();
                    preg_match_all($string_to_find, $PREDESCRIPTION, $matches);
                    if (count($matches > 0)):
                        $matches = $matches[0];
                        for ($i = 0; $i < count($matches); $i++) {
                            $value = $matches[$i][1] != 'n';
                            $match = trim($matches[$i], "#n");
                            if ($value)
                                $replace = $props[$match]["VALUE"];
                            else
                                $replace = $props[$match]["NAME"];
                            $PREDESCRIPTION = str_replace($matches[$i], $replace, $PREDESCRIPTION);
                        }
                        //$arResult["DETAIL_TEXT"] = $DESCRIPTION;
                    endif;
                endif;
            endif;
        endif;
        //=======
//        AddMessage2Log($DESCRIPTION);
        //AddMessage2Log($arEl);
//        CIBlockELement::Update($arEl["ID"],
//            Array(
//                "DETAIL_TEXT" => $DESCRIPTION,
//            ));
        //AddMessage2Log($arEl["ID"]);
        $el = new CIBlockElement;
        $PROP = array();
        $PROP["PREVIEW_TEXT"] = $PREDESCRIPTION;;
        $res = $el->Update($arEl["ID"], $PROP);
        $lastID = intval($arEl["ID"]);
    }
    $rsLeftBorder = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => $BID, "<=ID" => $lastID));
    $leftBorderCnt = $rsLeftBorder->SelectedRowsCount();
    $rsAll = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => $BID));
    $allCnt = $rsAll->SelectedRowsCount();
    $p = round(100*$leftBorderCnt/$allCnt, 2);
    echo 'CurrentStatus = Array('.$p.',"'.($p < 100 ? '&lastid='.$lastID : '').'","Обрабатываю запись с ID #'.$lastID.'");';
    die();
}
$clean_test_table = '<table id="result_table" cellpadding="0" cellspacing="0" border="0" width="100%" class="internal">'.
    '<tr class="heading">'.
    '<td>Текущее действие</td>'.
    '<td width="1%">&nbsp;</td>'.
    '</tr>'.
    '</table>';
$aTabs = array(array("DIV" => "edit1", "TAB" => "Обработка"));
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$APPLICATION->SetTitle("Обработка элементов инфоблока");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>
    <script type="text/javascript">
        var bWorkFinished = false;
        var bSubmit;
        function set_start(val)
        {
            document.getElementById('work_start').disabled = val ? 'disabled' : '';
            document.getElementById('work_stop').disabled = val ? '' : 'disabled';
            document.getElementById('progress').style.display = val ? 'block' : 'none';
            if (val)
            {
                ShowWaitWindow();
                document.getElementById('result').innerHTML = '<?=$clean_test_table?>';
                document.getElementById('status').innerHTML = 'Работаю...';
                document.getElementById('percent').innerHTML = '0%';
                document.getElementById('indicator').style.width = '0%';
                CHttpRequest.Action = work_onload;
                CHttpRequest.Send('<?= $_SERVER["PHP_SELF"]?>?work_start=Y&lang=<?=LANGUAGE_ID?>&<?=bitrix_sessid_get()?>');
            }
            else
                CloseWaitWindow();
        }
        function work_onload(result)
        {
            try
            {
                eval(result);
                iPercent = CurrentStatus[0];
                strNextRequest = CurrentStatus[1];
                strCurrentAction = CurrentStatus[2];
                document.getElementById('percent').innerHTML = iPercent + '%';
                document.getElementById('indicator').style.width = iPercent + '%';
                document.getElementById('status').innerHTML = 'Работаю...';
                if (strCurrentAction != 'null')
                {
                    oTable = document.getElementById('result_table');
                    oRow = oTable.insertRow(-1);
                    oCell = oRow.insertCell(-1);
                    oCell.innerHTML = strCurrentAction;
                    oCell = oRow.insertCell(-1);
                    oCell.innerHTML = '';
                }
                if (strNextRequest && document.getElementById('work_start').disabled)
                    CHttpRequest.Send('<?= $_SERVER["PHP_SELF"]?>?work_start=Y&lang=<?=LANGUAGE_ID?>&<?=bitrix_sessid_get()?>' + strNextRequest);
                else
                {
                    set_start(0);
                    bWorkFinished = true;
                }
            }
            catch(e)
            {
                CloseWaitWindow();
                document.getElementById('work_start').disabled = '';
                alert('Сбой в получении данных');
            }
        }
    </script>

    <form method="post" action="<?echo $APPLICATION->GetCurPage()?>" enctype="multipart/form-data" name="post_form" id="post_form">
        <?
        echo bitrix_sessid_post();
        $tabControl->Begin();
        $tabControl->BeginNextTab();
        ?>
        <tr>
            <td colspan="2">

                <input type=button value="Старт" id="work_start" onclick="set_start(1)" />
                <input type=button value="Стоп" disabled id="work_stop" onclick="bSubmit=false;set_start(0)" />
                <div id="progress" style="display:none;" width="100%">
                    <br />
                    <div id="status"></div>
                    <table border="0" cellspacing="0" cellpadding="2" width="100%">
                        <tr>
                            <td height="10">
                                <div style="border:1px solid #B9CBDF">
                                    <div id="indicator" style="height:10px; width:0%; background-color:#B9CBDF"></div>
                                </div>
                            </td>
                            <td width=30>&nbsp;<span id="percent">0%</span></td>
                        </tr>
                    </table>
                </div>
                <div id="result" style="padding-top:10px"></div>

            </td>
        </tr>
        <?
        $tabControl->End();
        ?>
    </form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>