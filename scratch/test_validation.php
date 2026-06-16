<?php

function isGibberish(string $text): bool
{
    if (empty($text)) {
        return false;
    }
    $cleanText = trim(strtolower($text));
    
    if (strlen($cleanText) < 3) {
        $validShorts = ['ac', 'tv', 'ng', 'ok', 'hi', 'go', 'no', 'my', 'by', 'to', 'in', 'on', 'at', 'an', 'as', 'he', 'we', 'me', 'us', 'up', 'so', 'do', 'if', 'of', 'or', 'is', 'it', 'am'];
        if (!in_array($cleanText, $validShorts)) {
            return true;
        }
    }
    
    if (preg_match('/(.)\1{3,}/u', $cleanText)) {
        return true;
    }
    
    $words = preg_split('/\s+/', preg_replace('/[^a-z\s]/', '', $cleanText), -1, PREG_SPLIT_NO_EMPTY);
    if (empty($words)) {
        return true;
    }
    
    $gibberishWordCount = 0;
    foreach ($words as $word) {
        if (isGibberishWord($word)) {
            $gibberishWordCount++;
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

function isGibberishWord(string $word): bool
{
    $len = strlen($word);
    if ($len === 0) {
        return false;
    }
    
    // 1. Length 1
    if ($len === 1) {
        return !in_array($word, ['a', 'i', 'o']);
    }
    
    // 2. Length 2
    if ($len === 2) {
        $validShorts2 = ['ac', 'tv', 'ng', 'ok', 'hi', 'go', 'no', 'my', 'by', 'to', 'in', 'on', 'at', 'an', 'as', 'he', 'we', 'me', 'us', 'up', 'so', 'do', 'if', 'of', 'or', 'is', 'it', 'am'];
        if (in_array($word, $validShorts2)) {
            return false;
        }
        return !preg_match('/[aeiouy]/i', $word);
    }
    
    // 3. Length 3
    if ($len === 3) {
        $exactKeysmashes3 = [
            'asd', 'qwe', 'zxc', 'fgh', 'hjk', 'iop', 'jkl', 'dfg', 'xcv', 'rty', 'cvb', 'bnm', 'xyz',
            'yui', 'tyu', 'wer', 'ert', 'sdf', 'ghj', 'vbn', 'sds', 'sde', 'fgd', 'gfd', 'hgf', 'fds', 'dsa'
        ];
        if (in_array($word, $exactKeysmashes3)) {
            return true;
        }
        if (!preg_match('/[aeiouy]/i', $word)) {
            return true;
        }
    }
    
    // 3.5 Forbidden keysmash substrings check (for length >= 3)
    $forbiddenSubstrings = [
        'plm', 'okn', 'ijn', 'uhb', 'ygv', 'tfc', 'rdx', 'esz', 'waq', 'qaz', 'wsx', 'rfv', 'tgb', 'yhn', 'ujm',
        'zxc', 'xcv', 'cvb', 'vbn', 'bnm', 'mnb', 'nbv', 'bvc', 'vcx', 'cxz',
        'sdf', 'fgh', 'hjk', 'jkl', 'lkj', 'kjh', 'jhg', 'hgf', 'gfd', 'fds', 'dsa',
        'qwe', 'tyu', 'yui', 'oiu', 'ewq'
    ];
    foreach ($forbiddenSubstrings as $sub) {
        if (str_contains($word, $sub)) {
            return true;
        }
    }
    
    // 4. Repetition / Periodic Check
    $double = $word . $word;
    $periodLen = strpos($double, $word, 1);
    if ($periodLen !== false && $periodLen < $len) {
        $period = substr($word, 0, $periodLen);
        if (isGibberishWord($period)) {
            return true;
        }
    }
    
    // 5. Row-based checks
    // Home row only
    if (preg_match('/^[asdfghjkl]+$/i', $word)) {
        $homeRowWhitelist = ['salamat', 'salsal', 'gasgas', 'glass', 'flask', 'shall', 'salad', 'flash', 'slash', 'galahs', 'alfalfa', 'shashlik', 'falls', 'flags', 'halls', 'flasks', 'salads', 'glad', 'fall', 'gall', 'hall', 'alas', 'half', 'flag', 'gash', 'lash', 'sash', 'flak', 'dahl', 'hala', 'sasa', 'laga', 'daga', 'lala', 'gaga', 'haha', 'lads', 'fags', 'gags', 'lags', 'hash', 'dash', 'ash', 'ask', 'has', 'had', 'add', 'all', 'gal', 'lag', 'sag', 'gas', 'fad', 'ala', 'aha', 'las', 'sal', 'lad', 'dag'];
        if ($len >= 3 && !in_array($word, $homeRowWhitelist)) {
            return true;
        }
    }
    // Top row only
    if (preg_match('/^[qwertyuiop]+$/i', $word)) {
        $topRowWhitelist = ['typewriter', 'proprietor', 'perpetuity', 'repertoire', 'territory', 'priority', 'property', 'poverty', 'pretty', 'purity', 'poetry', 'equity', 'writer', 'output', 'putter', 'potter', 'route', 'power', 'write', 'quiet', 'quite', 'outer', 'worry', 'tower', 'paper', 'prior', 'trite', 'puppy', 'piety', 'upper', 'wiper', 'pique', 'tuyor', 'tuyot', 'prey', 'port', 'pour', 'riot', 'root', 'pipe', 'uwi', 'opo', 'tuyo', 'puto', 'puri', 'turo', 'itoy', 'pity', 'rope', 'type', 'ripe', 'pure', 'true', 'tour', 'your', 'pore', 'poet', 'tore', 'peer', 'weep', 'quit', 'were', 'trip', 'prop', 'pope', 'wire', 'tire', 'wore', 'yeti', 'wipe', 'rite', 'ryot', 'troy', 'typo', 'writ', 'weir', 'reap', 'perp', 'prow', 'tipe', 'out', 'our', 'you', 'try', 'put', 'toy', 'pot', 'top', 'row', 'wet', 'rye', 'toe', 'tie', 'pit', 'pet', 'pie', 'tip', 'per', 'pro', 'pew', 'weo', 'ryo', 'yup'];
        if ($len >= 3 && !in_array($word, $topRowWhitelist)) {
            return true;
        }
    }
    // Bottom row only
    if (preg_match('/^[zxcvbnm]+$/i', $word)) {
        if ($len >= 3 && $word !== 'baba' && $word !== 'mmm') {
            return true;
        }
    }
    
    // 6. Keyboard distance check
    $dist = getKeyboardDistance($word);
    if ($dist <= 1.3 && $len >= 3) {
        $leftHandWhitelist = ['sewer', 'referee', 'defer', 'dress', 'free', 'feed', 'seed', 'weed', 'steer', 'street', 'reed', 'deer', 'fees', 'sees', 'assert', 'estate', 'arrest', 'fever', 'newer', 'severe', 'secret', 'create', 'decree', 'desert', 'exert', 'drew', 'crew', 'grew', 'screw', 'stew', 'sweet', 'sweat', 'swear', 'see', 'ref', 'red', 'fed', 'few', 'wed', 'dew', 'ere', 'err', 'res', 'sex', 'fee', 'was'];
        if (!in_array($word, $leftHandWhitelist)) {
            return true;
        }
    }
    
    // 7. Consonant clusters
    if (preg_match('/[^aeiouy]{5,}/i', $word)) {
        $allowedConsWords = ['strength', 'length', 'catchphrase', 'watchstrap', 'nightshift', 'poststructural', 'warmth', 'months'];
        $isAllowed = false;
        foreach ($allowedConsWords as $w) {
            if (str_contains($word, $w)) {
                $isAllowed = true;
                break;
            }
        }
        if (!$isAllowed) {
            return true;
        }
    }
    
    // 8. Vowel ratio
    if ($len >= 7) {
        preg_match_all('/[aeiouy]/i', $word, $matches);
        $vowelsCount = count($matches[0] ?? []);
        if ($vowelsCount <= 1) {
            $allowedOneVowel = ['strengths', 'lengths', 'springs', 'strings', 'shrimps', 'shrinks', 'sprints', 'flights', 'knights'];
            if (!in_array($word, $allowedOneVowel)) {
                return true;
            }
        }
    }
    
    return false;
}

function getKeyboardDistance(string $word): float
{
    $word = strtolower($word);
    $layout = [
        'q' => [0, 0], 'w' => [1, 0], 'e' => [2, 0], 'r' => [3, 0], 't' => [4, 0], 'y' => [5, 0], 'u' => [6, 0], 'i' => [7, 0], 'o' => [8, 0], 'p' => [9, 0],
        'a' => [0.2, 1], 's' => [1.2, 1], 'd' => [2.2, 1], 'f' => [3.2, 1], 'g' => [4.2, 1], 'h' => [5.2, 1], 'j' => [6.2, 1], 'k' => [7.2, 1], 'l' => [8.2, 1],
        'z' => [0.5, 2], 'x' => [1.5, 2], 'c' => [2.5, 2], 'v' => [3.5, 2], 'b' => [4.5, 2], 'n' => [5.5, 2], 'm' => [6.5, 2]
    ];

    $len = strlen($word);
    if ($len <= 1) {
        return 0.0;
    }

    $totalDist = 0.0;
    $count = 0;
    for ($i = 0; $i < $len - 1; $i++) {
        $c1 = $word[$i];
        $c2 = $word[$i + 1];
        if (isset($layout[$c1]) && isset($layout[$c2])) {
            $dx = $layout[$c1][0] - $layout[$c2][0];
            $dy = $layout[$c1][1] - $layout[$c2][1];
            $totalDist += sqrt($dx * $dx + $dy * $dy);
            $count++;
        }
    }

    return $count > 0 ? ($totalDist / $count) : 0.0;
}

$testCases = [
    'asdfghjk',
    'sdfsdf',
    'aaaa',
    'asd',
    'qwe',
    'xyz',
    'ng',
    'Hello',
    'World',
    'leaking',
    'pipe',
    'bldg',
    'brgy',
    'asdf',
    'qwerasdf',
    'zxcvbnm',
    'test',
    'asdasd',
    'laksjdhf',
    'qweasd',
    'asdewq',
    'qawesadazxcv',
    'gasgas',
    'salsal',
    'singsing',
    'masdan',
    'asdjf',
    'asdasdasd',
    'poiu',
    'mnbv',
    'plmokn',
    'sewer',
    'referee',
    'free',
    'wet',
    'water',
    'constantly',
    'salamat',
    'laga',
    'akd',
    'jfhk',
    'poiq',
    'laks',
    'jdhf'
];

foreach ($testCases as $tc) {
    echo "\"$tc\" -> isGibberish: " . (isGibberish($tc) ? "true" : "false") . "\n";
}

