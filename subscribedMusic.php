<?php
session_start();
require 'vendor/autoload.php';
date_default_timezone_set('UTC');
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
$sdk = new Aws\Sdk(['region' => 'us-east-1', 'version' => 'latest']);
$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'subscription';

$params = ['TableName' => $tableName, ];

try
{
    $subResult = $dynamodb->scan($params);

    if ($subResult['Items'] != null)
    {
        foreach ($subResult['Items'] as $r)
        {

            if ($r['email'] != null)
            {

                $item = $marshaler->unmarshalItem($r);

                if ($item["email"] == $_SESSION['email'])
                {

                    $title = $item["title"];

                    $tableName2 = 'music';

                    $params2 = ['TableName' => $tableName2];

                    $result2 = $dynamodb->scan($params2);
                    //var_dump($result2);
                    if ($result2['Items'] != null)
                    {

                        foreach ($result2['Items'] as $r2)
                        {
                            echo "<tr>";
                            if ($r2['title'] != null)
                            {

                                $item2 = $marshaler->unmarshalItem($r2);

                                if ($item2['title'] == $title)
                                {
                                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $item2['title'] . "</td>";
                                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $item2['artist'] . "</td>";
                                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $item2['year'] . "</td>";
                                    echo "<td style= 'border: 1px solid black; padding: 10px'><img src ='https://cc2assignment.s3.amazonaws.com/" . basename($item2['img_url']) . "' style='height:80px;width:80px;' /></td>";
                                    echo "<td style= 'border: 1px solid black; padding: 10px'><form action='unsubscribe.php?email=";
                                    echo $_SESSION['email'];
                                    echo "&title=";
                                    echo $item2['title'];
                                    echo "' method='POST'><button class='btn btn-dark' type='submit'>Remove</button></form></td>";
                                }
                            }

                        }
                        echo "</tr>";
                    }

                }

            }

        }
    }

}
catch(DynamoDbException $e)
{
    echo "Unable to get item:\n";
    echo $e->getMessage() . "\n";
}

?>
