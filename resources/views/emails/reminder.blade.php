@component('mail::message')
<img src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}" alt="GlucoTracker Logo" width="120">

# 📅 Hello {{ $user->full_name }}

Your reminder: **{{ $reminder->subject }}**

---

## 🩺 Message  
{!! nl2br(e($reminder->body)) !!}

@if($latestReading)
---

## 🔬 Latest Glucose Reading

- **Original Value:** {{ $latestReading->original_value }} {{ $latestReading->original_unit }}  
- **Converted Value:** {{ $latestReading->converted_value }} {{ $latestReading->converted_unit }}  
- **Type:** {{ ucfirst($latestReading->type) }}  
- **Logged on:** {{ \Carbon\Carbon::parse($latestReading->converted_at)->format('M d, Y h:i A') }}

@endif

@component('mail::button', ['url' => url('/dashboard')])
Log Today's Reading
@endcomponent

Stay consistent — your health appreciates it!

Thanks,  
**The GlucoTracker Team**

@endcomponent
