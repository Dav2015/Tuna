<?php
require('vendor/autoload.php');

header('Content-Type: text/html; charset=UTF-8', true);

use \Sightengine\SightengineClient;

$client = new SightengineClient('464711229', 'sqaUm8VBRNNoMuogqu9T');

define("SGF_ROOT", $_SERVER["CONTEXT_DOCUMENT_ROOT"] .
        DIRECTORY_SEPARATOR . "projetoFinal" . DIRECTORY_SEPARATOR . "SGF");

$possibleTypes = array("image/jpeg", "image/png", "audio/mp3", "video/mp4");

function addMultimediaFile($year, $pCategory, $event, $userName, $sCategory, $desc, $visibility, $isPost) {
    $target_dir = "../SGF" . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $pCategory . DIRECTORY_SEPARATOR . $event . DIRECTORY_SEPARATOR . $userName;
    $count = count($_FILES['input-b3']['tmp_name']);
    for ($i = 0; $i < $count; $i++) {
        try {
            if (!addOneFile($i, $target_dir, $pCategory, $event, $userName, $sCategory, $isPost, $desc, $visibility)) {
                return false;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    return true;
}

function addOneFile($i, $target_dir, $pCategory, $event, $userName, $sCategory, $isPost, $desc, $visibility) {
    if (isTypeAceptable($_FILES['input-b3']['type'][$i])) {
        list($fileMultimediaType, $notUse) = explode("/", $_FILES['input-b3']['type'][$i]);
        $target_dir_type = $target_dir . DIRECTORY_SEPARATOR . $fileMultimediaType;
        createPathIFNotExist($target_dir_type);
        $target_dir_type_file = $target_dir_type . DIRECTORY_SEPARATOR . $_FILES['input-b3']['name'][$i];
        $target_dir_type_file = str_replace('\\', '/', $target_dir_type_file);


        if ($fileMultimediaType == "image") {
            if (!isContentSafe($_FILES['input-b3']["tmp_name"][$i])) {
                throw new Exception("O ficheiro " . $_FILES['input-b3']["name"][$i] .
                " tem conteudo impróprio");
            }
        }

        if ($isPost) {
            $isFileUnique = saveInfoFileMultimedia($pCategory, $event, $userName, $target_dir_type_file, $fileMultimediaType, $sCategory, $desc, $visibility);
            if ($isFileUnique) {
                return move_uploaded_file(
                        $_FILES['input-b3']["tmp_name"][$i], $target_dir_type_file);
            } else {
                throw new Exception("O ficheiro " . $_FILES['input-b3']["name"][$i] .
                " já existe na base de dados");
            }
        } else {
            return move_uploaded_file(
                    $_FILES['input-b3']["tmp_name"][$i], $target_dir_type_file);
        }
    }
}

function isContentSafe($file) {
    global $client;
    $output = $client->check(['nudity'])->set_file($file);
    if ($output->nudity->safe >= 0.70) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function isTypeAceptable($fileTypeExtension) {
    global $possibleTypes;
    return in_array($fileTypeExtension, $possibleTypes);
}

function createPathIFNotExist($targetPath) {
    if (!file_exists($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
}

function deleteMultimediaFile($request) {
    
}

function getMultimediaFiles($request, $limit, $type) {
    
}


