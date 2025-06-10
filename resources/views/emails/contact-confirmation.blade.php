<!DOCTYPE html>
<html>
<head>
    <title>Thank you for contacting Growlance</title>
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
            <h2>Thank you for contacting Growlance</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $firstName }} {{ $lastName }},</p>
            
            <p>Thank you for reaching out to us. We have received your message and will get back to you as soon as possible.</p>
            
            <p>Here's a summary of your message:</p>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <p><strong>Your Message:</strong></p>
                <p>{{ $message }}</p>
            </div>

            <p>If you have any additional information to share, please feel free to reply to this email.</p>
            
            <p>Best regards,<br>
            The Growlance Team</p>
        </div>

        <div class="footer">
            <p>This is an automated response. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Growlance. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 