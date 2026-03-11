<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Resource Speaker Application</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #eef2f7;
            padding: 40px 20px;
            color: #333;
        }
        .wrapper {
            max-width: 620px;
            margin: auto;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a3c6e, #2e6da4);
            border-radius: 10px 10px 0 0;
            padding: 36px 40px;
            text-align: center;
        }
        .header img {
            width: 60px;
            margin-bottom: 14px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            color: #c8dcf0;
            font-size: 13px;
            margin-top: 6px;
            letter-spacing: 0.3px;
        }

        /* Badge */
        .badge {
            background: #ffffff;
            text-align: center;
            padding: 12px;
            border-left: 1px solid #dde4ee;
            border-right: 1px solid #dde4ee;
        }
        .badge span {
            display: inline-block;
            background: #e8f4fd;
            color: #1a6eb5;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 16px;
            border-radius: 20px;
            border: 1px solid #b8d9f5;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Body */
        .body {
            background: #ffffff;
            padding: 36px 40px;
            border-left: 1px solid #dde4ee;
            border-right: 1px solid #dde4ee;
        }
        .intro {
            font-size: 14.5px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .intro strong {
            color: #1a3c6e;
        }

        /* Section label */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2e6da4;
            margin-bottom: 14px;
        }

        /* Info table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e4eaf2;
        }
        .info-table tr:nth-child(even) td {
            background-color: #f7fafd;
        }
        .info-table td {
            padding: 13px 16px;
            font-size: 13.5px;
            vertical-align: top;
            border-bottom: 1px solid #eaeff6;
        }
        .info-table td:first-child {
            font-weight: 600;
            color: #4a5568;
            width: 38%;
            white-space: nowrap;
        }
        .info-table td:last-child {
            color: #2d3748;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Icon dots */
        .info-table td:first-child::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            background: #2e6da4;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            opacity: 0.6;
        }

        /* CTA Button */
        .cta-wrap {
            text-align: center;
            margin: 28px 0 10px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a3c6e, #2e6da4);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        /* Footer */
        .footer {
            background: #f4f7fb;
            border: 1px solid #dde4ee;
            border-top: none;
            border-radius: 0 0 10px 10px;
            padding: 22px 40px;
            text-align: center;
        }
        .footer p {
            font-size: 11.5px;
            color: #8a9ab5;
            line-height: 1.7;
        }
        .footer .divider {
            border: none;
            border-top: 1px solid #dde4ee;
            margin: 14px 0;
        }
        .footer .org {
            font-size: 12px;
            font-weight: 600;
            color: #5a7ba8;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <h1>Resource Speaker Application</h1>
            <p>New application received — awaiting your review</p>
        </div>

        <!-- Status Badge -->
        <div class="badge">
            <span>⏳ Pending Review</span>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="intro">
                A new resource speaker application has been submitted through the system.
                Please review the details below and take the appropriate action at your earliest convenience.
            </p>

            <div class="section-label">Applicant Information</div>

            <table class="info-table">
                <tr>
                    <td>Full Name</td>
                    <td>{{ $applicant->given_name }} {{ $applicant->middle_name }} {{ $applicant->last_name }}{{ $applicant->ext_name ? ', ' . $applicant->ext_name : '' }}</td>
                </tr>
                <tr>
                    <td>Email Address</td>
                    <td>{{ $applicant->email }}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>{{ $applicant->gender }}</td>
                </tr>
                <tr>
                    <td>Area of Expertise</td>
                    <td>{{ $applicant->expertise }}</td>
                </tr>
                <tr>
                    <td>Home Address</td>
                    <td>{{ $applicant->home_address }}, {{ $applicant->home_barangay }}, {{ $applicant->home_municipality }}, {{ $applicant->home_province }}</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td>{{ $applicant->home_cell_no }}</td>
                </tr>
                <tr>
                    <td>Date Submitted</td>
                    <td>{{ now()->format('F d, Y \a\t h:i A') }}</td>
                </tr>
            </table>

            <div class="cta-wrap">
                <a href="https://rsmis.dostcar.ph" class="cta-button">Review Application →</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="org">DOST – Cordillera Administrative Region</p>
            <hr class="divider">
            <p>
                This is an automated system notification. Please do not reply to this email.<br>
                If you believe you received this in error, please contact your system administrator.
            </p>
        </div>

    </div>
</body>
</html>
