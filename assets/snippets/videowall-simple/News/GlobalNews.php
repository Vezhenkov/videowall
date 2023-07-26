<?php
namespace VideoWallSimple\News;

class GlobalNews extends News
{
    public function __construct($templateVarOutput) {
        parent::__construct($templateVarOutput);
        $this->newsType = 'global-news';
    }
}
