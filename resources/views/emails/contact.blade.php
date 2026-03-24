<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #1e3a5f, #3b82f6);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #1e3a5f;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div>{{ $data['name'] }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email:</div>
            <div>{{ $data['email'] }}</div>
        </div>
        
        <div class="field">
            <div class="label">Subject:</div>
            <div>{{ $data['subject'] ?? 'No Subject' }}</div>
        </div>
        
        <div class="field">
            <div class="label">Message:</div>
            <div>{{ $data['message'] }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This message was sent from the ElectroBook contact form.</p>
        <p>&copy; {{ date('Y') }} ElectroBook. All rights reserved.</p>
    </div>
</body>
</html>