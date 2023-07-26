<?php
namespace VideoWallSimple;

class ErrorHandler
{
    private $echoFlag;

    public function __construct($echoFlag = false)
    {
        $this->echoFlag = $echoFlag;
    }

    function onError($error, $additional_info = Null) {
        header('Content-type: text/plain');

        switch($error) {
            case 'Invalid handler':
                http_response_code(400);
                $msg = "$error. Use one of: ";
                if(is_array($additional_info)) $additional_info = implode(', ', array_keys($additional_info));
                break;

            case 'MODX is undefined':
            case 'MODX Document Parser is undefined':
                http_response_code(500);
                $msg = "MODX Document Parser is undefined.";
                break;

            case 'Document ID is undefined':
                http_response_code(400);
                $msg = "$error. " .
                        "Failed to get document ID automatically via modx document parser or via referer. " .
                        "You can set \"documentID\" field manually via snippet parameter";            //why
                break;

            case 'Query is undefined':
                http_response_code(400);
                $msg = "$error. You can set \"get\" field via get parameter or snippet parameter.";
                break;

            default:
                http_response_code(500);
                $msg = "Unknown error.";
                break;
        }

        if(is_string($additional_info)) $msg .= " $additional_info";
        if($this->echoFlag) { echo $msg; return ''; }
        return $msg;
    }
}
