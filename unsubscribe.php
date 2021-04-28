<?php
session_start();
require 'vendor/autoload.php';
date_default_timezone_set('UTC');
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
$sdk = new Aws\Sdk([
    'region' => 'us-east-1',
    'version' => 'latest'
]);
$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'subscription';

//Expression attribute values
$key = $marshaler->marshalJson('{
	"email": "' . $_GET['email'] . '",
	"title": "' . $_GET['title'] . '"
}');

$params = [
            'TableName' => $tableName,	
            'Key' => $key
        ];
		
try {
	    $result = $dynamodb->deleteItem($params);
		header("location: main_page.php");

    } catch (DynamoDbException $e) {
	echo "Unable to get item:\n";
	echo $e->getMessage() . "\n";
}
?>