<?php
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk(['region' => 'us-east-1', 'version' => 'latest']);

$dynamodb = $sdk->createDynamoDb();

$marshaler = new Marshaler();

//Expression attribute values
$eav = "{";
$filterExpression = "";
if ($_POST['title'])
{
    $eav = $eav . '":title":"' . $_POST['title'] . '"';
    $filterExpression = 'title = :title';
}

if ($_POST['artist'])
{

    if ($_POST['title'])
    {
        $eav = $eav . ",";
        $filterExpression = $filterExpression . " and ";
    }

    $eav = $eav . ' ":artist":"' . $_POST['artist'] . '"';
    $filterExpression = $filterExpression . 'artist = :artist';
}

if ($_POST['year'])
{

    if ($_POST['title'] || $_POST['artist'])
    {
        $eav = $eav . ",";
        $filterExpression = $filterExpression . " and ";
    }

    $eav = $eav . ' ":year": "' . $_POST['year'] . '"';
    $filterExpression = $filterExpression . '#yr = :year';
}

$eav = $eav . "}";

if ($eav)
{
    $eav1 = $marshaler->marshalJson($eav);
}

if ($_POST['title'] != null || $_POST['artist'] != null || $_POST['year'] != null)
{
    $params = ['TableName' => 'music', 'ProjectionExpression' => '#yr, title, artist, img_url', 'FilterExpression' => $filterExpression, 'ExpressionAttributeNames' => ['#yr' => 'year'], 'ExpressionAttributeValues' => $eav1];
}
else
{
    $params = ['TableName' => 'music', ];
}
try
{
    $resultFound = 'false';
    while (true)
    {
        $result = $dynamodb->scan($params);
        if ($result['Items'] != null)
        {
            foreach ($result['Items'] as $i)
            {
                $music = $marshaler->unmarshalItem($i);
                $subscribed = 'false';
                if ($subResult['Items'] != null)
                {
                    foreach ($subResult['Items'] as $r)
                    {
                        $Item = $marshaler->unmarshalItem($r);
                        if ($music['title'] == $Item['title'] && $Item['email'] == $_SESSION['email'])
                        {
                            $subscribed = 'true';
                        }
                    }
                }
                if ($subscribed == 'false')
                {
                    $resultFound = 'true';
                    echo "<tr>";
                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $music['title'] . "</td>";
                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $music['artist'] . "</td>";
                    echo "<td style= 'border: 1px solid black; padding: 10px'>" . $music['year'] . "</td>";
                    echo "<td style= 'border: 1px solid black; padding: 10px'><img src ='https://cc2assignment.s3.amazonaws.com/" . basename($music['img_url']) . "' style='height:80px;width:80px;' /></td>";
                    echo "<td style= 'border: 1px solid black; padding: 10px'><form action='subscribe.php?email=";
                    echo $_SESSION['email'];
                    echo "&title=";
                    echo $music['title'];
                    echo "' method='POST'><button class='btn btn-dark' type='submit'>Subscribe</button></form></td>";
                    echo "</tr>";
                }
            }
        }

        if (isset($result['LastEvaluatedKey']))
        {
            $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
        }
        else
        {
            break;
        }
    }
    if ($resultFound == 'false')
    {
        echo "<tr>";
        echo "<td>No result is retrieved. Please query again.</td>";
        echo "</tr>";
    }
}
catch(DynamoDbException $e)
{
    echo "Unable to scan:\n";
    echo $e->getMessage() . "\n";
}

?>
