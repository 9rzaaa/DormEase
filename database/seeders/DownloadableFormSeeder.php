<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DownloadableForm;

class DownloadableFormSeeder extends Seeder
{
    public function run(): void
    {
        $forms = [
            ['label' => 'After Curfew Arrivals',          'file_path' => 'forms/after_curfew_arrivals.pdf'],
            ['label' => 'Approval to Leave After Curfew', 'file_path' => 'forms/approval_to_leave_after_curfew.pdf'],
            ['label' => 'Letter for Renewal of Tenants',  'file_path' => 'forms/letter_for_renewal_of_tenants.pdf'],
            ['label' => 'Sleepover of Non-Tenant',        'file_path' => 'forms/sleepover_of_non_tenant.pdf'],
            ['label' => 'Turnover Sheet',                 'file_path' => 'forms/turnover_sheet.pdf'],
        ];

        foreach ($forms as $form) {
            DownloadableForm::firstOrCreate(
                ['label' => $form['label']],
                ['file_path' => $form['file_path']]
            );
        }
    }
}