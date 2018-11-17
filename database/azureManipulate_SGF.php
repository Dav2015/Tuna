<?php

$possibleTypes = array("image/jpeg", "image/png", "audio/mp3", "video/mp4");

//storage azure server
$server = "https://tunafiles.file.core.windows.net/tunafiles/";
$credential = "?sv=2018-03-28&si=tunafiles&sr=s&sig=778ot79hDkKKCDMKcPDOpXDPUud%2FOzCHEO2Hj%2B0G41Y%3D";
$isLocalhost = TRUE;

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
