<?php
namespace VideoWallSimple;

include_once $_SERVER['DOCUMENT_ROOT'] . '/assets/snippets/ditto/classes/phx.parser.class.inc.php';
require_once 'autoload.php';


$ErrorHandler = new ErrorHandler(true);
if(!isset($modx)) { define('MODX_API_MODE', true); require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php'); }
if(!isset($modx)) { return $ErrorHandler->onError('MODX is undefined'); }

if(!isset($documentId)) { $documentId = $modx->documentObject['id']; }
if(!isset($documentId)) { $documentId = Tools::getRefererId($modx); }
if(!isset($documentId)) { return $ErrorHandler->onError('Document ID is undefined'); }

if(!isset($get)) { $get = $_GET['get']; }
if(!isset($get)) { return $ErrorHandler->onError('Query is undefined'); }

$templateVarNames = ['local-news', 'global-news', 'slides', 'videos'];
$templateVarOutput = $modx->getTemplateVarOutput($templateVarNames, $documentId);

$allowedHandlers = [
    'global-news' => 'News\\GlobalNews',
    'local-news' => 'News\\LocalNews',
    'slides' => 'Slides\\Slides',
    'videos' => 'Videos\\Videos'];
$handlerName = $allowedHandlers[$get];

if(!$handlerName) { return $ErrorHandler->onError('Invalid handler', $allowedHandlers); }
$handlerName = __NAMESPACE__ . '\\' . $handlerName;
$handler = new $handlerName($templateVarOutput);
echo $handler->get();
return;
