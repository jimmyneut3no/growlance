<!DOCTYPE html>
<html>
<head>
    <title>New Support Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Support Request</h2>
        </div>
        
        <div class="content">
            <div class="user-info">
                <h3>User Information</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>User ID:</strong> {{ $user->id }}</p>
            </div>

            <h3>Support Request Details</h3>
            <p><strong>Subject:</strong> {{ $subject }}</p>
            
            <div class="message-content">
                <p><strong>Message:</strong></p>
                <p>{{ $message }}</p>
            </div>

            <p style="margin-top: 20px;">
                <a href="{{ config('app.url') }}/admin/users/{{ $user->id }}" style="color: #4f46e5; text-decoration: none;">
                    View User Profile →
                </a>
            </p>
        </div>
    </div>
</body>
</html> 