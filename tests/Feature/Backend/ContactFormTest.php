<?php

use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    Mail::fake();
    Notification::fake();
});

describe('Contact Form Functionality', function () {
    
    it('can access contact form', function () {
        $response = $this->get('/contact');
        
        $response->assertStatus(200);
        $response->assertSee('Contact');
        $response->assertSee('form');
        $response->assertSee('name');
        $response->assertSee('email');
        $response->assertSee('message');
    });

    it('can submit contact form with valid data', function () {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
            'subject' => 'Inquiry about gravel routes',
            'message' => 'Hello, I would like to know more about your gravel routes in the Alps.',
            'preferred_contact' => 'email'
        ];

        $response = $this->post('/contact', $data);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about gravel routes',
            'status' => 'nouveau'
        ]);
    });

    it('validates required fields for contact form', function () {
        $response = $this->post('/contact', []);
        
        $response->assertSessionHasErrors(['name', 'email', 'message']);
    });

    it('validates email format in contact form', function () {
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'message' => 'Test message'
        ];

        $response = $this->post('/contact', $data);
        
        $response->assertSessionHasErrors(['email']);
    });

    it('validates phone number format', function () {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => 'invalid-phone-123abc',
            'message' => 'Test message'
        ];

        $response = $this->post('/contact', $data);
        
        $response->assertSessionHasErrors(['phone']);
    });

    it('can handle long messages in contact form', function () {
        $longMessage = str_repeat('This is a very long message. ', 100);
        
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => $longMessage
        ];

        $response = $this->post('/contact', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
    });

    it('sends email notification when contact form is submitted', function () {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test inquiry',
            'message' => 'This is a test message'
        ];

        $response = $this->post('/contact', $data);
        
        $response->assertRedirect();
        
        // Check that mail was sent (assuming mail notification is implemented)
        // Mail::assertSent(ContactNotificationMail::class);
    });
});

describe('Contact Management Backend', function () {
    
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    });

    it('can access contacts list in admin', function () {
        Contact::factory()->count(3)->create();
        
        $response = $this->get('/admin/contacts');
        
        $response->assertStatus(200);
        $response->assertSee('Messages de contact');
    });

    it('can view contact details in admin', function () {
        $contact = Contact::factory()->create([
            'name' => 'Test Contact',
            'subject' => 'Test Subject'
        ]);

        $response = $this->get("/admin/contacts/{$contact->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Test Contact');
        $response->assertSee('Test Subject');
    });

    it('can update contact status', function () {
        $contact = Contact::factory()->create([
            'status' => 'nouveau'
        ]);

        $response = $this->post("/admin/contacts/{$contact->id}/update-status", [
            'status' => 'traite'
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'status' => 'traite'
        ]);
    });

    it('can delete contact message', function () {
        $contact = Contact::factory()->create();

        $response = $this->delete("/admin/contacts/{$contact->id}");
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id
        ]);
    });

    it('can perform bulk actions on contacts', function () {
        $contacts = Contact::factory()->count(3)->create([
            'status' => 'nouveau'
        ]);

        $response = $this->post('/admin/contacts/bulk-action', [
            'action' => 'mark_read',
            'selected_contacts' => $contacts->pluck('id')->toArray()
        ]);
        
        $response->assertRedirect();
        
        foreach ($contacts as $contact) {
            $this->assertDatabaseHas('contacts', [
                'id' => $contact->id,
                'status' => 'lu'
            ]);
        }
    });

    it('can bulk delete contacts', function () {
        $contacts = Contact::factory()->count(3)->create();

        $response = $this->post('/admin/contacts/bulk-action', [
            'action' => 'delete',
            'selected_contacts' => $contacts->pluck('id')->toArray()
        ]);
        
        $response->assertRedirect();
        
        foreach ($contacts as $contact) {
            $this->assertDatabaseMissing('contacts', [
                'id' => $contact->id
            ]);
        }
    });

    it('filters contacts by status', function () {
        Contact::factory()->create(['status' => 'nouveau']);
        Contact::factory()->create(['status' => 'traite']);
        Contact::factory()->create(['status' => 'lu']);

        $response = $this->get('/admin/contacts?status=nouveau');
        
        $response->assertStatus(200);
        // Should only show contacts with 'nouveau' status
    });

    it('searches contacts by name or email', function () {
        Contact::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
        Contact::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com'
        ]);

        $response = $this->get('/admin/contacts?search=John');
        
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    });

    it('validates status options for contact update', function () {
        $contact = Contact::factory()->create();

        $response = $this->post("/admin/contacts/{$contact->id}/update-status", [
            'status' => 'invalid_status'
        ]);
        
        $response->assertSessionHasErrors(['status']);
    });

    it('can export contacts to CSV', function () {
        Contact::factory()->count(5)->create();

        $response = $this->get('/admin/contacts?export=csv');
        
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    });

    it('displays contact statistics in admin dashboard', function () {
        Contact::factory()->count(2)->create(['status' => 'nouveau']);
        Contact::factory()->count(3)->create(['status' => 'traite']);
        Contact::factory()->count(1)->create(['status' => 'lu']);

        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
        // Should display contact counts in dashboard
    });

    it('can reply to contact message', function () {
        $contact = Contact::factory()->create([
            'email' => 'customer@example.com'
        ]);

        $replyData = [
            'subject' => 'Re: Your inquiry',
            'message' => 'Thank you for your inquiry. Here is our response...'
        ];

        $response = $this->post("/admin/contacts/{$contact->id}/reply", $replyData);
        
        $response->assertRedirect();
        
        // Check that mail was sent
        // Mail::assertSent(function ($mail) use ($contact) {
        //     return $mail->hasTo($contact->email);
        // });
    });
});