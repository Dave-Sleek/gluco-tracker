<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Forgot Password</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
       .spinner-overlay {
           position: fixed;
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background-color: rgba(255,255,255,0.7);
           display: none;
           justify-content: center;
           align-items: center;
           z-index: 1000;
       }
   </style>
</head>
<body class="container py-5">
   <h2 class="mb-4">Forgot Password</h2>

   @if(session('status'))
       <div class="alert alert-success">{{ session('status') }}</div>
   @endif
   @if($errors->any())
       <div class="alert alert-danger">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif

   <form method="POST" action="{{ route('password.email') }}" class="card p-4 shadow-sm" id="resetForm">
       @csrf
       <div class="mb-3">
           <label for="email" class="form-label">Enter your email:</label>
           <input type="email" class="form-control" name="email" id="email" required>
       </div>
       <button type="submit" class="btn btn-primary">Send Reset Link</button>
   </form>

   <!-- Spinner Overlay -->
   <div class="spinner-overlay" id="spinner">
       <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
           <span class="visually-hidden">Sending...</span>
       </div>
   </div>

   <script>
       const form = document.getElementById('resetForm');
       const spinner = document.getElementById('spinner');

       form.addEventListener('submit', () => {
           spinner.style.display = 'flex';
       });
   </script>
</body>
</html>
