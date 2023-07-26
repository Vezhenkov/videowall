<?php
namespace VideoWallSimple\News;

class News
{
    private $templateVarOutput;
    protected $newsType = 'news';

    public function __construct($templateVarOutput) {
        $this->templateVarOutput = $templateVarOutput;
    }

    public function getBlock($title, $text) {
        return "<div class=\"{$this->newsType}__item\">
                    <div class=\"{$this->newsType}__title\">$title</div>
                    <div class=\"{$this->newsType}__content\">$text</div>
                </div>";
    }

    public function get() {
        $result = '';

        $Param = $this->templateVarOutput[$this->newsType];
        $ParamRows = explode('||', $Param);
        foreach($ParamRows as $ParamSingleRow) {
            $ParamValues = explode('::', $ParamSingleRow);
            $ParamTitle = $ParamValues[0];
            $ParamText = $ParamValues[1];

            $result .= $this->getBlock($ParamTitle, $ParamText);
        }

        header('Content-type: text/html');
        http_response_code(200);
        return $result;
    }
}
