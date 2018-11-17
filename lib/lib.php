<?php

function getBrowser() {
    $userBrowser = '';
    /*
      foreach( $_SERVER as $key => $value) {
      echo $key . "=>" . $value . "<br>\n";
      }
      exit(0);
     */

    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    //echo $userAgent;

    if (preg_match('/Trident/i', $userAgent)) {
        $userBrowser = "Internet Explorer";
    } elseif (preg_match('/MSIE/i', $userAgent)) {
        $userBrowser = "Internet Explorer";
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $userBrowser = "Mozilla Firefox";
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $userBrowser = "Apple Safari";
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $userBrowser = "Google Chrome";
    } elseif (preg_match('/Flock/i', $userAgent)) {
        $userBrowser = "Flock";
    } elseif (preg_match('/Opera/i', $userAgent)) {
        $userBrowser = "Opera";
    } elseif (preg_match('/Netscape/i', $userAgent)) {
        $userBrowser = "Netscape";
    }

    if (preg_match('/Mobile/i', $userAgent)) {
        $userBrowser = "Mobile Device";
    }
    return $userBrowser;
}

function redirectToPage($url, $title, $message, $refresTime) {
    echo "<html>\n";
    echo "  <head>\n";
    echo "    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n";
    echo "    <meta http-equiv=\"REFRESH\" content=\"$refresTime;url=$url\">\n";
    echo "    <title>$title</title>\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "    <p>$message</p>";
    echo "    <p>You will be redirect in $refresTime seconds.</p>";
    echo "  </body>\n";
    echo "</html>";
    exit(1);
}

function redirectToLastPage($title, $refreshTime = 5) {
    $referer = $_SERVER["HTTP_REFERER"];

    echo "<html>\n";
    echo "  <head>\n";
    echo "    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n";
    echo "    <meta http-equiv=\"REFRESH\" content=\"$refreshTime;url=$referer\">\n";
    echo "    <title>$title</title>\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "    <p> Invalid data!";
    echo "    <p> Please fill all the fields marked with *. You will be redirect to the last page in $refreshTime seconds\n";
    echo "  </body>\n";
    echo "</html>";
}

$find;
$replace;

function convertToEntities($str) {
    global $find;
    global $replace;

    if (($find == NULL) || ($replace == NULL)) {
        $find = array();
        $replace = array();

        foreach (get_html_translation_table(HTML_ENTITIES, ENT_QUOTES) as $key => $value) {
            $find[] = $key;
            $replace[] = $value;
        }
    }

    return str_replace($find, $replace, $str);
}

//da o caminho para a aplicaçao sem localhost eo ficheiro atual
function webAppName() {
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    $n = count($uri);
    $webApp = "";
    for ($idx = 0; $idx < $n - 1; $idx++) {
        $webApp .= ($uri[$idx] . "/" );
    }

    return $webApp;
}

function prepareHeaders() {
    list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

function ensureAuth($redirectPage) {
    prepareHeaders();

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        header("Location: $redirectPage");
        exit;
    }
}

function showAuth($authType, $realm, $message) {
    header("WWW-Authenticate: $authType realm=\"$realm\"");
    header("HTTP/1.0 401 Unauthorized");

    echo $message;
}



function existUserField($field, $value, $authType = "basic") {
    $exists = true;

    dbConnect(ConfigFile);

    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    $query = "SELECT * FROM `smi`.`auth-$authType` " .
            "WHERE `$field`='$value'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows == 0) {
        $exists = false;
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $exists;
}



function getEmail($userId, $authType) {
    $userEmail = -1;

    dbConnect(ConfigFile);

    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    $query = "SELECT `email` FROM `smi`.`auth-$authType` WHERE `id`='$userId'";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $userData = mysqli_fetch_array($result);
        $userEmail = $userData['email'];
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $userEmail;
}

function logout() {
    unset($_SERVER['PHP_AUTH_USER']);
    unset($_SERVER['PHP_AUTH_PW']);
    unset($_SERVER['HTTP_AUTHORIZATION']);
    session_start();
    session_destroy();
}

