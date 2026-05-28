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
                'harassment',
                'assault',
                'magnanakaw',
                'nanakaw',
                'nakawan',
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
                'tumutulo',
                'pumutok na tubo',
                'umaapaw',
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

    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id;

        $reports = EmergencyReport::where('tenant_id', $tenantId)
            ->latest('reported_at')
            ->get()
            ->map(fn ($report) => $this->formatReport($report));

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
            'status' => 'nullable|string|max:50',
            'input_type' => 'nullable|in:voice,text',
            'language' => 'nullable|in:en,tl',
        ]);

        $tenant = $request->user();
        $rawDescription = $validated['description'] ?? '';
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
            'status' => $validated['status'] ?? 'pending',
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
        $bestScore = $normalizedType ? 1 : 0;

        foreach (self::EMERGENCY_RULES as $type => $rule) {
            $score = 0;

            foreach ($rule['keywords'] as $keyword) {
                if (str_contains($text, $keyword)) {
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
                if (str_contains($text, $keyword)) {
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
            || str_contains($text, 'panic alert')
            || str_contains($text, 'panic');
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
}
