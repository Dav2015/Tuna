<?php

$possibleTypes = array("image/jpeg", "image/png", "audio/mp3", "video/mp4");

//storage azure server
$server = "https://tuna.file.core.windows.net/tuna/";
$credential = "?sv=2018-03-28&si=tunaAcess&sr=s&sig=wwa%2BFIrX9qviMQaZpTdLbzKiIu3sgHNNxKGitzaENdA%3D";
$isLocalhost = FALSE;

if ($isLocalhost) {
    $linkRoot = "$_SERVER[HTTP_HOST]/tuna/SMI_site";
} else {
    $linkRoot = $_SERVER[HTTP_HOST];
}

function getFile($SGF_pathToImage) {
    global $server;
    global $credential;
    global $isLocalhost;

    if ($isLocalhost) {
        $url = $SGF_pathToImage;
    } else {
        $url = $server . substr($SGF_pathToImage, 3) . $credential;
    }

    return $url;
}

function addMultimediaFile() {

    return true;
}

function addOneFile() {
    
}

function isTypeAceptable($fileTypeExtension) {
    global $possibleTypes;
    return in_array($fileTypeExtension, $possibleTypes);
}

function createPathIFNotExist($targetPath) {
    
}

function deleteMultimediaFile($request) {
    
}
