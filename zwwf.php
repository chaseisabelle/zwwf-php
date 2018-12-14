<?php
set_error_handler(function ($code, $message, $file, $line) {
    die("$code $file:$line ~ $message\n");
}, E_ALL | E_STRICT | E_WARNING | E_NOTICE);

$letters = preg_replace('[^a-z\*]', '', strtolower(trim($argv[1])));

if (strlen($letters) < 2) {
    trigger_error('need at least two letters');
}

$dict = trim($argv[2] ?? '');
$fptr = $dict ? fopen($dict, 'r') : STDIN;

if (!$fptr) {
    trigger_error('failed to open words file');
}

$letters = bucketize($letters);
$words   = [];

while (!feof($fptr)) {
    $word = strtolower(trim(fgets($fptr)));

    if (!$word || strlen($word) < 2 || strlen($word) > array_sum($letters)) {
        continue;
    }

    $buckets = bucketize($word);
    $skip    = false;
    $wilds   = $letters['*'] ?? 0;

    foreach ($buckets as $char => $count1) {
        $count2 = $letters[$char] ?? 0;
        $skip   = $count2 < $count1;

        if ($skip && $wilds) {
            $wilds = $wilds - $count1 - $count2;
            $skip  = $wilds < 0;
        }

        if ($skip) {
            break;
        }
    }

    if (!$skip) {
        $words[$word] = null;
    }
}

$words = array_keys($words);

usort($words, function ($a, $b) {
    return strlen($a) < strlen($b) ? -1 : 1;
});

foreach ($words as $word) {
    print "$word\n";
}

function bucketize($str) {
    $buckets = [];

    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];

        if (!array_key_exists($char, $buckets)) {
            $buckets[$char] = 0;
        }

        $buckets[$char]++;
    }

    return $buckets;
}
