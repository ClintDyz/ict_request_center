<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Informed Consent - RSMIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", "Segoe UI", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background: linear-gradient(135deg, #1a2f5a 0%, #243a6e 100%);
        }

        .consent-container {
            width: 95%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0px 20px 60px rgba(0,0,0,0.4);
            position: relative;
            margin: 20px;
        }

        .consent-header {
            background: linear-gradient(135deg, #1a2f5a 0%, #243a6e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .consent-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .consent-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .consent-body {
            padding: 30px;
        }

        .consent-content {
            background: #f7f4ee;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .consent-content h5 {
            color: #1a2f5a;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .consent-content p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .consent-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .consent-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #555;
        }

        .consent-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #c9a84c;
            font-weight: bold;
        }

        .consent-options {
            margin-top: 25px;
        }

        .consent-options .option-item {
            display: flex;
            align-items: flex-start;
            padding: 15px 20px;
            background: #fff;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .consent-options .option-item:hover {
            border-color: #1a2f5a;
        }

        .consent-options .option-item.selected {
            border-color: #1a2f5a;
            background: #f0f4ff;
        }

        .consent-options input[type="radio"] {
            width: 22px;
            height: 22px;
            margin-right: 15px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #1a2f5a;
            flex-shrink: 0;
        }

        .consent-options .option-label {
            font-weight: 500;
            cursor: pointer;
            color: #333;
            line-height: 1.5;
        }

        .btn-action {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn-proceed {
            background: linear-gradient(135deg, #1a2f5a 0%, #243a6e 100%);
            border: none;
            color: white;
        }

        .btn-proceed:hover {
            opacity: 0.9;
            color: white;
        }

        .btn-proceed:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-cancel {
            background: #fff;
            border: 2px solid #1a2f5a;
            color: #1a2f5a;
        }

        .btn-cancel:hover {
            background: #f0f4ff;
            color: #1a2f5a;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 13px;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-link:hover {
            color: #c9a84c;
        }
    </style>
</head>
<body>
    <a href="{{ url('/login') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Login
    </a>

    <div class="consent-container">
        <div class="consent-header">
            <h2><i class="fas fa-file-alt"></i> Informed Consent Form</h2>
            <p>Prior to proceeding with registration, you are required to read and provide your consent to the terms stated below.</p>
        </div>

        <div class="consent-body">
            <div class="consent-content">
                <h5><i class="fas fa-info-circle"></i> Informed Consent</h5>
                <p>By accessing and continuing to use the Resource Speaker's Management Information System, you hereby acknowledge, understand, and agree to the following:</p>
                <ul class="consent-list">
                    <li>I voluntarily consent to the collection and processing of my personal information for purposes related to registration, participation, and system-related transactions.</li>
                    <li>I understand that my participation in this system is entirely voluntary and that I am under no obligation to provide my personal information.</li>
                    <li>I acknowledge that I have the right to refuse, withhold, or withdraw my consent at any time, without penalty or prejudice.</li>
                </ul>
            </div>

            <h6 class="mb-3" style="color: #1a2f5a;">Please indicate your decision:</h6>

            <div class="consent-options">
                <label class="option-item" id="agreeOption" onclick="selectOption('agree')">
                    <input type="radio" name="consent" id="agree" value="agree">
                    <span class="option-label"><strong>I AGREE</strong> to the terms stated above and consent to proceed with the registration process.</span>
                </label>

                <label id="disagreeOption" onclick="selectOption('disagree')">
                    <input type="hidden" name="consent" id="disagree" value="disagree">
                    {{-- <span class="option-label"><strong>I DO NOT AGREE</strong> to the terms stated above and understand that I will not be able to proceed.</span> --}}
                </label>
            </div>

            <button type="button" id="proceedBtn" class="btn btn-action btn-proceed" disabled onclick="handleSubmit()">
                <i class="fas fa-arrow-right me-2"></i> Proceed to Registration
            </button>

            <button type="button" id="cancelBtn" class="btn btn-action btn-cancel" onclick="handleCancel()">
                <i class="fas fa-times me-2"></i> Cancel
            </button>

            <p class="footer-note">
                Your privacy and consent are important to us. Please read carefully before proceeding.
            </p>
        </div>
    </div>

    <script>
        let selectedOption = null;

        function selectOption(option) {
            selectedOption = option;

            document.getElementById('agreeOption').classList.remove('selected');
            document.getElementById('disagreeOption').classList.remove('selected');

            if (option === 'agree') {
                document.getElementById('agreeOption').classList.add('selected');
                document.getElementById('proceedBtn').disabled = false;
            } else {
                document.getElementById('disagreeOption').classList.add('selected');
                document.getElementById('proceedBtn').disabled = true;
            }
        }

        function handleSubmit() {
            if (selectedOption === 'agree') {
                window.location.href = '{{ route('resource_speaker.create') }}';
            }
        }

        function handleCancel() {
            window.location.href = '{{ url('/login') }}';
        }
    </script>
</body>
</html>
