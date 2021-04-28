<?php
session_start();
require 'vendor/autoload.php';
date_default_timezone_set('UTC');
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
$sdk = new Aws\Sdk(['region' => 'us-east-1', 'version' => 'latest']);
$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'user';

$user_error = "";
$email = $_POST["email"];


$password = $_POST['password'];


$key = $marshaler->marshalJson('{
   	"email": "' . $email . '"
   }');

$params = ['TableName' => $tableName, 'Key' => $key];

var_dump($params);
try
{
    $result = $dynamodb->getItem($params);
    foreach ($result as $i)
    {
        $item = $marshaler->unmarshalItem($i);
        $username = $item["username"];
        $email = $item["email"];
        if ($password == $item["password"])
        {
            session_start();
            // Store data in session variable
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $username;
            // Redirect user to Main page
            header("location: main_page.php?username=$username&email=$email");
        }

        else
        {
            $user_error = "email id or password invalid";
            header("location: index.php?user_error=$user_error");

        }

    }

}
catch(DynamoDbException $e)
{
    echo "Unable to get item:\n";
    echo $e->getMessage() . "\n";
}

?>
