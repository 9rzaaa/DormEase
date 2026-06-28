New contact inquiry from the DormEase public website

Name: {{ $inquiry['name'] }}
Email: {{ $inquiry['email'] }}
Contact No.: {{ $inquiry['phone'] ?? 'Not provided' }}
Inquiry Type: {{ ucfirst($inquiry['inquiry_type']) }}
Submitted At: {{ now()->format('F j, Y g:i A') }}
IP Address: {{ $ipAddress ?? 'Not available' }}

Message:
{{ $inquiry['message'] }}

Reply directly to this email to respond to {{ $inquiry['name'] }}.
