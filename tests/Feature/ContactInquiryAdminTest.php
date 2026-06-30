<?php

namespace Tests\Feature;

use App\Models\ContactInquiry;
use App\Models\Staff;
use Tests\TestCase;

class ContactInquiryAdminTest extends TestCase
{
    public function test_admin_can_view_contact_inquiries(): void
    {
        $this->prepareDatabase();

        $admin = $this->createAdmin();

        ContactInquiry::create([
            'name' => 'Ana Reyes',
            'email' => 'ana@example.com',
            'phone' => '0912-111-2222',
            'inquiry_type' => 'feedback',
            'message' => 'The dorm looks great. I would like to ask about available rooms.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin, 'staff')->get(route('contact-inquiries.index'));

        $response->assertOk();
        $response->assertSee('Contact Inquiries');
        $response->assertSee('Ana Reyes');
        $response->assertSee('ana@example.com');
    }

    public function test_admin_can_update_inquiry_status(): void
    {
        $this->prepareDatabase();

        $admin = $this->createAdmin();

        $inquiry = ContactInquiry::create([
            'name' => 'Bea Cruz',
            'email' => 'bea@example.com',
            'inquiry_type' => 'concern',
            'message' => 'I have a concern about the reservation process.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin, 'staff')
            ->patch(route('contact-inquiries.update-status', $inquiry), [
                'status' => 'resolved',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('contact_inquiries', [
            'contact_inquiry_id' => $inquiry->contact_inquiry_id,
            'status' => 'resolved',
            'handled_by' => $admin->staff_id,
        ]);
    }

    public function test_secretary_can_view_contact_inquiries_module(): void
    {
        $this->prepareDatabase();

        $secretary = $this->createSecretary();

        ContactInquiry::create([
            'name' => 'Cia Ramos',
            'email' => 'cia@example.com',
            'phone' => '0912-333-4444',
            'inquiry_type' => 'reservation',
            'message' => 'I would like to ask if there are rooms available next month.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($secretary, 'staff')->get(route('contact-inquiries.index'));

        $response->assertOk();
        $response->assertSee('href="' . route('contact-inquiries.index') . '"', false);
        $response->assertSee('Contact Inquiries');
        $response->assertSee('Cia Ramos');
        $response->assertSee('cia@example.com');
    }

    public function test_secretary_can_update_inquiry_status(): void
    {
        $this->prepareDatabase();

        $secretary = $this->createSecretary();

        $inquiry = ContactInquiry::create([
            'name' => 'Dani Lim',
            'email' => 'dani@example.com',
            'inquiry_type' => 'general',
            'message' => 'May I know your office hours for inquiries?',
            'status' => 'new',
        ]);

        $response = $this->actingAs($secretary, 'staff')
            ->patch(route('contact-inquiries.update-status', $inquiry), [
                'status' => 'read',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('contact_inquiries', [
            'contact_inquiry_id' => $inquiry->contact_inquiry_id,
            'status' => 'read',
            'handled_by' => $secretary->staff_id,
        ]);
    }

    private function createAdmin(): Staff
    {
        return Staff::create([
            'staff_code' => 'ADM-TEST',
            'first_name' => 'Dorm',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password_hash' => 'unused',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    private function createSecretary(): Staff
    {
        return Staff::create([
            'staff_code' => 'SEC-TEST',
            'first_name' => 'Dorm',
            'last_name' => 'Secretary',
            'email' => 'secretary@example.com',
            'password_hash' => 'unused',
            'role' => 'secretary',
            'is_active' => true,
        ]);
    }

    private function prepareDatabase(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is not installed in this PHP environment.');
        }

        $this->artisan('migrate:fresh')->run();
    }
}
