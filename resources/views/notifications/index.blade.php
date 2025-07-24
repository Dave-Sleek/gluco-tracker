@extends('layouts.layout')


<div class="container py-4">
    <h3 class="mb-4"><i class="fa fa-bell"></i> Notifications</h3>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'unread' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'unread']) }}">Unread</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'all' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'all']) }}">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'glucose' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'glucose']) }}">
                <i class="bi bi-droplet-half me-1 text-danger"></i> Glucose Alerts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'symptom' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'symptom']) }}">
                <i class="bi bi-heart-pulse me-1 text-warning"></i> Symptom Alerts
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'feedback_replies' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'feedback_replies']) }}">Reply Notifications</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('tab') === 'replies' ? 'active' : '' }}" href="{{ route('notifications', ['tab' => 'replies']) }}">Feedback Replies</a>
        </li>
    </ul>

    @if ($tab !== 'replies' && $notifications && $notifications->count() > 0 && $tab === 'unread')
    <div class="mb-3">
        <button class="btn btn-sm btn-primary" onclick="markAllAsRead()">Mark All as Read</button>
        @csrf
    </div>
    @endif

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif


    @if ($tab === 'replies')
        @if ($replies->isEmpty())
            <div class="alert alert-info">No feedback replies yet.</div>
        @else
            <div class="row row-cols-1 g-3">
                @foreach ($replies as $reply)
                    <div class="col">
                        <div class="card border-success shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-success"><i class="bi bi-arrow-return-left"></i> Admin Reply</h5>
                                <p class="card-text mb-2">{{ $reply->reply }}</p>
                                <hr>
                                <small class="text-muted">
                                <strong>Your Feedback ({{ $reply->feedback_type }}):</strong>
                                {{ $reply->feedback_message }}
                                </small><br>

                                <small class="text-muted">Replied on: {{ \Carbon\Carbon::parse($reply->created_at)->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        @if ($notifications->isEmpty())
            <div class="alert alert-info">No notifications.</div>
        @else
            <div class="row row-cols-1 g-3" id="notification-list">
                @foreach ($notifications as $notification)
                    <div class="col notification-item" data-id="{{ $notification->id }}">
                        <div class="card notification-card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1">
                                            <i class="bi {{ $typeIcons[$notification->type] ?? 'bi-info-circle' }}"></i>
                                            {{ $notification->title }}
                                        </h5>
                                        <p class="card-text small text-muted mb-2">{{ $notification->message }}</p>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <div class="ms-3 d-flex flex-column align-items-end">
                                    @if ($notification->status !== 'sent')
                                    <button class="mark-btn mb-2" onclick="markAsRead({{ $notification->id }})" title="Mark as Read">
                                        <i class="bi bi-check-circle-fill"></i>
                                        @csrf
                                    </button>
                                    @endif
                                        <form method="POST" action="{{ route('notifications.dismiss', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="dismiss-btn" title="Dismiss">
                                                <i class="bi bi-x-circle fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<script>
    function dismissNotification(id) {
        if (!confirm("Are you sure you want to dismiss this notification?")) return;

        fetch(`/notifications/${id}/dismiss`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`.notification-item[data-id='${id}']`)?.remove();
            } else {
                alert("Failed to dismiss notification.");
            }
        });
    }

function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`.notification-item[data-id='${id}']`)?.remove();
        } else {
            alert("Failed to mark as read.");
        }
    })
    .catch(() => alert("Couldn’t connect. Please try again."));
}

    function markAllAsRead() {
        if (!confirm("Mark all unread notifications as read?")) return;

        fetch('/notifications/mark-all-sent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item').forEach(el => el.remove());
            } else {
                alert("Failed to mark all as read.");
            }
        });
    }
</script>

