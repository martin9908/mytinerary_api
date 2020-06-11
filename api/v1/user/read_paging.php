<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Basic Auth Users
$api_credentials = array(
    'user1' => 'abc123',
    'user2' => 'abcxyz'
);

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My API"');
    // set response code - 401 Unauthorized
    http_response_code(401);

    // tell the user user does not exist
    echo json_encode(array("message" => "Unauthorized Access"));
    exit;
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    if (!array_key_exists($username, $api_credentials)) {
         // set response code - 404 Not found
         http_response_code(403);
    
         // tell the user user does not exist
         echo json_encode(array("message" => "Forbidden Access"));
         exit;
    }
    if ($password != $api_credentials[$username]) {
        // set response code - 404 Not found
        http_response_code(403);

        // tell the user user does not exist
        echo json_encode(array("message" => "Forbidden Access"));
        exit;
    }
    // include database and object files
    include_once '../config/core.php';
    include_once '../shared/utilities.php';
    include_once '../config/database.php';
    include_once '../objects/user.php';
    
    // utilities
    $utilities = new Utilities();
    
    // instantiate database and user object
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize object
    $user = new User($db);
    
    // query users
    $stmt = $user->readPaging($from_record_num, $records_per_page);
    $num = $stmt->rowCount();
    
    // check if more than 0 record found
    if($num>0){
    
        // users array
        $users_arr=array();
        $users_arr["users"]=array();
        $users_arr["paging"]=array();
    
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
    
            $user_item=array(
                "iduser"=>$iduser,
                "User_Number"=>$User_Number,
                "First_Name"=>$First_Name,
                "Middle_Name"=>$Middle_Name,
                "Last_Name"=>$Last_Name,
                "Address"=>$Address,
                "Contact_Number"=>$Contact_Number,
                "Account_Type"=>$Account_Type,
                "Account_Status"=>$Account_Status,
                // "password"=>$password,
                "Account_Picture"=>$Account_Picture
            );
    
            array_push($users_arr["users"], $user_item);
        }
    
    
        // include paging
        $total_rows=$user->count();
        $page_url="{$home_url}user/read_paging.php?";
        $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
        $users_arr["paging"]=$paging;
    
        // set response code - 200 OK
        http_response_code(200);
    
        // make it json format
        echo json_encode($users_arr);
    }
    
    else{
    
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user users does not exist
        echo json_encode(
            array("message" => "No users found.")
        );
    }
}
?>