<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>📬 User Feedback & Reports</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Type</th>
                <th>Submitted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($feedbacks as $fb)
            <tr>
                <td>{{ $fb->id }}</td>
                <td>{{ $fb->user->full_name }}</td>
                <td>{{ ucfirst($fb->type) }}</td>
                <td>{{ $fb->created_at }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewFeedback{{ $fb->id }}">
                        View & Respond
                    </button>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="viewFeedback{{ $fb->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Feedback #{{ $fb->id }} from {{ $fb->user->full_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Type:</strong> {{ ucfirst($fb->type) }}</p>
                            <p><strong>Submitted:</strong> {{ $fb->created_at }}</p>
                            <hr>
                            <p>{!! nl2br(e($fb->message)) !!}</p>

                            <form method="POST" action="{{ route('admin.feedback') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $fb->user_id }}">
                                <input type="hidden" name="feedback_id" value="{{ $fb->id }}">
                                <div class="mb-3 mt-3">
                                    <label class="form-label">Reply to user:</label>
                                    <textarea name="reply" class="form-control" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Send Reply 📧</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
