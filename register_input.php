<?php
/**
 * Copyright 2010-2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * This file is licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License. A copy of
 * the License is located at
 *
 * http://aws.amazon.com/apache2.0/
 *
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
*/

require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region'   => 'us-east-1',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'user'; 

$email = $_POST['email']; 

//check if email is already present in database
$tableName = 'user';
$email_error = "";
$key = $marshaler->marshalJson('{
        "email": "' . $email . '"
}');

    $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];
    $result = $dynamodb->getItem($params);
	if($result['Item']!=null) {
		foreach ($result as $r) {	
		$output =  $marshaler->unmarshalItem($r);
		if ($output['email'] == $email){
			$email_error = "The Email ID already exists";
                	header("location: register.php?email_error=$email_error"); 
		}
		}
	}

//email is not already present
    $password = $_POST['password'];
    $username = $_POST['username'];
    $json = json_encode([
        'email' => $email,
        'password' => $password,
        'username' => $username
    ]);

    $params = [
        'TableName' => $tableName,
        'Item' => $marshaler->marshalJson($json)
];

        try {
                $result = $dynamodb->putItem($params);
                header("location: index.php");
            } catch (DynamoDbException $e) {
                echo "Unable to add user:\n";
                echo $e->getMessage() . "\n";
                }


?>
