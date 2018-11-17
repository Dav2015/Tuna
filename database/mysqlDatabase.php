<?php

/*define("ConfigFile", 
        //DIRECTORY_SEPARATOR . "tuna" .
        DIRECTORY_SEPARATOR . "Config" .
        DIRECTORY_SEPARATOR . ".htconfig.xml");
	*/

define("ConfigFile", "../Config/.htconfig.xml");

define("DEFAULT_ROLE", "Utilizador");



//variaveis globais com acesso a db
static $ligacao;
static $configDataBase;
static $dbName;

function loadConfigurationDataBase($configFile) {
    global $configDataBase;
    if ($configDataBase == NULL) {
        $aux = simplexml_load_file($configFile)
                or die("Can't read data base configuration file.");
        $configDataBase = $aux->DataBase[0];
    }
}

function dbConnect($configFile, $setCharSet = true) {
    global $configDataBase;
    global $ligacao;
    global $dbName;

    loadConfigurationDataBase($configFile);
    $host = strval($configDataBase->host);
    $port = intval($configDataBase->port);
    $username = strval($configDataBase->username);
    $password = strval($configDataBase->password);
    $dbName = strval($configDataBase->db);

    $hostFQN = "$host:$port";

    $ligacao = mysqli_connect($hostFQN, $username, $password)
            or die("Could not connect to data base server ($hostFQN)");

    if (mysqli_connect_error() != 0) {
        echo "ERRO";
    }

    if ($setCharSet == true) {
        mysqli_set_charset($ligacao, 'utf8');
    }
}

function dbDisconnect() {
    global $ligacao;
    mysqli_close($ligacao);
}

