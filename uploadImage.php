<?php
require 'vendor/autoload.php';

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk(['region' => 'us-east-1', 'version' => 'latest']);

$dynamodb = $sdk->createDynamoDb();

$marshaler = new Marshaler();

$params = ['TableName' => 'music', ];

$s3 = new S3Client(['version' => 'latest', 'region' => 'us-east-1']);

$bucket = 'cc2assignment';
try
{
    while (true)
    {
        $result = $dynamodb->scan($params);
        if ($result['Items'] != null)
        {
            foreach ($result['Items'] as $i)
            {
                $music = $marshaler->unmarshalItem($i);
                $img_url = $music['img_url'];
                $file_name = basename($img_url);
                // Prepare the upload parameters.
                $uploader = new MultipartUploader($s3, fopen($img_url, "r") , ['bucket' => $bucket, 'key' => $file_name, 'ACL' => 'public-read']);

                // Perform the upload.
                try
                {
                    $result = $uploader->upload();
                    echo "Upload complete: {$result['ObjectURL']}" . PHP_EOL;
                }
                catch(MultipartUploadException $e)
                {
                    echo $e->getMessage() . PHP_EOL;
                }
            }
        }
    }
}
catch(DynamoDbException $e)
{
    echo "Unable to scan:\n";
    echo $e->getMessage() . "\n";
}
?>
