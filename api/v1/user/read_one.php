<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

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

    // get id of user to read
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of record to read
    $user->email = $data->email;
    
    // read the details of user to be edited
    $user->readOne();
    
    if($user->id!=null){
        // create array
        $user_arr = array(
            "iduser"=>$user->id,
            "name"=>$user->name,
            "email"=>$user->email,
            "token"=>$user->token,
            "city"=>$user->city,
            "region"=>$user->region,
            "country"=>$user->country,
            "account_type"=>$user->account_type,
            "status"=>$user->status,
            "is_premium"=>$user->is_premium,
            "is_onboarded"=>$user->is_onboarded
        );
    
        // set response code - 200 OK
        http_response_code(200);
    
        // make it json format
        echo json_encode($user_arr);
    }
    
    else{
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user user does not exist
        echo json_encode(array("message" => "User does not exist."));
    }
}