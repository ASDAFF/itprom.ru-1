<?php
$profileId = intval( $argv[1] );
$documentRoot = $argv[2];
global $cronpage;
$cronpage = $argv[3];
$_REQUEST["unlock"] = "Y";
set_time_limit( 0 );


require_once( dirname(__DIR__)."/classes/general/cexportprotools.php" );

$_SERVER["DOCUMENT_ROOT"] = $DOCUMENT_ROOT = CAcritExportproTools::NormalisePath( $documentRoot );
require( $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );

CModule::IncludeModule( "acrit.exportpro" );
AcritExportproSession::Init( 0 );
AcritExportproSession::DeleteSession( $profileId );
CExportproCron::StartExport( $profileId );