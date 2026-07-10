<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\ArchivedMaintReq;
use App\Models\CustomMaintenanceKeyword;
use App\Models\UnclassifiedMaintenanceTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    private const ISSUE_RULES = [
        'plumbing' => [
            'priority' => 'moderate',
            'keywords' => [
                'pipe burst' => 2.0,
                'sewage' => 2.0,
                'clogged toilet' => 2.0,
                'busted pipe' => 2.0,
                'water leak' => 2.0,
                'leak',
                'leaking',
                'drip',
                'dripping',
                'water',
                'faucet',
                'sink',
                'toilet',
                'pipe',
                'drain',
                'shower',
                'flush',
                'clog',
                'clogged',
                'overflow',
                'tagas',
                'tulo',
                'gripo',
                'lababo',
                'inidoro',
                'kubeta',
                'tubo',
                'bara',
                'barado',
                'baha',
                'faucet leak',
                'water pressure',
                'clogged shower',
                'clogged sink',
                'drain backup',
                'flush handle',
                'leaking hose',
                'bidet',
                'water heater',
                'no water',
                'sira na gripo',
                'pumutok na tubo',
                'hina ng tubig',
                'baradong inidoro',
                'baradong lababo',
                'baradong banyo',
                'tulo ng tubig',
                'tagas ng bidet',
                'walang tubig',
                'walang tulo',
            ],
            'exclude' => ['electric', 'power', 'light', 'breaker', 'fire', 'smoke'],
        ],
        'electrical' => [
            'priority' => 'urgent',
            'keywords' => [
                'blown fuse' => 2.0,
                'burnt outlet' => 2.0,
                'exposed wire' => 2.0,
                'short circuit' => 2.0,
                'power cut' => 2.0,
                'blackout' => 2.0,
                'electric',
                'electrical',
                'power',
                'outlet',
                'socket',
                'spark',
                'wire',
                'wiring',
                'breaker',
                'brownout',
                'light',
                'lights',
                'flicker',
                'flickering',
                'kuryente',
                'ilaw',
                'saksakan',
                'kawad',
                'kutitap',
                'walang kuryente',
                'walang ilaw',
                'loose outlet',
                'broken bulb',
                'lightbulb',
                'fluorescent',
                'switch',
                'light switch',
                'electrical short',
                'no power',
                'no electricity',
                'pumutok na fuse',
                'sunog na saksakan',
                'lumuwag na saksakan',
                'nakalantad na kawad',
                'putol ang kuryente',
                'sira na bombilya',
                'bombilya',
                'fluorescent na ilaw',
                'swits',
                'saklar',
                'short ng kuryente',
            ],
            'exclude' => ['leak', 'water', 'clog', 'pipe', 'sink', 'toilet', 'faucet'],
        ],
        'hvac' => [
            'priority' => 'moderate',
            'keywords' => [
                'ac leak' => 2.0,
                'ac water leak' => 2.0,
                'ac not cooling' => 2.0,
                'aircon',
                'air conditioning',
                'ac',
                'a c',
                'cooling',
                'hvac',
                'fan',
                'ventilation',
                'hot room',
                'air con',
                'electric fan',
                'mainit',
                'lamig',
                'bentilador',
                'ac filter',
                'ac remote',
                'noisy ac',
                'broken fan',
                'ceiling fan',
                'wall fan',
                'vent',
                'stuffy',
                'overheating',
                'tulo ng aircon',
                'hindi malamig aircon',
                'sira na bentilador',
                'bentilador sa kisame',
                'singaw ng init',
                'kulob',
            ],
            'exclude' => ['stove', 'microwave', 'fridge', 'refrigerator', 'internet', 'wifi'],
        ],
        'appliance' => [
            'priority' => 'low',
            'keywords' => [
                'fridge not cooling' => 2.0,
                'induction cooker' => 2.0,
                'washing machine spin' => 2.0,
                'appliance',
                'fridge',
                'refrigerator',
                'stove',
                'microwave',
                'washer',
                'washing machine',
                'kettle',
                'ref',
                'kalan',
                'takure',
                'plantsa',
                'rice cooker',
                'refrigerator door',
                'microwave timer',
                'stove burner',
                'dryer',
                'rice cooker error',
                'kettle switch',
                'sira na ref',
                'hindi lumalamig ref',
                'kalan na de kuryente',
                'plantsa na de kuryente',
                'takure na de kuryente',
            ],
            'exclude' => ['aircon', 'ac', 'plumbing', 'leak', 'wifi', 'internet'],
        ],
        'carpentry' => [
            'priority' => 'low',
            'keywords' => [
                'broken door' => 2.0,
                'door lock' => 2.0,
                'broken window' => 2.0,
                'window lock' => 2.0,
                'broken bed' => 2.0,
                'door',
                'cabinet',
                'chair',
                'table',
                'bed',
                'lock',
                'window',
                'drawer',
                'furniture',
                'hinge',
                'wood',
                'pinto',
                'aparador',
                'upuan',
                'mesa',
                'kama',
                'kandado',
                'bintana',
                'bisagra',
                'kahoy',
                'sira',
                'door knob',
                'hinge squeak',
                'broken cabinet',
                'cabinet door',
                'broken chair',
                'squeaky bed',
                'broken table',
                'loose screw',
                'nail',
                'sira na pinto',
                'trangka',
                'susi',
                'susi ng pinto',
                'sira na bintana',
                'sira na aparador',
                'sira na upuan',
                'sira na mesa',
                'sira na kama',
                'maluwag na turnilyo',
                'pako',
            ],
            'exclude' => ['electric', 'leak', 'wifi', 'internet', 'pest', 'bugs'],
        ],
        'pest' => [
            'priority' => 'urgent',
            'keywords' => [
                'infestation' => 2.0,
                'bed bugs' => 2.0,
                'anay sa dingding' => 2.0,
                'maraming ipis' => 2.0,
                'maraming langgam' => 2.0,
                'pest',
                'cockroach',
                'roach',
                'ant',
                'ants',
                'rat',
                'rats',
                'mouse',
                'mice',
                'termite',
                'insect',
                'bug',
                'mosquito',
                'ipis',
                'langgam',
                'daga',
                'anay',
                'lamok',
                'insekto',
                'surot',
                'bugs',
                'fleas',
                'ticks',
                'spiders',
                'rodents',
                'roaches',
                'termite damage',
                'flying ants',
                'lizards',
                'surot sa kama',
                'kuto sa kama',
                'bubuyog',
                'butiki',
            ],
            'exclude' => ['plumbing', 'water', 'wifi', 'internet', 'aircon'],
        ],
        'cleaning' => [
            'priority' => 'low',
            'keywords' => [
                'trash full' => 2.0,
                'garbage overflow' => 2.0,
                'bad odor' => 2.0,
                'smelly room' => 2.0,
                'amoy bulok' => 2.0,
                'clean',
                'cleaning',
                'dirty',
                'trash',
                'garbage',
                'smell',
                'odor',
                'stain',
                'mold',
                'mould',
                'marumi',
                'basura',
                'baho',
                'amoy',
                'mantsa',
                'amag',
                'linis',
                'kalat',
                'dusty',
                'dust',
                'cobwebs',
                'muff',
                'moldy',
                'dirty bathroom',
                'dirty floor',
                'puno na basura',
                'maamoy',
                'maalikabok',
                'alikabok',
                'sapot',
                'maruming banyo',
                'maruming sahig',
            ],
            'exclude' => ['electric', 'wire', 'outlet', 'wifi', 'internet'],
        ],
        'internet' => [
            'priority' => 'moderate',
            'keywords' => [
                'no connection' => 2.0,
                'slow wifi' => 2.0,
                'weak signal' => 2.0,
                'router blinking' => 2.0,
                'disconnected' => 2.0,
                'internet',
                'wifi',
                'wi fi',
                'wi-fi',
                'cable',
                'router',
                'connection',
                'signal',
                'network',
                'walang internet',
                'walang wifi',
                'walang wi fi',
                'mabagal internet',
                'mabagal wifi',
                'putol',
                'lan cable',
                'ethernet',
                'dns error',
                'slow loading',
                'walang koneksyon',
                'mabagal ang load',
                'nawawalang wifi',
                'disconnected ang router',
                'putol ang cable',
            ],
            'exclude' => ['water', 'leak', 'clog', 'door', 'window', 'bugs'],
        ],
    ];

    private const PRIORITY_RULES = [
        'urgent' => [
            'spark',
            'sparking',
            'short circuit',
            'exposed wire',
            'smoke',
            'burning',
            'fire',
            'flood',
            'flooding',
            'overflow',
            'overflowing',
            'no power',
            'no electricity',
            'gas leak',
            'sunog',
            'usok',
            'amoy sunog',
            'baha',
            'apaw',
            'walang kuryente',
            'kuryente',
            'grounded',
        ],
        'moderate' => [
            'leak',
            'leaking',
            'clog',
            'clogged',
            'broken',
            'not working',
            'cannot use',
            'tagas',
            'tulo',
            'bara',
            'sira',
            'gana',
            'gamit',
        ],
    ];

    private const PRIORITY_WEIGHT = [
        'urgent'   => 3,
        'moderate' => 2,
        'low'      => 1,
    ];

    public static function getHardcodedRules(): array
    {
        return [
            'issue_rules' => self::ISSUE_RULES,
            'priority_rules' => self::PRIORITY_RULES,
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
        // Plumbing
        'tagas',
        'tulo',
        'baha',
        'apaw',
        'bara',
        'gripo',
        'tubo',
        'lababo',
        // Electrical
        'kuryente',
        'ilaw',
        'kutitap',
        'saksak',
        'kawad',
        'putok',
        // HVAC
        'mainit',
        'lamig',
        'init',
        // Carpentry
        'pinto',
        'kandado',
        'sira',
        'kahoy',
        'bisagra',
        // Cleaning
        'linis',
        'kalat',
        'amag',
        'mantsa',
        'baho',
        'amoy',
        'basura',
        // Internet
        'putol',
        'signal',
        // General
        'gana',
        'gamit',
        'ayos',
        'gusto',
        'tulong',
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

    /**
     * Strips common English -ing suffixes from a word to produce candidate stems.
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

    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id;

        $activeRequests = MaintenanceRequest::where('tenant_id', $tenantId)
            ->where('hidden_from_tenant', false)
            ->latest('submitted_at')
            ->get()
            ->map(fn($maintenance) => $this->formatRequest($maintenance));

        $archivedRequests = ArchivedMaintReq::where('tenant_id', $tenantId)
            ->where('archive_type', 'resolved')
            ->where('hidden_from_tenant', false)
            ->latest('submitted_at')
            ->get()
            ->map(fn($archived) => $this->formatArchivedRequest($archived));

        $allRequests = $activeRequests->concat($archivedRequests)
            ->sortByDesc('submitted_at')
            ->values();

        return response()->json([
            'requests' => $allRequests,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $tenantId = $request->user()?->tenant_id;

        $maintenance = MaintenanceRequest::where('tenant_id', $tenantId)
            ->where('request_id', $id)
            ->first();

        if ($maintenance) {
            if ($maintenance->status === 'pending') {
                $this->archiveRequest($maintenance, 'cancelled');
                $maintenance->delete();

                $tenant     = $request->user();
                $tenantName = trim($tenant?->first_name . ' ' . $tenant?->last_name);
                $reqLabel   = '#REQ-' . str_pad($id, 3, '0', STR_PAD_LEFT);

                NotificationHelper::sendToAll(
                    type: 'maintenance_deleted',
                    message: "{$tenantName} cancelled pending maintenance request {$reqLabel}.",
                    ref_id: $id,
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Pending request cancelled successfully.',
                ]);
            }

            if ($maintenance->status === 'in-progress') {
                return response()->json([
                    'success' => false,
                    'message' => 'In-progress requests cannot be cancelled by the tenant.',
                ], 403);
            }

            $maintenance->update(['hidden_from_tenant' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance request hidden.',
            ]);
        }

        $archived = ArchivedMaintReq::where('tenant_id', $tenantId)
            ->where('original_id', $id)
            ->where('archive_type', 'resolved')
            ->first();

        if ($archived) {
            $archived->update(['hidden_from_tenant' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance request history cleared.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Maintenance request not found.',
        ], 404);
    }

    private function archiveRequest(MaintenanceRequest $r, string $type): void
    {
        ArchivedMaintReq::create([
            'original_id'        => $r->request_id,
            'archive_type'       => $type,
            'tenant_id'          => $r->tenant_id,
            'tenant_name'        => trim(optional($r->tenant)->first_name . ' ' . optional($r->tenant)->last_name),
            'room_number'        => $r->room_number,
            'issue_type'         => $r->issue_type,
            'description'        => $r->description,
            'urgency_level'      => $r->urgency_level,
            'status'             => $r->status,
            'admin_notes'        => $r->admin_notes,
            'assigned_to'        => $r->assigned_to,
            'photo_path'         => $r->photo_path,
            'submitted_at'       => $r->submitted_at,
            'resolved_at'        => $r->resolved_at,
            'hidden_from_tenant' => $r->hidden_from_tenant,
            'archived_at'        => now(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:5000',
            'issue_type'  => 'nullable|string|max:255',
            'input_type'  => 'nullable|in:voice,text',
            'language'    => 'nullable|in:en,tl',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $tenant             = $request->user();

        if ($this->isGibberish($validated['description'])) {
            return response()->json([
                'message' => 'The description contains invalid or gibberish text.',
                'errors' => [
                    'description' => ['Please provide a clear description of the problem. Gibberish text or random characters are not allowed.']
                ]
            ], 422);
        }

        $cleanedDescription = $this->cleanText($validated['description']);
        $classification     = $this->classify($cleanedDescription, $validated['issue_type'] ?? null);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('maintenance_photos', 'public');
        }

        $maintenance = MaintenanceRequest::create([
            'tenant_id'     => $tenant?->tenant_id,
            'room_number'   => $tenant?->room_number,
            'input_type'    => $validated['input_type'] ?? 'text',
            'issue_type'    => $classification['issue_type'],
            'description'   => $cleanedDescription,
            'urgency_level' => $classification['urgency_level'],
            'status'        => 'pending',
            'photo_path'    => $photoPath,
            'submitted_at'  => now(),
        ]);

        if ($maintenance->issue_type === 'other' && !empty($cleanedDescription)) {
            UnclassifiedMaintenanceTerm::create([
                'request_id' => $maintenance->request_id,
                'description_snapshot' => $cleanedDescription,
                'status' => 'pending',
            ]);
        }

        NotificationHelper::sendToAll(
            type: 'maintenance_new',
            message: "New maintenance request from {$tenant?->first_name} {$tenant?->last_name} in room {$tenant?->room_number}.",
            ref_id: $maintenance->request_id,
        );

        $escalated = false;
        $escalationMsg = null;
        try {
            $emergencyController = new \App\Http\Controllers\Api\EmergencyController();
            $emergClassification = $emergencyController->classifyText($cleanedDescription, null);
            
            if ($emergClassification['emergency_type'] !== 'Other' && in_array($emergClassification['urgency_level'], ['critical', 'urgent'])) {
                $location = $tenant?->room_number ?? 'Unknown';
                
                $emergencyReport = \App\Models\EmergencyReport::create([
                    'tenant_id' => $tenant?->tenant_id,
                    'is_panic_alert' => false,
                    'emergency_type' => $emergClassification['emergency_type'],
                    'urgency_level' => $emergClassification['urgency_level'],
                    'input_type' => $validated['input_type'] ?? 'text',
                    'description' => "[Escalated from Maintenance] " . $cleanedDescription,
                    'location' => $location,
                    'status' => 'active',
                    'reported_at' => now(),
                ]);

                NotificationHelper::sendToAll(
                    type: 'emergency_new',
                    message: "CRITICAL: Maintenance request from Room {$location} escalated to {$emergClassification['emergency_type']} Emergency!",
                    ref_id: $emergencyReport->report_id,
                );

                $escalated = true;
                $escalationMsg = "This issue has been flagged as an Emergency ({$emergClassification['emergency_type']}) and staff has been alerted immediately.";
            }
        } catch (\Exception $e) {
            \Log::error("Maintenance escalation error: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Maintenance request submitted successfully.',
            'request' => $this->formatRequest($maintenance),
            'escalated_to_emergency' => $escalated,
            'escalation_message' => $escalationMsg,
        ], 201);
    }

    public function resubmitPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $maintenance = MaintenanceRequest::where('request_id', $id)
            ->where('tenant_id', $request->user()?->tenant_id)
            ->firstOrFail();

        $photoPath = $request->file('photo')->store('maintenance_photos', 'public');

        $maintenance->update([
            'photo_path'                => $photoPath,
            'resubmission_requested_at' => null,
            'resubmission_reason'       => null,
        ]);

        $tenant   = $request->user();
        $reqLabel = '#REQ-' . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT);

        NotificationHelper::sendToAll(
            type: 'maintenance_resubmission',
            message: "Tenant {$tenant?->first_name} {$tenant?->last_name} resubmitted a photo for {$reqLabel} in room {$tenant?->room_number}.",
            ref_id: $maintenance->request_id,
        );

        return response()->json([
            'message'   => 'Photo resubmitted successfully.',
            'photo_url' => asset('storage/' . $photoPath),
        ]);
    }

    private function formatRequest(MaintenanceRequest $maintenance): array
    {
        return [
            'id'                        => $maintenance->request_id,
            'room_number'               => $maintenance->room_number,
            'input_type'                => $maintenance->input_type,
            'issue_type'                => $maintenance->issue_type,
            'description'               => $maintenance->description,
            'urgency_level'             => $maintenance->urgency_level,
            'status'                    => $maintenance->status,
            'admin_notes'               => $maintenance->admin_notes,
            'admin_notes_at'            => $this->formatApiDate($maintenance->admin_notes_at),
            'photo_url'                 => $maintenance->photo_path
                ? asset('storage/' . $maintenance->photo_path)
                : null,
            'resubmission_requested_at' => $this->formatApiDate($maintenance->resubmission_requested_at),
            'resubmission_reason'       => $maintenance->resubmission_reason,
            'submitted_at'              => $this->formatApiDate($maintenance->submitted_at),
            'resolved_at'               => $this->formatApiDate($maintenance->resolved_at),
        ];
    }

    private function formatArchivedRequest(ArchivedMaintReq $archived): array
    {
        return [
            'id'                        => $archived->original_id,
            'room_number'               => $archived->room_number,
            'input_type'                => 'text',
            'issue_type'                => $archived->issue_type,
            'description'               => $archived->description,
            'urgency_level'             => $archived->urgency_level,
            'status'                    => $archived->status,
            'admin_notes'               => $archived->admin_notes,
            'admin_notes_at'            => $this->formatApiDate($archived->resolved_at ?? $archived->archived_at),
            'photo_url'                 => $archived->photo_path
                ? asset('storage/' . $archived->photo_path)
                : null,
            'resubmission_requested_at' => null,
            'resubmission_reason'       => null,
            'submitted_at'              => $this->formatApiDate($archived->submitted_at),
            'resolved_at'               => $this->formatApiDate($archived->resolved_at),
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
        $text = preg_replace('/[^\p{L}\p{N}\s\-]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text ?? '');
    }

    private function getCustomKeywords()
    {
        return CustomMaintenanceKeyword::all();
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

    private function classify(string $text, ?string $requestedIssue = null): array
    {
        $normalizedIssue = $this->normalizeIssueType($requestedIssue);
        $bestIssue = $normalizedIssue ?? 'other';
        $bestScore = ($normalizedIssue && $normalizedIssue !== 'other') ? 1.0 : 0.0;
        $bestPriorityWeight = self::PRIORITY_WEIGHT[self::ISSUE_RULES[$bestIssue]['priority'] ?? 'low'] ?? 0;
        $decidingCustomKeyword = null;

        foreach (self::ISSUE_RULES as $issue => $rule) {
            // Check exclusions first
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

            if ($score === 0.0) {
                continue;
            }
            $priorityWeight = self::PRIORITY_WEIGHT[$rule['priority']] ?? 0;

            if ($score > $bestScore || (abs($score - $bestScore) < 0.0001 && $priorityWeight > $bestPriorityWeight)) {
                $bestIssue          = $issue;
                $bestScore          = $score;
                $bestPriorityWeight = $priorityWeight;
                $decidingCustomKeyword = null;
            }
        }

        $customKeywords = $this->getCustomKeywords();
        $customScoresByIssue = [];

        foreach ($customKeywords as $custom) {
            $matchedCustom = $this->getMatchingTokenIndices($text, [strtolower($custom->keyword)]);
            if (count($matchedCustom) > 0) {
                $customScoresByIssue[$custom->issue_type] = ($customScoresByIssue[$custom->issue_type] ?? 0.0) + array_sum($matchedCustom);
                if (!isset($customScoresByIssue[$custom->issue_type . '_match'])) {
                    $customScoresByIssue[$custom->issue_type . '_match'] = $custom;
                }
            }
        }

        foreach ($customScoresByIssue as $issue => $score) {
            if (str_ends_with((string) $issue, '_match')) {
                continue;
            }
            $priorityWeight = self::PRIORITY_WEIGHT[self::ISSUE_RULES[$issue]['priority'] ?? 'low'] ?? 0;
            if ($score > $bestScore || (abs($score - $bestScore) < 0.0001 && $priorityWeight > $bestPriorityWeight)) {
                $bestIssue = $issue;
                $bestScore = $score;
                $bestPriorityWeight = $priorityWeight;
                $decidingCustomKeyword = $customScoresByIssue[$issue . '_match'] ?? null;
            }
        }

        return [
            'issue_type'    => $bestIssue,
            'urgency_level' => $this->classifyPriority($text, $bestIssue, $decidingCustomKeyword),
        ];
    }

    private function normalizeIssueType(?string $issue): ?string
    {
        if (!$issue) {
            return null;
        }

        $normalized = Str::lower(trim($issue));
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        return match ($normalized) {
            'plumbing' => 'plumbing',
            'electrical' => 'electrical',
            'hvac', 'aircon', 'air conditioning', 'hvac / air conditioning' => 'hvac',
            'appliance', 'appliance repair' => 'appliance',
            'carpentry', 'furniture', 'carpentry / furniture' => 'carpentry',
            'pest', 'pest control' => 'pest',
            'cleaning' => 'cleaning',
            'internet', 'cable', 'internet / cable' => 'internet',
            'other', 'others' => 'other',
            default => null,
        };
    }

    private function classifyPriority(string $text, string $issue, ?CustomMaintenanceKeyword $decidingCustomKeyword = null): string
    {
        $urgentMatches = 0;
        $moderateMatches = 0;

        if (isset(self::PRIORITY_RULES['urgent'])) {
            foreach (self::PRIORITY_RULES['urgent'] as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    $urgentMatches++;
                }
            }
        }

        if (isset(self::PRIORITY_RULES['moderate'])) {
            foreach (self::PRIORITY_RULES['moderate'] as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    $moderateMatches++;
                }
            }
        }
        if ($urgentMatches >= 1) {
            return 'urgent';
        }
        if ($moderateMatches >= 2) {
            return 'urgent';
        }
        if ($moderateMatches === 1) {
            return 'moderate';
        }
        if ($decidingCustomKeyword && $decidingCustomKeyword->urgency_level) {
            return $decidingCustomKeyword->urgency_level;
        }

        $defaultPriority = self::ISSUE_RULES[$issue]['priority'] ?? 'low';

        if ($defaultPriority === 'low') {
            $issueMatches = 0;
            if (isset(self::ISSUE_RULES[$issue]['keywords'])) {
                foreach (self::ISSUE_RULES[$issue]['keywords'] as $keyword) {
                    if ($this->matchesKeyword($text, $keyword)) {
                        $issueMatches++;
                    }
                }
            }
            if ($issueMatches >= 2) {
                return 'moderate';
            }
        }

        return $defaultPriority;
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
