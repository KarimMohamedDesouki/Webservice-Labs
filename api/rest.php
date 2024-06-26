<?php
//
require_once 'vendor/autoload.php';

$urlParts = explode('/', $_SERVER['REQUEST_URI']);

$resource = $urlParts[3];
$resourceId = (isset($urlParts[4]) && is_numeric($urlParts[4])) ? (int) $urlParts[4] : 0;


// echo "<pre>";
// print_r($urlParts);
// echo "</pre>";

/**
 * 1- Define METHOD
 * 2- Define RESOURCE
 * 3- Define Resource_ID
 */
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data = handleGet($resource, $resourceId);
        break;
    case 'POST':
        $data = handlePost($resource, $resourceId);
        break;
        // case 'PUT':
        //     echo "Will update";
        //     break;
        // case 'DELETE':
        //     echo "Will delete";
        //     break;

    default:
        http_response_code(405);
        return ["Error" => "Method not allowed"];
        break;
}

// $statusCode = is_null($data) ? 404 : 200;
// http_response_code($statusCode);
header('Content-Type: application/json');

if (!empty($data)) {
    echo json_encode($data);
}

/**
 * 
 * Get with no user id (user id = 0) => List all users
 * Get with user id => get only single user by id
 * 
 * @param type $resource
 * @param type $resourceId
 * @return type
 */
function handleGet($resource, $resourceId)
{

    $conn = new MainProgram;
    $item = array();

    if ($resource == "item") {
        if ($conn->connect()) {
            $item = $conn->get_record_by_id($resourceId, "id");
        } else {
            http_response_code(500);
            return ["Error" => "Internal server error"];
        }


        $res = ["msg" => "Success", "Items" => $item];

        if (empty($item)) {
            return ["error" => "Item not found"];
        }

        return $res;
    } else {
        http_response_code(404);
        return ["Error" => "Resource does not exist"];
    }
}


function handlePost($resource, $resourceId)
{

    $conn = new MainProgram;

    if ($resource == "item") {
        if ($conn->connect()) {

            $item = new Items();
            try {
                $item->id = $_POST["id"];
                $item->product_name = $_POST["product_name"];
                $item->PRODUCT_code = $_POST["PRODUCT_code"];
                $item->list_price = $_POST["list_price"];
                $item->save();
                return ["msg" => "Success: product added "];
            } catch (\Exception $ex) {
                return ["msg" => "fail: " . $ex->getMessage()];
            }
        } else {
            http_response_code(500);
            return ["Error" => "Internal server error"];
        }
    } else {
        http_response_code(404);
        return ["Error" => "Resource does not exist"];
    }
}
