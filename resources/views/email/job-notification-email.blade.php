{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
</head>
<body>
    <h1>Hey! {{ $mailData['employer']->name }}</h1>
    <p style="font-weight: bold">Job Title:  {{ $mailData['job']->title }}</p>

    <p style="font-weight: bold">Employee Details</p>
    <p style="font-weight: bold">Name: {{ $mailData['user']->name }}</p>
    <p style="font-weight: bold">Email: {{ $mailData['user']->email }}</p>
    <p style="font-weight: bold">Mobile No: {{ $mailData['user']->mobile }}</p>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        .header {
            background-color: #0033aa;
            color: #ffffff;
            padding: 30px;
            text-align: center;
            /* border-bottom: 4px solid #0033aa; */
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
            font-size: 16px;
            line-height: 1.6;
        }
        .content p {
            margin: 0 0 20px;
        }
        .content .highlight {
            font-weight: bold;
            /* color: #0044cc; */
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer a {
            color: #0044cc;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .header h1 {
                font-size: 24px;
            }
            .content {
                padding: 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Hello {{ $mailData['employer']->name }},</h1>
        </div>
        <div class="content">
            <p>We are thrilled to inform you about a new job application for the position of <span class="highlight">{{ $mailData['job']->title }}</span>.</p>
            
            <p class="highlight">Employee Details:</p>
            <p><span class="highlight">Name:</span> {{ $mailData['user']->name }}</p>
            <p><span class="highlight">Email:</span> {{ $mailData['user']->email }}</p>
            <p><span class="highlight">Mobile No:</span> {{ $mailData['user']->mobile }}</p>

            <p style="text-align: justify">Thank you for using our platform to discover top talent. If you have any questions or require further assistance, please do not hesitate to reply to this email.</p>
        
            
            <p>Best regards,<br>The CareerVibe Team</p>
        </div>
        <div class="footer">
            <p>© 2024 CareerVibe. All rights reserved. | <a href="[unsubscribe_link]">Unsubscribe</a></p>
        </div>
    </div>
</body>
</html>



