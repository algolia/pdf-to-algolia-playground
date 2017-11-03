<?php

require_once 'vendor/autoload.php';

$tikaAddress = 'http://127.0.0.1:9998';

$tika = new \GuzzleHttp\Client([
    'base_uri' => $tikaAddress,
    'timeout'  => 2.0
]);

// Try to contact the Tika server to ensure it is reachable.
try {
    $response = $tika->get('version');
    $version = $response->getBody();
    echo "successfully contacted: $version\n\n";
} catch (\GuzzleHttp\Exception\TransferException $exception) {
    echo "unable to connect to Apache Tika container at address: $tikaAddress\n";
    echo "error: \n";
    echo $exception->getMessage();
    exit(1);
}

// Extract the content from the PDF file.
$filename = 'pdf-sample.pdf';
$file = fopen('../data/'. $filename, 'r');
try {
    $response = $tika->put('tika', [
        'body' => $file,
        'headers' => [
            'Accept' => 'text/html'
        ]
    ]);
} catch (\GuzzleHttp\Exception\TransferException $exception) {
    echo "error: \n";
    echo $exception->getMessage();
    exit(1);
}
$body = (string) $response->getBody();

// Parse the relevant content.
$crawler = new \Symfony\Component\DomCrawler\Crawler($body);

$title = $crawler->filter('head > title')->text();
$content = $crawler->filter('body')->text();

// Split the content attribute into several records.
require 'utils.php';

$contentChunks = chunkText($content, 600);
$records = [];
foreach ($contentChunks as $index => $chunk) {
    $records[] = [
        'objectID' => $filename . '-' . $index,
        'filename' => $filename,
        'title' => $title,
        'content' => $chunk,
    ];
}

// Display the resulting records that can be sent to Algolia.
echo "records:\n";
var_dump($records);
