<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\CustomEmergencyKeyword;
use App\Models\EmergencyReport;
use App\Models\ArchivedEmergencyReport;
use App\Models\UnclassifiedEmergencyTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmergencyController extends Controller
{
    private const EMERGENCY_RULES = [
        'Panic Alert' => [
            'urgency' => 'critical',
            'keywords' => [
                'panic alert' => 2.0,
                'emergency button' => 2.0,
                'help now' => 2.0,
                'send help' => 2.0,
                'tulong ngayon' => 2.0,
                'kailangan ng tulong' => 2.0,
                'sos' => 2.0,
                'panic',
                'help me',
                'danger',
                'threatened',
                'attacked',
                'assaulted',
                'safety',
                'please help',
                'screaming',
                'saklolo',
                'tulong',
                'tulungan nyo ko',
                'pakiusap tulong',
                'panganib',
            ],
            'exclude' => [],
        ],
        'Medical' => [
            'urgency' => 'critical',
            'keywords' => [
                'hospital' => 2.0,
                'paramedic' => 2.0,
                'heart attack' => 2.0,
                'stroke' => 2.0,
                'unconscious' => 2.0,
                'chest pain' => 2.0,
                'bleeding' => 2.0,
                'ambulance' => 2.0,
                'ambulansya' => 2.0,
                'kombulsyon' => 2.0,
                'atake' => 2.0,
                'medical',
                'injury',
                'injured',
                'hurt',
                'blood',
                'fainted',
                'sick',
                'seizure',
                'nahilo',
                'himatay',
                'sugat',
                'nasugatan',
                'dugo',
                'may sakit',
                'masakit',
                'doctor',
                'first aid',
                'asthma',
                'difficulty breathing',
                'choking',
                'fall',
                'fallen',
                'head injury',
                'concussion',
                'burn injury',
                'fracture',
                'broken bone',
                'allergy',
                'allergic reaction',
                'poison',
                'poisoning',
                'sprain',
                'fever',
                'dizzy',
                'dizziness',
                'vomiting',
                'nausea',
                'doktor',
                'hika',
                'nahihirapang huminga',
                'nabulunan',
                'nahulog',
                'natumba',
                'bagok',
                'bali',
                'nabali',
                'lason',
                'nalason',
                'pilay',
                'lagnat',
                'hilo',
                'pagkahilo',
                'sumuka',
                'nagsusuka',
                'sakit ng ulo',
                'sakit ng tiyan',
            ],
            'exclude' => ['electric', 'short circuit', 'spark', 'smoke', 'fire', 'sunog', 'outlet'],
        ],
        'Fire/Smoke' => [
            'urgency' => 'critical',
            'keywords' => [
                'fire' => 2.0,
                'smoke' => 2.0,
                'burning' => 2.0,
                'gas leak' => 2.0,
                'explosion' => 2.0,
                'sunog' => 2.0,
                'usok' => 2.0,
                'apoy' => 2.0,
                'pagsabog' => 2.0,
                'burn',
                'flame',
                'smells like gas',
                'nasusunog',
                'amoy gas',
                'tagas gas',
                'explode',
                'sparks',
                'fire alarm',
                'extinguisher',
                'smoke detector',
                'chemical smell',
                'ammonia',
                'propane',
                'butane',
                'kitchen fire',
                'electrical fire',
                'overheat',
                'overheating',
                'sabog',
                'sumabog',
                'alarm sa sunog',
                'pamatay sunog',
                'amoy kemikal',
                'sunog sa kusina',
                'sunog sa wire',
            ],
            'exclude' => ['medical', 'doctor', 'locked out', 'lockout', 'key', 'thief', 'robbery'],
        ],
        'Electrical Hazard' => [
            'urgency' => 'urgent',
            'keywords' => [
                'exposed wire' => 2.0,
                'short circuit' => 2.0,
                'electric shock' => 2.0,
                'high voltage' => 2.0,
                'sparking outlet' => 2.0,
                'power surge' => 2.0,
                'electric',
                'electrical',
                'spark',
                'sparking',
                'wire',
                'outlet',
                'power',
                'shock',
                'breaker',
                'kuryente',
                'kurente',
                'saksakan',
                'grounded',
                'kumukuryente',
                'pumutok',
                'kawad',
                'live wire',
                'bare wire',
                'blackout',
                'smell of burning plastic',
                'melted wire',
                'transformer explosion',
                'fuse',
                'fuse box',
                'overloaded',
                'mataas na boltahe',
                'grounded na wire',
                'kumislap',
                'kislap',
                'brownout',
                'sunog na plastik',
                'tunaw na kawad',
                'plakada',
                'singaw ng kuryente',
            ],
            'exclude' => ['medical', 'doctor', 'bleeding', 'thief', 'robbery'],
        ],
        'Lockout' => [
            'urgency' => 'moderate',
            'keywords' => [
                'lockout' => 2.0,
                'locked out' => 2.0,
                'lost key' => 2.0,
                'broken lock' => 2.0,
                'lock',
                'key',
                'card key',
                'naka-lock',
                'nakalock',
                'nawawalang susi',
                'susi',
                'kandado',
            ],
            'exclude' => ['fire', 'smoke', 'bleeding', 'heart attack', 'electric'],
        ],
        'Security' => [
            'urgency' => 'urgent',
            'keywords' => [
                'intruder' => 2.0,
                'break in' => 2.0,
                'stolen' => 2.0,
                'theft' => 2.0,
                'thief' => 2.0,
                'thieves' => 2.0,
                'robbery' => 2.0,
                'robbed' => 2.0,
                'assault' => 2.0,
                'harassment' => 2.0,
                'stalker' => 2.0,
                'magnanakaw' => 2.0,
                'nakaw' => 2.0,
                'baril' => 2.0,
                'knife' => 2.0,
                'gun' => 2.0,
                'security',
                'break-in',
                'fight',
                'threat',
                'stranger',
                'harass',
                'nanakaw',
                'away',
                'gulo',
                'banta',
                'estranghero',
                'panliligalig',
                'stole',
                'stealing',
                'shoplift',
                'burglary',
                'burglar',
                'trespass',
                'trespassing',
                'stalking',
                'peeping tom',
                'weapon',
                'vandalism',
                'vandalized',
                'physical fight',
                'abuse',
                'abused',
                'panloloob',
                'pagnanakaw',
                'ninakawan',
                'tinakaw',
                'papasok na walang paalam',
                'paninira',
                'sinira',
                'patalim',
                'kutsilyo',
                'awayan',
                'bugbog',
                'binugbog',
                'sinasaktan',
            ],
            'exclude' => ['leak', 'water', 'clog', 'electric', 'aircon'],
        ],
        'Structural' => [
            'urgency' => 'urgent',
            'keywords' => [
                'collapse' => 2.0,
                'collapsed' => 2.0,
                'falling debris' => 2.0,
                'elevator' => 2.0,
                'stuck in elevator' => 2.0,
                'structural',
                'lift',
                'button in elevator',
                'crack',
                'cracks',
                'wall crack',
                'broken ceiling',
                'ceiling crack',
                'pader',
                'giba',
                'sira na pader',
                'basag na semento',
                'guho',
            ],
            'exclude' => ['water leak', 'outlet', 'wifi', 'internet', 'theft'],
        ],
        'Flood/Water Leak' => [
            'urgency' => 'urgent',
            'keywords' => [
                'flood' => 2.0,
                'flooding' => 2.0,
                'pipe burst' => 2.0,
                'sewage backup' => 2.0,
                'baha' => 2.0,
                'tagas ng tubig' => 2.0,
                'water leak',
                'leak',
                'overflow',
                'overflowing',
                'water everywhere',
                'binabaha',
                'tagas',
                'tulo',
                'tumutulo',
                'pumutok na tubo',
                'umaapaw',
                'apaw',
                'clogged drain',
                'busted pipe',
                'water damage',
                'dripping',
                'toilet overflow',
                'sink overflow',
                'broken faucet',
                'faucet leak',
                'standing water',
                'roof leak',
                'ceiling leak',
                'baradong tubo',
                'baradong kanal',
                'tumutulong bubong',
                'apaw na toilet',
                'sira na gripo',
                'singaw ng tubig',
                'baha sa banyo',
                'baha sa kwarto',
            ],
            'exclude' => ['fire', 'smoke', 'electric', 'power', 'thief'],
        ],
        'Natural Disaster' => [
            'urgency' => 'critical',
            'keywords' => [
                'earthquake' => 2.0,
                'typhoon' => 2.0,
                'tsunami' => 2.0,
                'landslide' => 2.0,
                'tornado' => 2.0,
                'volcano' => 2.0,
                'lindol' => 2.0,
                'bagyo' => 2.0,
                'flood',
                'hurricane',
                'storm',
                'eruption',
                'calamity',
                'disaster',
                'baha',
                'pagguho ng lupa',
                'buhawi',
                'bulkan',
                'pagsabog',
            ],
            'exclude' => ['lockout', 'lost key', 'wifi', 'internet'],
        ],
        'Unknown' => [
            'urgency' => 'moderate',
            'keywords' => [],
            'exclude' => [],
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

    public static function getHardcodedRules(): array
    {
        return [
            'emergency_rules' => self::EMERGENCY_RULES,
            'urgency_rules' => self::URGENCY_RULES,
        ];
    }

    private const STOP_WORDS = [
        'the',
        'a',
        'an',
        'is',
        'are',
        'was',
        'were',
        'and',
        'or',
        'but',
        'in',
        'on',
        'at',
        'to',
        'for',
        'of',
        'with',
        'by',
        'ang',
        'mga',
        'ng',
        'sa',
        'at',
        'ay',
        'na',
        'o',
        'ni',
        'kay',
        'nila',
        'nito',
        'nong',
        'nang'
    ];

    private const NEGATIONS = [
        'no',
        'not',
        'none',
        'never',
        'without',
        'cannot',
        'cant',
        'hindi',
        'wala',
        'huwag',
        'di',
        'ayaw'
    ];

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
            if (str_starts_with($c, 'r') && strlen($c) > 2) {
                $candidates[] = 'd' . substr($c, 1);
            }
            if (preg_match('/^([aeiou])\1/u', $c)) {
                $candidates[] = substr($c, 1);
            }
        }

        return array_unique($candidates);
    }

    private function isFuzzyMatch(string $w1, string $w2): bool
    {
        if ($w1 === $w2) {
            return true;
        }
        $len = min(strlen($w1), strlen($w2));
        if ($len <= 4) {
            return false;
        }
        $dist = levenshtein($w1, $w2);
        if ($len <= 7) {
            return $dist <= 1;
        }
        return $dist <= 2;
    }

    private function tokenMatches(string $textToken, string $keywordToken): bool
    {
        if (in_array($textToken, self::STOP_WORDS, true)) {
            return false;
        }

        $textStems = array_merge([$textToken], $this->expandIngForms($textToken));
        $tagalogStems = [];
        foreach ($textStems as $ts) {
            $tagalogStems = array_merge($tagalogStems, $this->tagalogStem($ts));
        }
        $textStems = array_unique(array_merge($textStems, $tagalogStems));

        $keywordStems = array_merge([$keywordToken], $this->expandIngForms($keywordToken));
        $tagalogKStems = [];
        foreach ($keywordStems as $ks) {
            $tagalogKStems = array_merge($tagalogKStems, $this->tagalogStem($ks));
        }
        $keywordStems = array_unique(array_merge($keywordStems, $tagalogKStems));

        foreach ($textStems as $ts) {
            foreach ($keywordStems as $ks) {
                if ($this->isFuzzyMatch($ts, $ks)) {
                    return true;
                }
                if (str_contains($ts, $ks) && strlen($ks) >= 4) {
                    return true;
                }
                if (str_contains($ks, $ts) && strlen($ts) >= 4) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isIndexNegated(array $textTokens, int $index): bool
    {
        for ($j = 1; $j <= 2; $j++) {
            if (isset($textTokens[$index - $j])) {
                if (in_array($textTokens[$index - $j], self::NEGATIONS, true)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function matchesKeyword(string $text, string $keyword): bool
    {
        $text = strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\-\/]/u', ' ', $text);
        $textTokens = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        $keyword = strtolower(trim($keyword));
        $keywordTokens = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($textTokens) || empty($keywordTokens)) {
            return false;
        }

        $kCount = count($keywordTokens);
        $tCount = count($textTokens);

        for ($i = 0; $i < $tCount; $i++) {
            if ($this->tokenMatches($textTokens[$i], $keywordTokens[0])) {
                if ($this->isIndexNegated($textTokens, $i)) {
                    continue;
                }

                if ($kCount === 1) {
                    return true;
                }

                $textIdx = $i + 1;
                $matchedAll = true;

                for ($k = 1; $k < $kCount; $k++) {
                    $foundNext = false;
                    $maxIdx = min($textIdx + 4, $tCount);
                    for ($t = $textIdx; $t < $maxIdx; $t++) {
                        if ($this->tokenMatches($textTokens[$t], $keywordTokens[$k])) {
                            $textIdx = $t + 1;
                            $foundNext = true;
                            break;
                        }
                    }
                    if (!$foundNext) {
                        $matchedAll = false;
                        break;
                    }
                }

                if ($matchedAll) {
                    return true;
                }
            }
        }

        return false;
    }

    public function suggestType(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:5000',
        ]);

        $rawDescription = trim($validated['description'] ?? '');

        if ($rawDescription === '') {
            return response()->json(['emergency_type' => null, 'urgency_level' => null]);
        }

        $cleanedDescription = $this->cleanText($rawDescription);
        $isPanicAlert = $this->isPanicAlert(null, $cleanedDescription);
        $classification = $this->classify($cleanedDescription, null, $isPanicAlert);

        if ($classification['emergency_type'] === 'Unknown') {
            return response()->json(['emergency_type' => null, 'urgency_level' => null]);
        }

        return response()->json([
            'emergency_type' => $classification['emergency_type'],
            'urgency_level' => $classification['urgency_level'],
        ]);
    }

    public function classifyText(string $text, ?string $requestedType = null, bool $isPanicAlert = false): array
    {
        $cleaned = $this->cleanText($text);
        return $this->classify($cleaned, $requestedType, $isPanicAlert);
    }

    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id;

        $activeReports = EmergencyReport::where(function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                      ->orWhereNull('tenant_id');
            })
            ->where('hidden_from_tenant', false)
            ->latest('reported_at')
            ->get()
            ->map(fn($report) => $this->formatReport($report));

        $archivedReports = ArchivedEmergencyReport::where(function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                      ->orWhereNull('tenant_id');
            })
            ->whereIn('archive_type', ['resolved', 'closed'])
            ->where('hidden_from_tenant', false)
            ->latest('reported_at')
            ->get()
            ->map(fn($report) => $this->formatArchivedReport($report));

        $allReports = $activeReports->concat($archivedReports)
            ->sortByDesc('reported_at')
            ->values();

        return response()->json([
            'reports' => $allReports,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $tenantId = $request->user()?->tenant_id;

        $report = EmergencyReport::where('tenant_id', $tenantId)
            ->where('report_id', $id)
            ->first();

        if ($report) {
            return response()->json([
                'success' => false,
                'message' => 'Active emergency reports cannot be removed by the tenant.',
            ], 403);
        }

        $archived = ArchivedEmergencyReport::where('tenant_id', $tenantId)
            ->where('original_id', $id)
            ->whereIn('archive_type', ['resolved', 'closed'])
            ->first();

        if ($archived) {
            $archived->update(['hidden_from_tenant' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Emergency report history cleared.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Emergency report not found.',
        ], 404);
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
        $location = $this->detectLocation($cleanedDescription) ?? $validated['location'] ?? $tenant?->room_number;

        $report = EmergencyReport::create([
            'tenant_id' => $tenant?->tenant_id,
            'is_panic_alert' => $isPanicAlert || ($classification['emergency_type'] === 'Panic Alert'),
            'emergency_type' => $classification['emergency_type'],
            'urgency_level' => $classification['urgency_level'],
            'input_type' => $validated['input_type'] ?? 'text',
            'description' => $cleanedDescription ?: $rawDescription,
            'location' => $location,
            'status' => 'active',
            'reported_at' => now(),
        ]);

        if ($report->emergency_type === 'Unknown' && !empty($cleanedDescription)) {
            UnclassifiedEmergencyTerm::create([
                'report_id' => $report->report_id,
                'description_snapshot' => $cleanedDescription,
                'status' => 'pending',
            ]);
        }

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

    private function formatArchivedReport(ArchivedEmergencyReport $report): array
    {
        return [
            'id' => $report->original_id,
            'tenant_id' => $report->tenant_id,
            'is_panic_alert' => $report->is_panic_alert,
            'emergency_type' => $report->emergency_type,
            'urgency_level' => $report->urgency_level,
            'input_type' => 'text',
            'description' => $report->description,
            'location' => $report->location,
            'status' => $report->archive_type,
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

    private function getMatchingTokenIndices(string $text, array $keywords): array
    {
        $text = strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\-\/]/u', ' ', $text);
        $textTokens = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $tCount = count($textTokens);

        $matchedWeights = [];

        foreach ($keywords as $keySpec => $weightSpec) {
            if (is_int($keySpec)) {
                $keyword = $weightSpec;
                $weight = 1.0;
            } else {
                $keyword = $keySpec;
                $weight = (float)$weightSpec;
            }

            $keyword = strtolower(trim($keyword));
            $keywordTokens = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
            $kCount = count($keywordTokens);

            if (empty($textTokens) || empty($keywordTokens)) {
                continue;
            }

            for ($i = 0; $i < $tCount; $i++) {
                if ($this->tokenMatches($textTokens[$i], $keywordTokens[0])) {
                    if ($this->isIndexNegated($textTokens, $i)) {
                        continue;
                    }

                    if ($kCount === 1) {
                        $matchedWeights[$i] = max($matchedWeights[$i] ?? 0.0, $weight);
                        continue;
                    }

                    $textIdx = $i + 1;
                    $matchedAll = true;
                    $tempIndices = [$i];

                    for ($k = 1; $k < $kCount; $k++) {
                        $foundNext = false;
                        $maxIdx = min($textIdx + 2, $tCount);
                        for ($t = $textIdx; $t < $maxIdx; $t++) {
                            if ($this->tokenMatches($textTokens[$t], $keywordTokens[$k])) {
                                $textIdx = $t + 1;
                                $foundNext = true;
                                $tempIndices[] = $t;
                                break;
                            }
                        }
                        if (!$foundNext) {
                            $matchedAll = false;
                            break;
                        }
                    }

                    if ($matchedAll) {
                        foreach ($tempIndices as $idx) {
                            $matchedWeights[$idx] = max($matchedWeights[$idx] ?? 0.0, $weight);
                        }
                    }
                }
            }
        }

        return $matchedWeights;
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
        $bestType = $normalizedType ?? 'Unknown';
        $bestScore = ($normalizedType && $normalizedType !== 'Unknown') ? 1.0 : 0.0;
        $decidingCustomKeyword = null;

        foreach (self::EMERGENCY_RULES as $type => $rule) {
            $shouldExclude = false;
            if (isset($rule['exclude'])) {
                foreach ($rule['exclude'] as $exWord) {
                    $matchedEx = $this->getMatchingTokenIndices($text, [$exWord]);
                    if (count($matchedEx) > 0) {
                        $shouldExclude = true;
                        break;
                    }
                }
            }

            if ($shouldExclude) {
                continue;
            }

            $matchedTokens = $this->getMatchingTokenIndices($text, $rule['keywords']);
            $score = (float)array_sum($matchedTokens);

            if ($score > $bestScore) {
                $bestType = $type;
                $bestScore = $score;
                $decidingCustomKeyword = null;
            }
        }

        $customKeywords = $this->getCustomKeywords();
        $customScoresByType = [];

        foreach ($customKeywords as $custom) {
            $matchedCustom = $this->getMatchingTokenIndices($text, [strtolower($custom->keyword)]);
            if (count($matchedCustom) > 0) {
                $customScoresByType[$custom->emergency_type] = ($customScoresByType[$custom->emergency_type] ?? 0.0) + array_sum($matchedCustom);
                if (!isset($customScoresByType[$custom->emergency_type . '_match'])) {
                    $customScoresByType[$custom->emergency_type . '_match'] = $custom;
                }
            }
        }

        foreach ($customScoresByType as $type => $score) {
            if (str_ends_with((string) $type, '_match')) {
                continue;
            }
            if ($score > $bestScore) {
                $bestType = $type;
                $bestScore = $score;
                $decidingCustomKeyword = $customScoresByType[$type . '_match'] ?? null;
            }
        }

        return [
            'emergency_type' => $bestType,
            'urgency_level' => $this->classifyUrgency($text, $bestType, $decidingCustomKeyword),
        ];
    }

    private function getCustomKeywords()
    {
        return CustomEmergencyKeyword::all();
    }

    private function classifyUrgency(string $text, string $type, ?CustomEmergencyKeyword $decidingCustomKeyword = null): string
    {
        foreach (self::URGENCY_RULES as $urgency => $keywords) {
            foreach ($keywords as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    return $urgency;
                }
            }
        }

        if ($decidingCustomKeyword && $decidingCustomKeyword->urgency_level) {
            return $decidingCustomKeyword->urgency_level;
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
            'lockout' => 'Lockout',
            'security' => 'Security',
            'structural' => 'Structural',
            'flood', 'water leak', 'flood/water leak', 'flood water leak' => 'Flood/Water Leak',
            'natural disaster', 'disaster', 'calamity' => 'Natural Disaster',
            'other', 'others', 'unknown' => 'Unknown',
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
        if (preg_match('/\b(?:room|rm|kwarto|kuwarto)(?:\b\s*([a-z0-9\-]+)|([0-9][a-z0-9\-]*))/i', $text, $matches)) {
            $roomNum = !empty($matches[1]) ? $matches[1] : ($matches[2] ?? '');
            if ($roomNum !== '' && !preg_match('/^[a-z]{3,}$/i', $roomNum)) {
                return 'Room ' . Str::upper($roomNum);
            }
        }

        $keywords = [
            'lobby',
            'hallway',
            'corridor',
            'pasilyo',
            'kitchen',
            'kusina',
            'bathroom',
            'toilet',
            'restroom',
            'cr',
            'comfort room',
            'comfort rm',
            'banyo',
            'shower',
            'shower room',
            'stairs',
            'stairwell',
            'staircase',
            'hagdan',
            'hagdanan',
            'elevator',
            'lift',
            'parking',
            'parking lot',
            'garage',
            'laundry',
            'laundry room',
            'canteen',
            'cafeteria',
            'gym',
            'study room',
            'study area',
            'library',
            'lounge',
            'roof',
            'rooftop',
            'bubong',
            'balcony',
            'terrace',
            'garden',
            'yard',
            'office',
            'front desk',
            'frontdesk',
            'entrance',
            'gate',
            'pinto',
            'door',
            'exit',
            'labasan',
            'fire escape',
            'basement'
        ];

        usort($keywords, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        $escaped = array_map(function ($k) {
            return preg_quote($k, '/');
        }, $keywords);

        $pattern = '/\b(' . implode('|', $escaped) . ')\b/i';

        if (preg_match($pattern, $text, $matches)) {
            return Str::title($matches[1]);
        }

        return null;
    }

    private function isGibberish(string $text): bool
    {
        if (empty($text)) {
            return false;
        }

        // Normalize censored/masked words (e.g. f**k, s**t, ****) to a valid placeholder
        $normalizedText = preg_replace('/\b[a-z]*\*+[a-z]*\b/i', 'censor', $text);
        $normalizedText = preg_replace('/\*+/i', 'censor', $normalizedText);
        $normalizedText = preg_replace('/\[[^\]]*censor[^\]]*\]/i', 'censor', $normalizedText);

        $cleanText = trim(strtolower($normalizedText));

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
                'asd',
                'qwe',
                'zxc',
                'fgh',
                'hjk',
                'iop',
                'jkl',
                'dfg',
                'xcv',
                'rty',
                'cvb',
                'bnm',
                'xyz',
                'yui',
                'tyu',
                'wer',
                'ert',
                'sdf',
                'ghj',
                'vbn',
                'sds',
                'sde',
                'fgd',
                'gfd',
                'hgf',
                'fds',
                'dsa'
            ];
            if (in_array($word, $exactKeysmashes3)) {
                return true;
            }
            if (!preg_match('/[aeiouy]/i', $word)) {
                return true;
            }
        }

        $forbiddenSubstrings = [
            'plm',
            'okn',
            'ijn',
            'uhb',
            'ygv',
            'tfc',
            'rdx',
            'esz',
            'waq',
            'qaz',
            'wsx',
            'rfv',
            'tgb',
            'yhn',
            'ujm',
            'zxc',
            'xcv',
            'cvb',
            'vbn',
            'bnm',
            'mnb',
            'nbv',
            'bvc',
            'vcx',
            'cxz',
            'sdf',
            'fgh',
            'hjk',
            'jkl',
            'lkj',
            'kjh',
            'jhg',
            'hgf',
            'gfd',
            'fds',
            'dsa',
            'qwe',
            'tyu',
            'yui',
            'oiu',
            'ewq'
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
            'q' => [0, 0],
            'w' => [1, 0],
            'e' => [2, 0],
            'r' => [3, 0],
            't' => [4, 0],
            'y' => [5, 0],
            'u' => [6, 0],
            'i' => [7, 0],
            'o' => [8, 0],
            'p' => [9, 0],
            'a' => [0.2, 1],
            's' => [1.2, 1],
            'd' => [2.2, 1],
            'f' => [3.2, 1],
            'g' => [4.2, 1],
            'h' => [5.2, 1],
            'j' => [6.2, 1],
            'k' => [7.2, 1],
            'l' => [8.2, 1],
            'z' => [0.5, 2],
            'x' => [1.5, 2],
            'c' => [2.5, 2],
            'v' => [3.5, 2],
            'b' => [4.5, 2],
            'n' => [5.5, 2],
            'm' => [6.5, 2]
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
