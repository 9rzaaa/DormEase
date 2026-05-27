<?php

namespace App\Http\Controllers\Api;

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
                'tumatagas',
                'tumutulo',
                'tulo',
                'gripo',
                'lababo',
                'inidoro',
                'kubeta',
                'tubo',
                'barado',
                'bara',
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
                'pundi',
                'kumukutitap',
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
                'mainit kwarto',
                'hindi malamig',
                'hindi lumalamig',
                'mahina aircon',
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
                'sira pinto',
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
                'mabaho',
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
                'mahina signal',
                'walang internet',
                'walang wifi',
                'walang wi fi',
                'mabagal internet',
                'mabagal wifi',
                'putol internet',
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
            'nasusunog',
            'usok',
            'amoy sunog',
            'baha',
            'umaapaw',
            'walang kuryente',
            'may kuryente',
            'kumukuryente',
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
            'tumatagas',
            'tumutulo',
            'barado',
            'sira',
            'hindi gumagana',
            'di gumagana',
            'hindi magamit',
            'di magamit',
        ],
    ];

    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id;

        $requests = MaintenanceRequest::where('tenant_id', $tenantId)
            ->latest('submitted_at')
            ->get()
            ->map(fn($maintenance) => [
                'id' => $maintenance->request_id,
                'room_number' => $maintenance->room_number,
                'input_type' => $maintenance->input_type,
                'issue_type' => $maintenance->issue_type,
                'description' => $maintenance->description,
                'urgency_level' => $maintenance->urgency_level,
                'status' => $maintenance->status,
                'admin_notes' => $maintenance->admin_notes,
                'admin_notes_at' => $this->formatApiDate($maintenance->admin_notes_at),
                'submitted_at' => $this->formatApiDate($maintenance->submitted_at),
                'resolved_at' => $this->formatApiDate($maintenance->resolved_at),
            ]);

        return response()->json([
            'requests' => $requests,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:5000',
            'input_type' => 'nullable|in:voice,text',
            'language' => 'nullable|in:en,tl',
        ]);

        $tenant = $request->user();
        $cleanedDescription = $this->cleanText($validated['description']);
        $classification = $this->classify($cleanedDescription);

        $maintenance = MaintenanceRequest::create([
            'tenant_id' => $tenant?->tenant_id,
            'room_number' => $tenant?->room_number,
            'input_type' => $validated['input_type'] ?? 'text',
            'issue_type' => $classification['issue_type'],
            'description' => $cleanedDescription,
            'urgency_level' => $classification['urgency_level'],
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'message' => 'Maintenance request submitted successfully.',
            'request' => [
                'id' => $maintenance->request_id,
                'room_number' => $maintenance->room_number,
                'input_type' => $maintenance->input_type,
                'issue_type' => $maintenance->issue_type,
                'description' => $maintenance->description,
                'urgency_level' => $maintenance->urgency_level,
                'status' => $maintenance->status,
                'admin_notes_at' => $this->formatApiDate($maintenance->admin_notes_at),
                'submitted_at' => $this->formatApiDate($maintenance->submitted_at),
            ],
        ], 201);
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

    private function classify(string $text): array
    {
        $bestIssue = 'other';
        $bestScore = 0;

        foreach (self::ISSUE_RULES as $issue => $rule) {
            $score = 0;

            foreach ($rule['keywords'] as $keyword) {
                if (str_contains($text, $keyword)) {
                    $score++;
                }
            }

            if ($score > $bestScore) {
                $bestIssue = $issue;
                $bestScore = $score;
            }
        }

        return [
            'issue_type' => $bestIssue,
            'urgency_level' => $this->classifyPriority($text, $bestIssue),
        ];
    }

    private function classifyPriority(string $text, string $issue): string
    {
        foreach (self::PRIORITY_RULES as $priority => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $priority;
                }
            }
        }

        return self::ISSUE_RULES[$issue]['priority'] ?? 'low';
    }
}
