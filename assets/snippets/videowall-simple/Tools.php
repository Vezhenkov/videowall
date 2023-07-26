<?php

namespace VideoWallSimple;

class Tools
{
    static function getRefererId($modx) {
        $explodedRefererPath = explode('/', $_SERVER['HTTP_REFERER']);
        $RefererAlias = end($explodedRefererPath);
        return $modx->getDocumentObject('alias', $RefererAlias)['id'];
    }
}
