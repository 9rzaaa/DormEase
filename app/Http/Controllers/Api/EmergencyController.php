<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmergencyController extends Controller
{
    private const EMERGENCY_RULES = [
        'Panic Alert' => [
            'urgency' => 'critical',
            'keywords' => [
                'panic alert',
                'panic',
                'emergency button',
                'help now',
                'send help',
                'tulong ngayon',
                'kailangan ng tulong',
            ],
        ],
        'Medical' => [
            'urgency' => 'critical',
            'keywords' => [
                'medical',
                'injury',
                'injured',
                'hurt',
                'bleeding',
                'blood',
                'fainted',
                'unconscious',
                'sick',
                'ambulance',
                'heart attack',
                'chest pain',
                'seizure',
                'stroke',
                'nahilo',
                'himatay',
                'sugat',
                'nasugatan',
                'dugo',
                'may sakit',
                'masakit',
                'ambulansya',
                'atake',
                'kombulsyon',
            ],
        ],
        'Fire/Smoke' => [
            'urgency' => 'critical',
            'keywords' => [
                'fire',
                'smoke',
                'burning',
                'burn',
                'flame',
                'gas leak',
                'smells like gas',
                'sunog',
                'usok',
                'nasusunog',
                'apoy',
                'amoy gas',
                'tagas gas',
            ],
        ],
        'Electrical Hazard' => [
            'urgency' => 'urgent',
            'keywords' => [
                'electric',
                'electrical',
                'spark',
                'sparking',
                'wire',
                'exposed wire',
                'outlet',
                'power',
                'shock',
                'short circuit',
                'breaker',
                'kuryente',
                'kurente',
                'saksakan',
                'grounded',
                'kumukuryente',
                'pumutok',
                'kawad',
            ],
        ],
        'Security' => [
            'urgency' => 'urgent',
            'keywords' => [
                'security',
                'intruder',
                'break in',
                'break-in',
                'stolen',
                'theft',
                'fight',
                'threat',
                'stranger',
                'harass',
                'assault',
                'magnanakaw',
                'nanakaw',
                'nakaw',
                'away',
                'gulo',
                'banta',
                'estranghero',
                'panliligalig',
            ],
        ],
        'Flood/Water Leak' => [
            'urgency' => 'urgent',
            'keywords' => [
                'flood',
                'flooding',
                'water leak',
                'leak',
                'pipe burst',
                'overflow',
                'overflowing',
                'water everywhere',
                'baha',
                'binabaha',
                'tagas',
                'tulo',
                'tumutulo',
                'pumutok na tubo',
                'umaapaw',
                'apaw',
            ],
        ],
        'Other' => [
            'urgency' => 'moderate',
            'keywords' => [],
        ],
    ];

    private const URGENCY_RULES = [
        'critical' => [
            'panic',
            'fire',
            'smoke',
            'burning',
            'gas leak',
            'unconscious',
            'fainted',
            'bleeding',
            'heart attack',
            'chest pain',
            'seizure',
            'sunog',
            'usok',
            'nasusunog',
            'apoy',
            'amoy gas',
            'himatay',
            'dugo',
            'kombulsyon',
        ],
        'urgent' => [
            'spark',
            'sparking',
            'short circuit',
            'exposed wire',
            'shock',
            'intruder',
            'break in',
            'break-in',
            'theft',
            'fight',
            'threat',
            'flood',
            'flooding',
            'pipe burst',
            'overflow',
            'kumukuryente',
            'grounded',
            'magnanakaw',
            'nakawan',
            'away',
            'gulo',
            'baha',
            'umaapaw',
        ],
    ];

    // ---------------------------------------------------------------------------
    // Tagalog morphology: roots that the stemmer should know about.
    // Add more roots here as needed; the stemmer will expand them automatically.
    // ---------------------------------------------------------------------------
    private const TAGALOG_ROOTS = [
        // Medical
        'himatay',
        'hilo',
        'sugat',
        'dugo',
        'sakit',
        'atake',
        'hinga',
        // Fire
        'sunog',
        'usok',
        'apoy',
        // Electrical
        'kuryente',
        'kurente',
        'putok',
        // Security
        'nakaw',
        'away',
        'gulo',
        'banta',
        'ligalig',
        // Flood
        'baha',
        'tagas',
        'tulo',
        'apaw',
        // General distress
        'tulong',
        'takbo',
        'sigaw',
        'takas',
    ];


    private function tagalogStem(string $word): array
    {
        $candidates = [$word];

        $prefixes = [
            'makapag',
            'nakapag',
            'pinaka',
            'pinag',
            'maka',
            'naka',
            'mapa',
            'napa',
            'mag',
            'nag',
            'pag',
            'ma',
            'na',
            'pa',
            'i',
            'ka',
            'sang',
        ];

        $stripped = $word;
        foreach ($prefixes as $prefix) {
            if (str_starts_with($word, $prefix) && strlen($word) > strlen($prefix) + 2) {
                $stripped = substr($word, strlen($prefix));
                $candidates[] = $stripped;
                break;
            }
        }
        foreach ($prefixes as $prefix) {
            if (str_starts_with($stripped, $prefix) && strlen($stripped) > strlen($prefix) + 2) {
                $candidates[] = substr($stripped, strlen($prefix));
                break;
            }
        }
        $suffixes = ['han', 'hin', 'an', 'in', 'ng', 'g'];
        $allSoFar = $candidates;
        foreach ($allSoFar as $c) {
            foreach ($suffixes as $suffix) {
                if (str_ends_with($c, $suffix) && strlen($c) > strlen($suffix) + 2) {
                    $candidates[] = substr($c, 0, -strlen($suffix));
                }
            }
        }

        $allSoFar = $candidates;
        foreach ($allSoFar as $c) {
            if (preg_match('/^([^aeiou])in(.+)$/u', $c, $m)) {
                $candidates[] = $m[1] . $m[2];
            }
            if (preg_match('/^([^aeiou][^aeiou])in(.+)$/u', $c, $m)) {
                $candidates[] = $m[1] . $m[2];
            }
        }

        $allSoFar = $candidates;
        foreach ($allSoFar as $c) {
            if (preg_match('/^([^aeiou])um(.+)$/u', $c, $m)) {
                $candidates[] = $m[1] . $m[2];
            }
            if (str_starts_with($c, 'um') && strlen($c) > 4) {
                $candidates[] = substr($c, 2);
            }
        }

        $allSoFar = $candidates;
        foreach ($allSoFar as $c) {
            if (strlen($c) >= 4 && substr($c, 0, 2) === substr($c, 2, 2)) {
                $candidates[] = substr($c, 2);
            }
            if (strlen($c) >= 6 && substr($c, 0, 3) === substr($c, 3, 3)) {
                $candidates[] = substr($c, 3);
            }
        }

        return array_unique($candidates);
    }

    /**
     * Checks whether a keyword appears in the text, using both:
     *  - direct substring match
     *  - English -ing suffix stemming
     *  - Tagalog morphological stemming (for every word in the text)
     */
    private function matchesKeyword(string $text, string $keyword): bool
    {
        if (str_contains($text, $keyword)) {
            return true;
        }
        $words = explode(' ', $text);
        $expandedWords = array_map(fn($w) => $this->expandIngForms($w), $words);
        $candidates = [''];
        foreach ($expandedWords as $forms) {
            $next = [];
            foreach ($candidates as $prefix) {
                foreach ($forms as $form) {
                    $next[] = ($prefix === '' ? '' : $prefix . ' ') . $form;
                }
            }
            $candidates = array_slice($next, 0, 512);
        }
        foreach ($candidates as $candidate) {
            if (str_contains($candidate, $keyword)) {
                return true;
            }
        }

        // ── Tagalog morphological matching ───────────────────────────────────
        // For each word in the text, generate all possible roots via the Tagalog
        // stemmer and check if any root matches the keyword (or vice-versa).
        foreach ($words as $word) {
            $roots = $this->tagalogStem($word);
            foreach ($roots as $root) {
                if ($root === $keyword) {
                    return true;
                }
                if (str_contains($keyword, $root) && strlen($root) >= 4) {
                    return true;
                }
                if (str_contains($root, $keyword) && strlen($keyword) >= 4) {
                    return true;
                }
            }

            $keywordRoots = $this->tagalogStem($keyword);
            foreach ($keywordRoots as $kRoot) {
                foreach ($roots as $root) {
                    if ($root === $kRoot && strlen($root) >= 4) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id;

        $reports = EmergencyReport::where('tenant_id', $tenantId)
            ->latest('reported_at')
            ->get()
            ->map(fn($report) => $this->formatReport($report));

        return response()->json([
            'reports' => $reports,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|string|max:255',
            'emergency_type' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,resolved,closed',
            'input_type' => 'nullable|in:voice,text',
            'language' => 'nullable|in:en,tl',
        ]);

        $tenant = $request->user();
        $rawDescription = $validated['description'] ?? '';

        if (!empty($rawDescription) && $this->isGibberish($rawDescription)) {
            return response()->json([
                'message' => 'The description contains invalid or gibberish text.',
                'errors' => [
                    'description' => ['Please provide a clear description of the situation. Gibberish text or random characters are not allowed.']
                ]
            ], 422);
        }

        $cleanedDescription = $this->cleanText($rawDescription);
        $requestedType = $validated['emergency_type'] ?? $validated['type'] ?? null;
        $isPanicAlert = $this->isPanicAlert($requestedType, $cleanedDescription);
        $classification = $this->classify($cleanedDescription, $requestedType, $isPanicAlert);
        $location = $validated['location'] ?? $this->detectLocation($cleanedDescription) ?? $tenant?->room_number;

        $report = EmergencyReport::create([
            'tenant_id' => $tenant?->tenant_id,
            'is_panic_alert' => $isPanicAlert,
            'emergency_type' => $classification['emergency_type'],
            'urgency_level' => $classification['urgency_level'],
            'input_type' => $validated['input_type'] ?? 'text',
            'description' => $cleanedDescription ?: $rawDescription,
            'location' => $location,
            'status' => 'active',
            'reported_at' => now(),
        ]);

        NotificationHelper::sendToAll(
            type: 'emergency_new',
            message: "Emergency reported: {$report->emergency_type} at " . ($report->location ?: 'unspecified location') . ".",
            ref_id: $report->report_id,
        );

        return response()->json([
            'message' => 'Emergency report submitted successfully.',
            'report' => $this->formatReport($report),
        ], 201);
    }

    private function formatReport(EmergencyReport $report): array
    {
        return [
            'id' => $report->report_id,
            'tenant_id' => $report->tenant_id,
            'is_panic_alert' => $report->is_panic_alert,
            'emergency_type' => $report->emergency_type,
            'urgency_level' => $report->urgency_level,
            'input_type' => $report->input_type,
            'description' => $report->description,
            'location' => $report->location,
            'status' => $report->status,
            'admin_notes' => $report->admin_notes,
            'reported_at' => $this->formatApiDate($report->reported_at),
            'resolved_at' => $this->formatApiDate($report->resolved_at),
        ];
    }

    private function formatApiDate($date): ?string
    {
        return $date
            ? $date->copy()->timezone('Asia/Manila')->toIso8601String()
            : null;
    }

    private function cleanText(string $text): string
    {
        $text = Str::lower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\-\/]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text ?? '');
    }

    /**
     * Strips common -ing suffixes from a word to produce candidate stems.
     * Returns an array of the original word plus any derived stems.
     *
     */
    private function expandIngForms(string $word): array
    {
        $forms = [$word];

        if (!str_ends_with($word, 'ing') || strlen($word) <= 5) {
            return $forms;
        }

        $base = substr($word, 0, -3);

        if (preg_match('/([b-df-hj-np-tv-z])\1$/', $base, $m)) {
            $forms[] = substr($base, 0, -1);
        }

        $forms[] = $base . 'e';
        $forms[] = $base;

        return array_unique($forms);
    }

    private function classify(string $text, ?string $requestedType, bool $isPanicAlert): array
    {
        if ($isPanicAlert) {
            return [
                'emergency_type' => 'Panic Alert',
                'urgency_level' => 'critical',
            ];
        }

        $normalizedType = $this->normalizeEmergencyType($requestedType);
        $bestType = $normalizedType ?? 'Other';
        $bestScore = ($normalizedType && $normalizedType !== 'Other') ? 1 : 0;

        foreach (self::EMERGENCY_RULES as $type => $rule) {
            $score = 0;

            foreach ($rule['keywords'] as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    $score++;
                }
            }

            if ($score > $bestScore) {
                $bestType = $type;
                $bestScore = $score;
            }
        }

        return [
            'emergency_type' => $bestType,
            'urgency_level' => $this->classifyUrgency($text, $bestType),
        ];
    }

    private function classifyUrgency(string $text, string $type): string
    {
        foreach (self::URGENCY_RULES as $urgency => $keywords) {
            foreach ($keywords as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    return $urgency;
                }
            }
        }

        return self::EMERGENCY_RULES[$type]['urgency'] ?? 'moderate';
    }

    private function normalizeEmergencyType(?string $type): ?string
    {
        if (!$type) {
            return null;
        }

        $normalized = Str::lower(trim($type));

        return match ($normalized) {
            'panic', 'panic alert' => 'Panic Alert',
            'medical', 'medical emergency' => 'Medical',
            'fire', 'smoke', 'fire/smoke', 'fire smoke' => 'Fire/Smoke',
            'electrical', 'electrical hazard', 'electric hazard' => 'Electrical Hazard',
            'security' => 'Security',
            'flood', 'water leak', 'flood/water leak', 'flood water leak' => 'Flood/Water Leak',
            'other', 'others' => 'Other',
            default => null,
        };
    }

    private function isPanicAlert(?string $requestedType, string $text): bool
    {
        return $this->normalizeEmergencyType($requestedType) === 'Panic Alert'
            || $this->matchesKeyword($text, 'panic alert')
            || $this->matchesKeyword($text, 'panic');
    }

    private function detectLocation(string $text): ?string
    {
        if (preg_match('/\b(?:room|rm|kwarto|kuwarto)\s*([a-z0-9\-]+)/i', $text, $matches)) {
            return 'Room ' . Str::upper($matches[1]);
        }

        if (preg_match('/\b(lobby|hallway|kitchen|bathroom|stairs|stairwell|elevator|parking|laundry|banyo|kusina|hagdan|pasilyo)\b/i', $text, $matches)) {
            return Str::title($matches[1]);
        }

        return null;
    }

    private function isGibberish(string $text): bool
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
            if ($this->isGibberishWord($word)) {
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

    private function isGibberishWord(string $word): bool
    {
        $len = strlen($word);
        if ($len === 0) {
            return false;
        }
        
        if ($len === 1) {
            return !in_array($word, ['a', 'i', 'o']);
        }
        
        if ($len === 2) {
            $validShorts2 = ['ac', 'tv', 'ng', 'ok', 'hi', 'go', 'no', 'my', 'by', 'to', 'in', 'on', 'at', 'an', 'as', 'he', 'we', 'me', 'us', 'up', 'so', 'do', 'if', 'of', 'or', 'is', 'it', 'am'];
            if (in_array($word, $validShorts2)) {
                return false;
            }
            return !preg_match('/[aeiouy]/i', $word);
        }
        
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
        
        $double = $word . $word;
        $periodLen = strpos($double, $word, 1);
        if ($periodLen !== false && $periodLen < $len) {
            $period = substr($word, 0, $periodLen);
            if ($this->isGibberishWord($period)) {
                return true;
            }
        }
        
        if (preg_match('/^[asdfghjkl]+$/i', $word)) {
            $homeRowWhitelist = ['salamat', 'salsal', 'gasgas', 'glass', 'flask', 'shall', 'salad', 'flash', 'slash', 'galahs', 'alfalfa', 'shashlik', 'falls', 'flags', 'halls', 'flasks', 'salads', 'glad', 'fall', 'gall', 'hall', 'alas', 'half', 'flag', 'gash', 'lash', 'sash', 'flak', 'dahl', 'hala', 'sasa', 'laga', 'daga', 'lala', 'gaga', 'haha', 'lads', 'fags', 'gags', 'lags', 'hash', 'dash', 'ash', 'ask', 'has', 'had', 'add', 'all', 'gal', 'lag', 'sag', 'gas', 'fad', 'ala', 'aha', 'las', 'sal', 'lad', 'dag'];
            if ($len >= 3 && !in_array($word, $homeRowWhitelist)) {
                return true;
            }
        }
        if (preg_match('/^[qwertyuiop]+$/i', $word)) {
            $topRowWhitelist = ['typewriter', 'proprietor', 'perpetuity', 'repertoire', 'territory', 'priority', 'property', 'poverty', 'pretty', 'purity', 'poetry', 'equity', 'writer', 'output', 'putter', 'potter', 'route', 'power', 'write', 'quiet', 'quite', 'outer', 'worry', 'tower', 'paper', 'prior', 'trite', 'puppy', 'piety', 'upper', 'wiper', 'pique', 'tuyor', 'tuyot', 'prey', 'port', 'pour', 'riot', 'root', 'pipe', 'uwi', 'opo', 'tuyo', 'puto', 'puri', 'turo', 'itoy', 'pity', 'rope', 'type', 'ripe', 'pure', 'true', 'tour', 'your', 'pore', 'poet', 'tore', 'peer', 'weep', 'quit', 'were', 'trip', 'prop', 'pope', 'wire', 'tire', 'wore', 'yeti', 'wipe', 'rite', 'ryot', 'troy', 'typo', 'writ', 'weir', 'reap', 'perp', 'prow', 'tipe', 'out', 'our', 'you', 'try', 'put', 'toy', 'pot', 'top', 'row', 'wet', 'rye', 'toe', 'tie', 'pit', 'pet', 'pie', 'tip', 'per', 'pro', 'pew', 'weo', 'ryo', 'yup'];
            if ($len >= 3 && !in_array($word, $topRowWhitelist)) {
                return true;
            }
        }
        if (preg_match('/^[zxcvbnm]+$/i', $word)) {
            if ($len >= 3 && $word !== 'baba' && $word !== 'mmm') {
                return true;
            }
        }
        
        $dist = $this->getKeyboardDistance($word);
        if ($dist <= 1.3 && $len >= 3) {
            $leftHandWhitelist = ['sewer', 'referee', 'defer', 'dress', 'free', 'feed', 'seed', 'weed', 'steer', 'street', 'reed', 'deer', 'fees', 'sees', 'assert', 'estate', 'arrest', 'fever', 'newer', 'severe', 'secret', 'create', 'decree', 'desert', 'exert', 'drew', 'crew', 'grew', 'screw', 'stew', 'sweet', 'sweat', 'swear', 'see', 'ref', 'red', 'fed', 'few', 'wed', 'dew', 'ere', 'err', 'res', 'sex', 'fee', 'was'];
            if (!in_array($word, $leftHandWhitelist)) {
                return true;
            }
        }
        
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

    private function getKeyboardDistance(string $word): float
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
}

