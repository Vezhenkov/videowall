<?php

namespace VideoWallSimple\Videos;

class Videos
{
    private $templateVarOutput;

    public function __construct($templateVarOutput) {
        $this->templateVarOutput = $templateVarOutput;
    }

    public function get() {
        $result = [];

        $Param = $this->templateVarOutput['videos'];
        $ParamRows = explode('||', $Param);
        foreach($ParamRows as $ParamSingleRow) {
            $ParamValues = explode('::', $ParamSingleRow);
            array_push($result, array_combine(array('src', 'title'), $ParamValues));
        }

        header('Content-type: application/json');
        http_response_code(200);
        return json_encode($result);
    }
}
