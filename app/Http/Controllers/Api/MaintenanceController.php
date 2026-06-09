<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
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

        $requests = MaintenanceRequest::where('tenant_id', $tenantId)
            ->latest('submitted_at')
            ->get()
            ->map(fn($maintenance) => $this->formatRequest($maintenance));

        return response()->json([
            'requests' => $requests,
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

    // -------------------------------------------------------------------------
    // Formatting
    // -------------------------------------------------------------------------
    private function formatRequest(MaintenanceRequest $maintenance): array
    {
        return [
            'id'             => $maintenance->request_id,
            'room_number'    => $maintenance->room_number,
            'input_type'     => $maintenance->input_type,
            'issue_type'     => $maintenance->issue_type,
            'description'    => $maintenance->description,
            'urgency_level'  => $maintenance->urgency_level,
            'status'         => $maintenance->status,
            'admin_notes'    => $maintenance->admin_notes,
            'admin_notes_at' => $this->formatApiDate($maintenance->admin_notes_at),
            'photo_url'      => $maintenance->photo_path
                ? asset('storage/' . $maintenance->photo_path)
                : null,
            'submitted_at'   => $this->formatApiDate($maintenance->submitted_at),
            'resolved_at'    => $this->formatApiDate($maintenance->resolved_at),
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
}
