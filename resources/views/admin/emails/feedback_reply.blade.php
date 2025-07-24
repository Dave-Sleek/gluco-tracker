<p>Dear {{ $fullName }},</p>

<p>Thank you for your feedback. Here's our response:</p>

<blockquote style="padding: 10px; border-left: 4px solid #ccc; background: #f9f9f9;">
    {{ $reply }}
</blockquote>

<p>We appreciate your time and input.</p>
<p>Warm regards,<br>{{ config('mail.from.name') }}</p>
