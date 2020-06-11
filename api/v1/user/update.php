<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
    include_once '../config/database.php';
    include_once '../objects/user.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $user = new User($db);
    
    // get id of user to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of user to be edited
    $user->iduser = $data->iduser;
    
    // set user property values
    $user->User_Number = $data->User_Number;
    $user->First_Name = $data->First_Name;
    $user->Middle_Name = $data->Middle_Name;
    $user->Last_Name = $data->Last_Name;
    $user->Address = $data->Address;
    $user->Contact_Number = $data->Contact_Number;
    $user->Account_Type = $data->Account_Type;
    $user->Account_Status =  $data->Account_Status;
    $user->password = $data->password;
    $user->Account_Picture = $data->Account_Picture;
    
    // update the user
    if($user->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "User was updated."));
    }
    
    // if unable to update the user, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update user."));
    }
}
?>