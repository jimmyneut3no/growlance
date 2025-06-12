<!DOCTYPE html>
<html>
<head>
    <title>Support Request Received</title>
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
        .message-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
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
            <h2>Support Request Received</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            
            <p>Thank you for contacting Growlance Support. We have received your support request and will get back to you as soon as possible.</p>
            
            <div class="message-content">
                <p><strong>Subject:</strong> {{ $subject }}</p>
                <p><strong>Your Message:</strong></p>
                <p>{{ $contactMessage }}</p>
            </div>

            <p>Our support team will review your request and respond within 24-48 hours. If you need immediate assistance, please contact us via the livechat on our website.</p>
            
            <p>Best regards,<br>
            The Growlance Support Team</p>
        </div>

        <div class="footer">
            <p>This is an automated response. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Growlance. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 