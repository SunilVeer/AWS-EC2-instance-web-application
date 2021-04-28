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

$tableName = 'music';

$music = json_decode(file_get_contents('a2.json'), true);
var_dump($music);
foreach ($music as $m) {

    $title = $m['title']; 
    $artist = $m['artist'];
    $year = $m['year'];
    $web_url = $m['web_url'];
    $img_url = $m['img_url'];


    $json = json_encode([
	    'artist' => $artist,
	    'title' => $title,
	    'year' => $year,
	    'web_url' => $web_url,
	    'img_url' => $img_url
    ]);

    $params = [
        'TableName' => $tableName,
        'Item' => $marshaler->marshalJson($json)
    ];

    try {
        $result = $dynamodb->putItem($params);
        echo "Added music: " . $m['year'] . " " . $m['title'] . "\n";
    } catch (DynamoDbException $e) {
        echo "Unable to add music:\n";
        echo $e->getMessage() . "\n";
        break;
    }

}

?>

