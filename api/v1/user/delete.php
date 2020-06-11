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
 
    // include database and object file
    include_once '../config/database.php';
    include_once '../objects/user.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $user = new User($db);
    
    // get user id
    $data = json_decode(file_get_contents("php://input"));
    
    // set user id to be deleted
    $user->id = $data->id;
    
    // delete the user
    if($user->delete()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "User was deleted."));
    }
    
    // if unable to delete the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to delete user."));
}
}
?>