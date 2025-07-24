@component('mail::message')
<img src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}" alt="GlucoTracker Logo" width="120">
 <!-- Replace with actual logo path -->

# Welcome to GlucoTracker, {{ $user->full_name }} 🎉

We're thrilled to have you on board. Your health journey just got smarter.

---

## 🧠 Recent Wellness Tips

- ✅ Monitor glucose before and after meals for patterns
- 🍎 Pair carbs with protein or fiber to reduce spikes
- 🛌 Get consistent sleep — it improves insulin sensitivity

<!-- ---

## 🔍 What’s Coming Soon?

- 📈 Glucose trend charts & insights
- 💬 AI-generated advice based on your readings
- 📅 Schedule reminders and medication tracking

--- -->

@component('mail::button', ['url' => url('/dashboard')])
Go to My Dashboard
@endcomponent

Thank you for joining — you've taken the first step toward better health 🩺

_Stay safe, stay informed._

@endcomponent
