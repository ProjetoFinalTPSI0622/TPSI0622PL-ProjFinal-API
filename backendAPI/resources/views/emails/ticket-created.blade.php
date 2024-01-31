{{-- Header Section --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="https://your-company-logo-url.png" alt="Your Company Logo" style="max-width: 100%;">
</div>

{{-- Main Content Section --}}
<p style="font-size: 18px; font-weight: bold;">Hello {{ $ticket->createdBy->name }},</p>

<p>A new ticket (#{{ $ticket->id }}) has been created by {{ $ticket->createdBy->email }}.</p>

<p>You can view the details of the ticket by clicking on the link below:</p>

<p><a href="{{ $ticket->ticketLink }}">{{ $ticket->ticketLink }}</a></p>

{{-- Footer Section --}}
<p style="margin-top: 20px;">Thank you for using our service!</p>
