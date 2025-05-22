
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Created</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 40px; font-family: Arial, sans-serif;">
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">New User Registered</h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Total Users in the system</strong> {{ $userCount }}</p>

            <hr>

            <p>A new user has been successfully added to the system.</p>

        </div>
        <div class="card-footer text-muted text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</div>
</body>
</html>
