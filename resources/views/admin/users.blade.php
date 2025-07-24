<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>👥 User Management</h2>

    <form method="GET" class="row g-3 my-3">
    <div class="col-md-3">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search...">
    </div>
    <div class="col-md-3">
        <input type="date" name="from" class="form-control" value="{{ $from }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" class="form-control" value="{{ $to }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_banned ? '❌ Banned' : '✅ Active' }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.user_profile', $user->id) }}" class="btn btn-sm btn-light">View</a>
                    <a href="{{ route('admin.users.export', $user->id) }}" class="btn btn-sm btn-success">Export</a>

                    <form method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button name="reset_password" class="btn btn-sm btn-secondary">Reset Password</button>
                    </form>

                    <form method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button name="ban_user" class="btn btn-sm btn-warning">Ban</button>
                    </form>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
<script>
function deleteUser(userId) {
    if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) return;

    fetch("{{ route('admin.user_delete') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            location.reload();
        }
    })
    .catch(err => {
        alert("Something went wrong!");
        console.error(err);
    });
}
</script>
</body>
</html>
