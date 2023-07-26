<?php
namespace VideoWallSimple\News;

class LocalNews extends News
{
    public function __construct($templateVarOutput) {
        parent::__construct($templateVarOutput);
        $this->newsType = 'local-news';
    }
}