function getFileDetails($ids) {
    $isFirst = true;
    $whereClause = "";

    if (is_array($ids)) {
        foreach ($ids as $id) {
            if ($isFirst == false) {
                $whereClause .= " OR `id`='$id'";
            } else {
                $whereClause .= "`id`='$id'";
                $isFirst = false;
            }
        }
    } else {
        $whereClause = "`id`='$ids'";
    }

    dbConnect(MAIN_DATABASE);
    
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `images-details` WHERE " . $whereClause;
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $idx = 0;
    $fileData = array();

    while (($fileDataRecord = mysqli_fetch_array($result)) != false) {
        $fileData[$idx] = $fileDataRecord;
        ++$idx;
    }

    mysqli_free_result($result);
    dbDisconnect();

    if (!is_array($ids)) {
        return $fileData[0];
    } else {
        return $fileData;
    }
}

function getConfiguration() {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `images-config`";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $configuration = mysqli_fetch_array($result);
    mysqli_free_result($result);
    dbDisconnect();
    return $configuration;
}

function getStats() {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    "SELECT COUNT(DISTINCT `mimeFileName`) FROM `images-details`;";
    "SELECT DISTINCT `mimeFileName` FROM `images-details`;";

    $queryTotal = "SELECT count(*) AS totalFiles FROM `images-details`";
    $queryImages = "SELECT count(*) AS totalImages FROM `images-details` WHERE `mimeFileName`='image'";
    $queryVideos = "SELECT count(*) AS totalVideos FROM `images-details` WHERE `mimeFileName`='video'";
    $queryAudios = "SELECT count(*) AS totalAudios FROM `images-details` WHERE `mimeFileName`='audio'";

    // Total files
    $resultTotal = mysqli_query($GLOBALS['ligacao'], $queryTotal);
    $totalData = mysqli_fetch_array($resultTotal);
    $stats['numFiles'] = $totalData['totalFiles'];
    mysqli_free_result($resultTotal);

    // Image files
    $resultImages = mysqli_query($GLOBALS['ligacao'], $queryImages);
    $totalImages = mysqli_fetch_array($resultImages);
    $stats['numImages'] = $totalImages['totalImages'];
    mysqli_free_result($resultImages);

    // Video files
    $resultVideos = mysqli_query($GLOBALS['ligacao'], $queryVideos);
    $totalVideos = mysqli_fetch_array($resultVideos);
    $stats['numVideos'] = $totalVideos['totalVideos'];
    mysqli_free_result($resultVideos);

    // Audio files
    $resultAudios = mysqli_query($GLOBALS['ligacao'], $queryAudios);
    $totaltAudios = mysqli_fetch_array($resultAudios);
    $stats['numAudios'] = $totaltAudios['totalAudios'];
    mysqli_free_result($resultAudios);

    dbDisconnect();
    return $stats;
}

function showUploadFileError($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_OK:
            $errorMessage = "($errorCode) There is no error, the file uploaded with success.";
            break;

        case UPLOAD_ERR_INI_SIZE:
            $errorMessage = "($errorCode) The uploaded file exceeds the upload_max_filesize directive in php.ini file.";
            break;

        case UPLOAD_ERR_FORM_SIZE:
            $errorMessage = "($errorCode) The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
            break;

        case UPLOAD_ERR_PARTIAL:
            $errorMessage = "($errorCode) The uploaded file was only partially uploaded.";
            break;

        case UPLOAD_ERR_NO_FILE:
            $errorMessage = "($errorCode) No file was uploaded.";
            break;

        case UPLOAD_ERR_NO_TMP_DIR:
            $errorMessage = "($errorCode) Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.";
            break;

        case UPLOAD_ERR_CANT_WRITE:
            $errorMessage = "($errorCode) Failed to write file to disk. Introduced in PHP 5.1.0.";
            break;

        case UPLOAD_ERR_EXTENSION:
            $errorMessage = "($errorCode) A PHP extension stopped the file upload.";
            break;

        default:
            $errorMessage = "($errorCode) No description available.";
            break;
    }

    return $errorMessage;
}

function getXdebugArg() {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        $args = $_POST;
    } elseif ($method == 'GET') {
        $args = $_GET;
    }

    foreach ($args as $key => $value) {
        if ($key === "XDEBUG_SESSION_START") {
            return "XDEBUG_SESSION_START=$value";
        }
    }

    return null;
}

function getXdebugArgAsArray() {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        $args = $_POST;
    } elseif ($method == 'GET') {
        $args = $_GET;
    }

    foreach ($args as $key => $value) {
        if ($key === "XDEBUG_SESSION_START") {
            return array("key" => $key, "value" => $value);
        }
    }

    return null;
}

?>