<?
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class wfHighLoadBlock{
  private $hlBlockID = 0;//индекс справочника
  private $hlHandler = null;//обработчик
  function __construct($hlblockid){
    $this->hlBlockID = $hlblockid;
    $hlblock = HL\HighloadBlockTable::getById($hlblockid)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $this->hlHandler = $entity->getDataClass();
  }
  function elemAdd($elemId){
    $usr = new CUser;
    if(!empty($elemId) and $usr->IsAuthorized()){
      $hlHandler = $this->hlHandler;
      $data = array("UF_USER_ID" => $usr->GetID(), "UF_FAV_ID" => $elemId, "UF_XML_ID" => "wf{$elemId}");
      $res = $hlHandler::add($data);
      return $res->getId();
    }
    return false;
  }
  function elemModify($elemId, $data){
    $hlHandler = $this->hlHandler;
    $res = $hlHandler::update($elemId,$data);
    return $res;
  }
  function elemDelete($elemId){
    if(!empty($elemId)){
      $hlHandler = $this->hlHandler;
      $hlHandler::Delete($elemId);
    }
  }
  function elemGet($elemId = false){
    $usr = new CUser;
    $hlHandler = $this->hlHandler;
    $getList = new Entity\Query($hlHandler);
    $getList->setSelect(array('*'));
    $getList->setOrder(array("ID" => "ASC"));
    $filter = array("UF_USER_ID" => $usr->GetID());
    if(!empty($elemId)) $filter += array("ID"=>$elemId);
    $getList->setFilter($filter);
    $result = $getList->exec();
    $result = new CDBResult($result);
    $arRes = array();
    while ($row = $result->Fetch()){
      $arRes[] = $row;
    }
    return $arRes;
  }
  function elemGetEx($elemId = false){
    $hlHandler = $this->hlHandler;
    $getList = new Entity\Query($hlHandler);
    $getList->setSelect(array('*'));
    $getList->setOrder(array("ID" => "ASC"));
    if(!empty($elemId)) $getList->setFilter(array("ID"=>$elemId));
    $result = $getList->exec();
    $result = new CDBResult($result);
    $arRes = array();
    while ($row = $result->Fetch()){
      $arRes[] = $row;
    }
    return $arRes;
  }
  function getHLBlockID(){
    return $this->hlBlockID;
  }
  function getHLHandler(){
    return $this->hlHandler;
  }
}
