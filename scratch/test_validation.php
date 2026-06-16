<?php

function isGibberish(string $text): bool
{
    if (empty($text)) {
        return false;
    }
    $cleanText = trim(strtolower($text));
    
    if (strlen($cleanText) < 3) {
        $validShorts = ['ac', 'tv'];
        if (!in_array($cleanText, $validShorts)) {
            return true;
        }
    }
    
    if (preg_match('/(.)\1{3,}/u', $cleanText)) {
        return true;
    }
    
    $commonKeysmashes = [
        'asdf', 'qwer', 'zxcv', 'fghj', 'hjkl', 'tyui', 'uiop', 'bnmg',
        'asdfg', 'qwerty', 'zxcvbn', 'asdfghjkl', 'qwertyuiop', 'zxcvbnm'
    ];
    
    $exactKeysmashes3 = [
        'asd', 'qwe', 'zxc', 'fgh', 'hjk', 'iop', 'jkl', 'dfg', 'xcv', 'rty', 'cvb', 'bnm', 'xyz'
    ];
    
    $words = preg_split('/\s+/', preg_replace('/[^a-z\s]/', '', $cleanText), -1, PREG_SPLIT_NO_EMPTY);
    if (empty($words)) {
        return true;
    }
    
    $gibberishWordCount = 0;
    foreach ($words as $word) {
        foreach ($commonKeysmashes as $k) {
            if (str_contains($word, $k)) {
                $gibberishWordCount++;
                continue 2;
            }
        }
        if (in_array($word, $exactKeysmashes3)) {
            $gibberishWordCount++;
            continue;
        }
        if (strlen($word) === 1) {
            if (!in_array($word, ['a', 'i', 'o'])) {
                $gibberishWordCount++;
                continue;
            }
        }
        if (strlen($word) === 2) {
            if (!preg_match('/[aeiouy]/i', $word) && $word !== 'ng') {
                $gibberishWordCount++;
                continue;
            }
        }
        if (strlen($word) === 3) {
            if (!preg_match('/[aeiouy]/i', $word)) {
                $gibberishWordCount++;
                continue;
            }
        }
        if (strlen($word) <= 3) {
            continue;
        }
        
        if (!in_array($word, ['bldg', 'brgy', 'ctrl', 'tjpg', 'tpng', 'fb', 'ig'])) {
            if (!preg_match('/[aeiouy]/i', $word)) {
                $gibberishWordCount++;
                continue;
            }
        }
        
        if (preg_match('/[^aeiouy]{7,}/i', $word)) {
            $gibberishWordCount++;
            continue;
        }
        
        if (preg_match('/[aeiouy]{5,}/i', $word)) {
            $gibberishWordCount++;
            continue;
        }
        
        if (strlen($word) >= 6 && strlen($word) % 2 === 0) {
            $halfLen = strlen($word) / 2;
            $firstHalf = substr($word, 0, $halfLen);
            $secondHalf = substr($word, $halfLen);
            if ($firstHalf === $secondHalf) {
                preg_match_all('/[aeiouy]/i', $firstHalf, $matches);
                $firstHalfVowels = count($matches[0] ?? []);
                if ($firstHalfVowels <= 1 && $halfLen >= 3) {
                    $gibberishWordCount++;
                    continue;
                }
            }
        }
    }
    
    $totalWords = count($words);
    if ($totalWords === 1 && $gibberishWordCount >= 1) {
        return true;
    }
    if ($totalWords > 1 && ($gibberishWordCount / $totalWords) >= 0.4) {
        return true;
    }
    
    return false;
}

$testCases = [
    'asdfghjk',
    'sdfsdf',
    'aaaa',
    'asd',
    'qwe',
    'xyz',
    'ng',
    'Hello World',
    'My room has a leaking pipe',
    'a',
    '123456',
    '!!!',
    'bldg',
    'brgy',
    'asdf',
    'qwerasdf',
    'zxcvbnm',
    'test',
    'asdasd'
];

foreach ($testCases as $tc) {
    echo "\"$tc\" -> isGibberish: " . (isGibberish($tc) ? "true" : "false") . "\n";
}
