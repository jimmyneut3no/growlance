<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
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
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        
        <div class="content">
            <p><strong>Name:</strong> {{ $firstName }} {{ $lastName }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            @if($phone)
            <p><strong>Phone:</strong> {{ $phone }}</p>
            @endif
            <p><strong>Message:</strong></p>
            <p>{{ $message }}</p>
        </div>

        <div class="footer">
            <p>This email was sent from the contact form on growlance.io</p>
        </div>
    </div>
</body>
</html> 