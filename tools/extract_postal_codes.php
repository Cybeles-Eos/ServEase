<?php

$source = file_get_contents('https://unpkg.com/use-postal-ph@1.1.14/dist/index.mjs');

if ($source === false) {
    fwrite(STDERR, "Failed to download postal data.\n");
    exit(1);
}

preg_match_all('/\{location:"([^"]*)",(?:region:"([^"]*)",)?municipality:"([^"]*)",post_code:(\d+)\}/', $source, $matches, PREG_SET_ORDER);

$records = [];

foreach ($matches as $match) {
    $records[] = [
        'location' => $match[1],
        'region' => $match[2] ?? null,
        'municipality' => $match[3],
        'post_code' => (int) $match[4],
    ];
}

if ($records === []) {
    preg_match_all('/\{location:"([^"]*)",region:"([^"]*)",municipality:"([^"]*)",post_code:(\d+)\}/', $source, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $records[] = [
            'location' => $match[1],
            'region' => $match[2],
            'municipality' => $match[3],
            'post_code' => (int) $match[4],
        ];
    }
}

$outputPath = __DIR__ . '/../database/data/ph_postal_codes.json';
file_put_contents($outputPath, json_encode($records, JSON_PRETTY_PRINT));

echo count($records) . " postal records saved to {$outputPath}\n";
