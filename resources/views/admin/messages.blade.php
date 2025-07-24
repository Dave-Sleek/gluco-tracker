<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Send Notification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Send Message</h5>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.messages.store') }}">
              @csrf
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" class="form-control" rows="4" required placeholder="Write your message...">{{ old('message') }}</textarea>
              </div>

              <div class="mb-3">
                <label for="target" class="form-label">Target User</label>
                <select name="target" id="target" class="form-select" required>
                  <option value="all" {{ old('target') === 'all' ? 'selected' : '' }}>All Users</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('target') == $user->id ? 'selected' : '' }}>
                        {{ $user->full_name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-success">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
</body>
</html>