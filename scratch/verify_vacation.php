<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\WaterBilling;
use App\Models\MaintenanceRequest;
use App\Models\DocumentRequest;
use App\Models\VisitorLog;

// 1. Get a test tenant
$tenant = Tenant::where('status', 'active')->first();
if (!$tenant) {
    echo "No active tenant found to test with.\n";
    exit(1);
}

echo "Testing with Tenant: {$tenant->first_name} {$tenant->last_name} (ID: {$tenant->tenant_id})\n";

// Revert any vacation status first
$tenant->update([
    'is_on_vacation' => false,
    'vacation_note' => null
]);

echo "Initial status: is_on_vacation = " . ($tenant->is_on_vacation ? 'true' : 'false') . "\n";

// 2. Clear preconditions for this tenant temporarily (to test happy path)
// Let's see if they have unpaid bills, etc.
$hasBills = $tenant->hasUnpaidBills();
$hasMaint = $tenant->hasOngoingMaintenance();
$hasDocs = $tenant->hasOngoingDocuments();
$hasVisitors = $tenant->hasActiveVisitors();

echo "Precondition statuses:\n";
echo "- Unpaid bills: " . ($hasBills ? 'YES' : 'NO') . "\n";
echo "- Ongoing maintenance: " . ($hasMaint ? 'YES' : 'NO') . "\n";
echo "- Ongoing documents: " . ($hasDocs ? 'YES' : 'NO') . "\n";
echo "- Active visitors: " . ($hasVisitors ? 'YES' : 'NO') . "\n";

if ($hasBills || $hasMaint || $hasDocs || $hasVisitors) {
    echo "Tenant has some active items. We will try to mock check validations manually.\n";
} else {
    echo "Tenant is clean. Toggling vacation ON should succeed.\n";
}

// Perform a manual check of the precondition array building logic
$errors = [];
if ($tenant->hasUnpaidBills()) {
    $errors[] = "You have unpaid or pending bills.";
}
if ($tenant->hasOngoingMaintenance()) {
    $errors[] = "You have ongoing maintenance requests.";
}
if ($tenant->hasOngoingDocuments()) {
    $errors[] = "You have active document requests.";
}
if ($tenant->hasActiveVisitors()) {
    $errors[] = "You have upcoming or active registered visitors.";
}

echo "Validation errors array: " . json_encode($errors) . "\n";

// Try setting vacation ON directly to verify DB and Model casts
$tenant->update([
    'is_on_vacation' => true,
    'vacation_note' => 'Test Vacation Note'
]);

// Reload from DB
$tenant->refresh();
echo "After direct update: is_on_vacation = " . ($tenant->is_on_vacation ? 'true' : 'false') . " (" . gettype($tenant->is_on_vacation) . "), note = '{$tenant->vacation_note}'\n";

// Revert
$tenant->update([
    'is_on_vacation' => false,
    'vacation_note' => null
]);
echo "Reverted status: is_on_vacation = " . ($tenant->is_on_vacation ? 'true' : 'false') . "\n";

echo "All code tests completed.\n";
