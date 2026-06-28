<?php

namespace Tests\Feature;

use App\Mail\ContactInquirySubmitted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicContactTest extends TestCase
{
    public function test_public_contact_form_accepts_valid_inquiries(): void
    {
        $this->skipIfSqliteDriverIsUnavailable();
        $this->artisan('migrate:fresh')->run();

        Log::spy();
        Mail::fake();
        config(['contact.email_enabled' => false]);

        $response = $this->post('/contact', [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'phone' => '0912-345-6789',
            'inquiry_type' => 'reservation',
            'message' => 'I would like to ask about room availability next month.',
        ]);

        $response->assertRedirect(route('home') . '#contact');
        $response->assertSessionHas('contact_success');

        Log::shouldHaveReceived('info')->once();
        Mail::assertNotSent(ContactInquirySubmitted::class);

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'phone' => '0912-345-6789',
            'inquiry_type' => 'reservation',
            'status' => 'new',
        ]);
    }

    public function test_public_contact_form_returns_validation_errors(): void
    {
        $response = $this->from('/#contact')->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'inquiry_type' => 'reservation',
            'message' => 'short',
        ]);

        $response->assertRedirect(route('home') . '#contact');
        $response->assertSessionHasErrorsIn('contact', ['name', 'email', 'message']);
    }

    private function skipIfSqliteDriverIsUnavailable(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is not installed in this PHP environment.');
        }
    }
}
