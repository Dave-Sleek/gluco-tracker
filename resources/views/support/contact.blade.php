<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title>Help & Support</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h3 class="mb-4"><i class="fa fa-stethoscope"></i> Help & Support</h3>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('feedback_success'))
        <div class="alert alert-success">✅ {{ session('feedback_success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Contact Form -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Send a Message</h5>
                    <form method="POST" action="{{ route('support.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Options -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Other Ways to Reach Us</h5>
                    <p>
                        <strong><i class="fa fa-phone"></i> Call Us:</strong>
                        <a href="tel:{{ $adminPhone }}">{{ $adminPhone }}</a>
                    </p>
                    <p>
                        <strong><i class="fa fa-envelope"></i> Email:</strong>
                        <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>
                    </p>
                    <p>
                        <strong><i class="fab fa-whatsapp"></i> WhatsApp:</strong>
                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="btn btn-success btn-sm">
                            Chat on WhatsApp <i class="fab fa-whatsapp"></i>
                        </a>
                    </p>
                    <p class="text-muted small mt-3">
                        Our support is available Monday–Friday, 9AM to 5PM (WAT).
                    </p>
                </div>
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card">
                    <div class="card-header">Submit Feedback / Report</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('feedback.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="feedback_type" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="bug">Bug</option>
                                    <option value="dispute">Dispute</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('feedbackForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const alertBox = document.getElementById('feedbackAlert');
    alertBox.innerHTML = '';

    try {
        const res = await fetch("{{ route('feedback.submit') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        });

        const data = await res.json();
        const alertClass = data.status === 'success' ? 'alert-success' : 'alert-danger';
        alertBox.innerHTML = `<div class="alert ${alertClass}">${data.message}</div>`;

        if (data.status === 'success') form.reset();

    } catch (err) {
        alertBox.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
    }
});
</script>

</html>
