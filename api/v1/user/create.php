<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate user object
include_once '../objects/user.php';
  
$database = new Database();
$db = $database->getConnection();
  
$user = new User($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->token) &&
    !empty($data->account_type) &&
    !empty($data->status)
){
  
    // set user property values
    $user->email = $data->email;

    $user->readOne();

    if($user->email==null){
        $user->name = $data->name;
        $user->email = $data->email;
        $user->token = password_hash($data->token, PASSWORD_BCRYPT);
        $user->account_type = $data->account_type;
        $user->status =  $data->status;
        $user->is_premium = $data->is_premium;
        $user->is_onboarded = $data->is_onboarded;
        // create the user
        if($user->create()){
    
            // set response code - 201 created
            http_response_code(200);
    
            // tell the user
            echo json_encode(array("message" => "Account created Successfully!"));
            // echo json_encode(array("message"=>"Before we start, please verify your account using the link we have sent in your email!"));
        }
    
        // if unable to create the user, tell the user
        else{
    
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(array("message" => "Unable to create user."));
        }
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Email Already Used."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}
?>