function insertNewUser($userName, $realName, $password, $email, $role, $nickname, $hierarchy) {
//Se nao existir role é colocado o role por default
    if (!isset($role)) {
        $role = DEFAULT_ROLE;
    }
    dbConnect(ConfigFile);
    global $dbName;

    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "INSERT INTO `$dbName`.`profile`"
            . "(`Username`,`Password`,`Name`,`Email`,"
            . "`Role`,`Valid`,`Nickname`,`Hierarchy`)" .
            "VALUES('$userName','$password','$realName','"
            . "$email','$role',0,'$nickname','$hierarchy')";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function approveUser($userName) {
    dbConnect(ConfigFile);
    global $dbName;

    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "UPDATE `$dbName`.`profile` SET "
            . "`Valid` = b'1' WHERE `profile`.`Username` = '$userName'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function isValid($userName, $password) {
    $userOk = FALSE;
    dbConnect(ConfigFile);
    global $dbName;

    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    $query = "SELECT * FROM `$dbName`.`profile` " .
            "WHERE `Username`='$userName' AND "
            . "`Password`='$password' AND `Valid`='1'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        //$userData = mysqli_fetch_array($result);
        $userOk = TRUE;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $userOk;
}

function getFromUser($userName, $row) {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `$row`" .
            "FROM `$dbName`.`profile`" .
            "WHERE `Username`='$userName'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $rows = $result->fetch_array(MYSQLI_ASSOC);
    $output = $rows[$row];
    mysqli_free_result($result);
    dbDisconnect();
    return $output;
}

//saber que tipo de usuario é o cliente
function getRole($userName) {
    return getFromUser($userName, 'role');
}

//saber o nome real do user
function getName($userName) {
    return getFromUser($userName, 'Name');
}

function getPrimaryCat() {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `$dbName`.`primary_category`";
    $result = mysqli_query($GLOBALS['ligacao'], $query) or
            die(mysqli_error($GLOBALS['ligacao']));
    $pCats = array();
    while ($row = mysqli_fetch_row($result)) {
        $pCats[] = $row[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $pCats;
}

function getEventWithPCat($pcat) {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `Name` FROM `$dbName`.`event`"
            . " WHERE `P_Category` = '" . $pcat . "'";
    $result = mysqli_query($GLOBALS['ligacao'], $query) or
            die(mysqli_error($GLOBALS['ligacao']));
    $eventNames = array();
    while ($row = mysqli_fetch_row($result)) {
        $eventNames[] = $row[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $eventNames;
}

function createNewEvent($name, $path, $description, $date, $pcat, $visibility, $local) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "INSERT INTO `event`(`Name`, "
            . "`Path`, `Description`, `Date`, `P_Category`, `Visibility`, `Local`)"
            . " VALUES ('" . $name . "','" . $path . "','" . $description .
            "','" . $date . "','" . $pcat . "'," . $visibility . ",'" . $local . "')";
    $result = mysqli_query($GLOBALS['ligacao'], $query)
            or die(mysqli_error($GLOBALS['ligacao']));
    //mysqli_free_result($result);
    dbDisconnect();
    return $result;
}

function getEventDate($pCategory, $event) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `Date` FROM `event` WHERE "
            . "`Name` = '$event' AND `P_Category` = '$pCategory' ";
    $result = mysqli_query($GLOBALS['ligacao'], $query) or
            die(mysqli_error($GLOBALS['ligacao']));
    $rows = $result->fetch_array(MYSQLI_ASSOC);
    $date = $rows['Date'];
    mysqli_free_result($result);
    dbDisconnect();
    return $date;
}

function getEventYear($pCategory, $event) {
    $date = getEventDate($pCategory, $event);
    $year = substr($date, 0, 4);
    return $year;
}

function saveInfoFileMultimedia($pCategory, $event, $userName, $path, $format, $sCategory, $desc, $visibility) {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "INSERT INTO `$dbName`.`post` (`Post_ID`, `Path`, `Format`, "
            . "`Description`, "
            . "`Username`, `Event`, `P_Category`, `S_Category`, `Visibility`) "
            . "VALUES (NULL, '$path', '$format','$desc', '$userName', "
            . "'$event', '$pCategory', '$sCategory', $visibility)";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function getAllEvents($visibility) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `event` WHERE `Visibility` = '$visibility'"
                . "  ORDER BY `event`.`Date` DESC";
    } else {
        $query = "SELECT * FROM `event` ORDER BY `event`.`Date` DESC";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allEvents = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allEvents[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allEvents;
}

function getEvents($visibility, $initLimit, $endLimit) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `event` WHERE `Visibility` = '$visibility'"
                . "  ORDER BY `event`.`Date` DESC LIMIT $initLimit,$endLimit";
    } else {
        $query = "SELECT * FROM `event` ORDER BY `event`.`Date` DESC LIMIT $initLimit,$endLimit";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allEvents = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allEvents[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allEvents;
}

function getAllEventNames() {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    $query = "SELECT `Name` FROM `event`";

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allEventNames = array();

    while ($rows = mysqli_fetch_row($result)) {
        $allEventNames[] = $rows[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allEventNames;
}

function getEventsWithCategory($category, $visibility) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `event` WHERE `P_Category` = '$category' "
                . "AND `Visibility`='$visibility' ORDER BY `event`.`Date` DESC";
    } else {
        $query = "SELECT * FROM `event` WHERE `P_Category` = "
                . "'$category' ORDER BY `event`.`Date` DESC";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allEvents = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allEvents[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allEvents;
}

function getEventsWithCategoryLimit($category, $visibility, $initLimit, $endLimit) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `event` WHERE `P_Category` = '$category' "
                . "AND `Visibility`='$visibility' ORDER BY `event`.`Date` DESC LIMIT $initLimit,$endLimit";
    } else {
        $query = "SELECT * FROM `event` WHERE `P_Category` = "
                . "'$category' ORDER BY `event`.`Date` DESC LIMIT $initLimit,$endLimit";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allEvents = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allEvents[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allEvents;
}

function getAllCategories() {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `$dbName`.`primary_category`";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allCategories = array();
    while ($rows = mysqli_fetch_array($result)) {
        $allCategories[] = $rows[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allCategories;
}

function getAllPostsWithEvent($event, $visibility) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `post` WHERE `Event` = '$event' "
                . "AND `Visibility`='$visibility' ORDER BY `post`.`Post_ID` "
                . "DESC";
    } else {
        $query = "SELECT * FROM `post` "
                . "WHERE `Event` = '$event' ORDER BY `post`.`Post_ID` DESC";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allPosts = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allPosts[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allPosts;
}

function getResults($search, $visibility) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT * FROM `post` WHERE (`Description` LIKE '%$search%' OR `Event` LIKE '%$search%' OR `P_Category` LIKE '%$search%' OR `S_Category` LIKE '%$search%') AND `Visibility`='$visibility' ORDER BY `post`.`Post_ID` DESC";
    } else {
        $query = "SELECT * FROM `post` WHERE (`Description` LIKE '%$search%' OR `Event` LIKE '%$search%' OR `P_Category` LIKE '%$search%' OR `S_Category` LIKE '%$search%') ORDER BY `post`.`Post_ID` DESC";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $postResults = array();

    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $postResults[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $postResults;
}

function getLocal($event) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `Local` FROM `event` WHERE `Name` = '$event'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $rows = $result->fetch_array(MYSQLI_ASSOC);
    $local = $rows['Local'];
    dbDisconnect();
    return $local;
}

function getAllProfiles() {
    dbConnect(ConfigFile);
    global $dbName;
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `$dbName`.`profile`";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allProfiles = array();
    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $allProfiles[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allProfiles;
}

function removeEventFromDB($eventRemove) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query1 = "DELETE FROM `post` WHERE `Event`='" . $eventRemove . "'";
    $query2 = "DELETE FROM `event` WHERE `event`.`Name` = '" . $eventRemove . "'";
    $result1 = mysqli_query($GLOBALS['ligacao'], $query1);
    $result2 = mysqli_query($GLOBALS['ligacao'], $query2);
    dbDisconnect();
    return $result1 && $result2;
}

function editEventFromDB($eventEdit, $dateEdit, $pCatEdit, $visEdit, $localEdit) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "UPDATE `event` SET `Date`='" . $dateEdit . "',`P_Category`='" . $pCatEdit .
            "',`Visibility`=" . $visEdit . ",`Local`='" . $localEdit . "' WHERE `Name` = '" . $eventEdit . "'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function getEventFromName($eventName) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `event` WHERE `Name`='$eventName'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $event = array();
    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $event[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $event[0];
}

function removeCatFromDB($catRemove) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query1 = "DELETE FROM `post` WHERE `P_Category`='" . $catRemove . "'";
    $query2 = "DELETE FROM `event` WHERE `event`.`P_Category` = '" . $catRemove . "'";
    $query3 = "DELETE FROM `primary_category` WHERE `Name` = '" . $catRemove . "'";
    $result1 = mysqli_query($GLOBALS['ligacao'], $query1);
    $result2 = mysqli_query($GLOBALS['ligacao'], $query2);
    $result3 = mysqli_query($GLOBALS['ligacao'], $query3);
    dbDisconnect();
    return $result1 && $result2 && $result3;
}

function addCatInDB($catAdd) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "INSERT INTO `primary_category`(`Name`) VALUES ('$catAdd')";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function validateSimpFromDB($userSimp) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "UPDATE `profile` SET `Role`='Simpatizante' WHERE `Username` = '" . $userSimp . "'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function getAllUsersSimp() {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `Username` FROM `profile` WHERE `Role` = 'Utilizador' AND `Valid` = 1 AND (`Hierarchy` = 'Caloira' OR `Hierarchy` = 'Veterana')";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allUsersSimp = array();
    while ($rows = mysqli_fetch_array($result)) {
        $allUsersSimp[] = $rows[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allUsersSimp;
}

function getAllUsersName() {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `Username` FROM `profile`"; #meti username em vez de name!!!!
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $allUsersName = array();
    while ($rows = mysqli_fetch_array($result)) {
        $allUsersName[] = $rows[0];
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $allUsersName;
}

function editUserFromDB($nameEdit, $emailEdit, $roleEdit, $nicknameEdit, $hierEdit) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "UPDATE `profile` SET `Email`='$emailEdit',`Role`='$roleEdit',`Nickname`='$nicknameEdit',`Hierarchy`='$hierEdit' WHERE `Username` = '$nameEdit'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    dbDisconnect();
    return $result;
}

function getProfileFromUsername($username) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT * FROM `profile` WHERE `Username`='$username'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $profile = array();
    while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $profile[] = $rows;
    }
    mysqli_free_result($result);
    dbDisconnect();
    return $profile[0];
}

function removeUserFromDB($userRemove) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query1 = "DELETE FROM `post` WHERE `Username`='" . $userRemove . "'";
    $query2 = "DELETE FROM `profile` WHERE `profile`.`Username` = '" . $userRemove . "'";
    $result1 = mysqli_query($GLOBALS['ligacao'], $query1);
    $result2 = mysqli_query($GLOBALS['ligacao'], $query2);
    dbDisconnect();
    return $result1 && $result2;
}

function countEvents($visibility) {
    dbConnect(ConfigFile);
    mysqli_select_db($GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);

    if ($visibility == 0) {
        $query = "SELECT COUNT(*) as total FROM event WHERE `Visibility`='$visibility' ORDER BY `event`.`Date` DESC";
    } else {
        $query = "SELECT COUNT(*) as total FROM event ORDER BY `event`.`Date` DESC";
    }

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    $data = mysqli_fetch_assoc($result);

    return $data['total'];
}
