<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\ArchivedMaintReq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    private const ISSUE_RULES = [
        'plumbing' => [
            'priority' => 'moderate',
            'keywords' => [
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
            ],
        ],
        'electrical' => [
            'priority' => 'urgent',
            'keywords' => [
                'electric',
                'electrical',
                'power',
                'outlet',
                'socket',
                'spark',
                'wire',
                'wiring',
                'breaker',
                'short circuit',
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
            ],
        ],
        'hvac' => [
            'priority' => 'moderate',
            'keywords' => [
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
            ],
        ],
        'appliance' => [
            'priority' => 'low',
            'keywords' => [
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
            ],
        ],
        'carpentry' => [
            'priority' => 'low',
            'keywords' => [
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
            ],
        ],
        'pest' => [
            'priority' => 'urgent',
            'keywords' => [
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
            ],
        ],
        'cleaning' => [
            'priority' => 'low',
            'keywords' => [
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
            ],
        ],
        'internet' => [
            'priority' => 'moderate',
            'keywords' => [
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
            ],
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

    // Priority weight used for tie-breaking when two issue types score equally.
    private const PRIORITY_WEIGHT = [
        'urgent'   => 3,
        'moderate' => 2,
        'low'      => 1,
    ];

    // ---------------------------------------------------------------------------
    // Tagalog morphology: roots the stemmer should recognise.
    // Add more roots here as needed; the stemmer expands them automatically.
    // ---------------------------------------------------------------------------
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

    // =========================================================================
    // Tagalog Morphological Stemmer
    // =========================================================================
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

    /**
     * Checks whether a keyword appears in the text using:
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
        // Stem each word in the text; also stem the keyword itself.
        // Match when any derived root pair is equal (min 4 chars to avoid noise).
        $keywordRoots = $this->tagalogStem($keyword);

        foreach ($words as $word) {
            $wordRoots = $this->tagalogStem($word);

            foreach ($wordRoots as $wRoot) {

                if ($wRoot === $keyword) {
                    return true;
                }
                if (str_contains($keyword, $wRoot) && strlen($wRoot) >= 4) {
                    return true;
                }
                if (str_contains($wRoot, $keyword) && strlen($keyword) >= 4) {
                    return true;
                }
                foreach ($keywordRoots as $kRoot) {
                    if ($wRoot === $kRoot && strlen($kRoot) >= 4) {
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

        // Try to find the active maintenance request first
        $maintenance = MaintenanceRequest::where('tenant_id', $tenantId)
            ->where('request_id', $id)
            ->first();

        if ($maintenance) {
            if ($maintenance->status === 'pending') {
                // Archive as cancelled
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

            // Fallback soft-delete for other active statuses if any
            $maintenance->update(['hidden_from_tenant' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance request hidden.',
            ]);
        }

        // Try to find the archived resolved request
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

        NotificationHelper::sendToAll(
            type: 'maintenance_new',
            message: "New maintenance request from {$tenant?->first_name} {$tenant?->last_name} in room {$tenant?->room_number}.",
            ref_id: $maintenance->request_id,
        );

        return response()->json([
            'message' => 'Maintenance request submitted successfully.',
            'request' => $this->formatRequest($maintenance),
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

    // -------------------------------------------------------------------------
    // Formatting
    // -------------------------------------------------------------------------
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

    // -------------------------------------------------------------------------
    // Text cleaning
    // -------------------------------------------------------------------------

    private function cleanText(string $text): string
    {
        $text = Str::lower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\-]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text ?? '');
    }

    // -------------------------------------------------------------------------
    // Classification
    // -------------------------------------------------------------------------

    private function classify(string $text, ?string $requestedIssue = null): array
    {
        $normalizedIssue = $this->normalizeIssueType($requestedIssue);
        $bestIssue = $normalizedIssue ?? 'other';
        $bestScore = ($normalizedIssue && $normalizedIssue !== 'other') ? 1 : 0;
        $bestPriorityWeight = self::PRIORITY_WEIGHT[self::ISSUE_RULES[$bestIssue]['priority'] ?? 'low'] ?? 0;

        foreach (self::ISSUE_RULES as $issue => $rule) {
            $score = 0;

            foreach ($rule['keywords'] as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    $score++;
                }
            }
            if ($score === 0) {
                continue;
            }
            $priorityWeight = self::PRIORITY_WEIGHT[$rule['priority']] ?? 0;

            if ($score > $bestScore || ($score === $bestScore && $priorityWeight > $bestPriorityWeight)) {
                $bestIssue          = $issue;
                $bestScore          = $score;
                $bestPriorityWeight = $priorityWeight;
            }
        }

        return [
            'issue_type'    => $bestIssue,
            'urgency_level' => $this->classifyPriority($text, $bestIssue),
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

    private function classifyPriority(string $text, string $issue): string
    {
        foreach (self::PRIORITY_RULES as $priority => $keywords) {
            foreach ($keywords as $keyword) {
                if ($this->matchesKeyword($text, $keyword)) {
                    return $priority;
                }
            }
        }

        return self::ISSUE_RULES[$issue]['priority'] ?? 'low';
    }

    private function isGibberish(string $text): bool
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
            'asdf',
            'qwer',
            'zxcv',
            'fghj',
            'hjkl',
            'tyui',
            'uiop',
            'bnmg',
            'asdfg',
            'qwerty',
            'zxcvbn',
            'asdfghjkl',
            'qwertyuiop',
            'zxcvbnm'
        ];

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
            'xyz'
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
}
