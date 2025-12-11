@extends('layouts.admin')

@section('content')

<head>
  <meta charset="UTF-8">
  <title>Application Form Preview</title>
  <style>
    body { font-family: Arial, sans-serif; color: #333; }
    h2 { text-align: center; margin-bottom: 0; }
    .section { margin: 20px 0; }
    .label { font-weight: bold; margin-top: 10px; }
    .row { display: flex; flex-wrap: wrap; margin-bottom: 5px; }
    .cell-1 { width: 20%; }
    .cell-2 { width: 30%; }
    .cell-3 { width: 25%; }
    .cell-4 { width: 25%; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table, th, td { border: 1px solid #000; }
    th, td { padding: 5px; text-align: left; }

            .form-container {
                max-width: 800px;
                margin: 40px auto;         /* space from top/bottom */
                background-color: #fff;    /* clean white background */
                border: 1px solid #ccc;    /* softer border */
                border-radius: 8px;        /* rounded corners */
                padding: 20px;             /* inner spacing */
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* floating effect */
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            /* subtle hover effect */
            .form-container:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
            }


         .header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 2px solid black;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background-color: #0066cc;
            border: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .header-text {
            flex: 1;
            text-align: center;
            line-height: 1.2;
        }

        .header-text .republic {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 2px;
        }

        .header-text .department {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .header-text .region {
            font-size: 12px;
            font-weight: normal;
            margin-bottom: 0;
        }

        .page-number {
            text-align: right;
            font-size: 12px;
            width: 80px;
            flex-shrink: 0;
        }

        .form-title {
            text-align: center;
            padding: 15px 20px;
            border-bottom: 2px solid black;
            background-color: #f8f8f8;
        }

        .form-title .title {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.3;
            margin: 0;
        }

        .form-field {
            margin-bottom: 8px;
            padding: 8px 15px;
        }

        .form-field label {
            font-weight: bold;
            display: inline-block;
            margin-right: 10px;
        }

        .form-field input {
            border: none;
            border-bottom: 1px solid black;
            background: transparent;
            padding: 2px 5px;
            font-size: 14px;
        }

        .form-field input:focus {
            outline: none;
            border-bottom: 2px solid #007bff;
        }

        .name-row {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 8px 15px;
        }

        .name-section {
            flex: 1;
        }

        .name-section label {
            font-weight: bold;
            display: block;
            font-size: 12px;
            margin-bottom: 2px;
        }

        .name-section .value {
            min-height: 20px;
            padding: 5px 0;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .value {
            display: inline-block;
            min-width: 100px;
            min-height: 18px;
            padding: 2px 5px;
            border-bottom: 1px solid black;
            margin-right: 15px;
            font-size: 14px;
            vertical-align: bottom;
        }

        .birth-age-row {
            display: flex;
            align-items: center;
            gap: 30px;
            padding: 8px 15px;
        }

        .address-row {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 15px;
        }

        .address-section {
            flex: 1;
        }

        .contact-row {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 15px;
        }

        .contact-section {
            flex: 1;
        }

        .short-input {
            width: 120px !important;
        }

        .medium-input {
            width: 200px !important;
        }

        .long-input {
            width: 300px !important;
        }

        .full-input {
            width: 100% !important;
        }

        hr {
            margin: 0;
            border: none;
            border-top: 1px solid black;
        }
  </style>
</head>
<body>

    <div class="form-container mt-5">

  {{-- Personal Info --}}
  <div class="header">
            <div class="logo">
                <!-- Replace this div with actual logo image -->
                <img src="{{ asset('img/DOST-CAR.png') }}" width="90" height="90">
                {{-- <div class="logo-placeholder">DOST LOGO</div> --}}
            </div>

            <div class="header-text mt-2">
                <div class="republic">Republic of the Philippines</div>
                <div class="department">Department of Science and Technology</div>
                <div class="region">Cordillera Administrative Region</div>
            </div>

            <div class="page-number">
                {{-- Page 1 of 4 --}}
            </div>
        </div>

        <!-- Form Title -->
        <div class="form-title">
            <div class="title">
                APPLICATION FORM FOR THE ACCREDITATION OF<br>
                TECHNICAL PERSONNEL/TRAINER/SUBJECT MATTER SPECIALIST
            </div>
        </div>

        <!-- IMG -->
            <div class="name-section mt-3" style="text-align:right;">
                @if($speaker->img)
                    <img src="{{ asset($speaker->img) }}" alt="User Photo" width="100" height="100" style="object-fit: cover; border:1px solid #000;">
                @else
                    <span><i class="fa fa-user-circle" aria-hidden="true" style="object-fit: cover; border:1px solid #000;height: 100px;width: 100px;"></i></span>
                @endif
            </div>

    <!-- Name Row -->
        <div class="name-row">
            <div class="name-section">
                <div><label><strong>Name: </strong></label></div>
                <label></label>
            </div>
            <div class="name-section">
                <div class="value">{{ $speaker->last_name }}</div>
                <label>Last Name</label>
            </div>
            <div class="name-section">
                <div class="value">{{ $speaker->given_name }}</div>
                <label>Given Name</label>
            </div>
            <div class="name-section">
                <div class="value">{{ $speaker->middle_name }}</div>
                <label>Middle Name</label>
            </div>
            <div class="name-section">
                <div class="value">{{ $speaker->ext_name }}</div>
                <label>Name Ext'n (Jr., III, Sr)</label>
            </div>
        </div>

        <!-- Date of Birth, Place of Birth, Age Row -->
        <div class="birth-age-row">
            <label><strong>Date of Birth:</strong></label>
            <div class="value">{{ $speaker->date_of_birth }}</div>

            <label><strong>Place of Birth:</strong></label>
            <div class="value">{{ $speaker->place_of_birth }}</div>

            <label><strong>Age:</strong></label>
            <div class="value">{{ $speaker->age }}</div>
        </div>


        <div class="birth-age-row">
            <label><strong>Office/Organization:</strong></label>
            <div class="value">{{ $speaker->office->office_organization ?? 'N/A' }}</div>
        </div>
        <div class="birth-age-row">
            <label><strong>Position:</strong></label>
            <div class="value">{{ $speaker->office->position ?? 'N/A' }}</div>
        </div>
        {{-- <hr> --}}

        <!-- Office Address -->
        <div class="form-field">
            <label>Office Address:</label>
        </div>

        <div class="address-row">
            <label>Building No.:</label>
            <div class="value">{{ $speaker->office->building_no ?? 'N/A' }}</div>
            <label>Street/Barangay:</label>
            <div class="value">{{ $speaker->office->barangay }}</div>
        </div>

        <div class="address-row">
            <label>Municipality/City:</label>
            <div class="value">{{ $speaker->office->municipality }}</div>
            <label>Province:</label>
            <div class="value">{{ $speaker->office->province }}</div>
        </div>

        <div class="form-field">
            <label>Zip Code:</label>
            <div class="value">{{ $speaker->office->zip_code }}</div>
        </div>

        <div class="contact-row">
            <label>Tel. No.:</label>
            <div class="value">{{ $speaker->office->tel_no }}</div>
            <label>Cellphone No.:</label>
            <div class="value">{{ $speaker->office->cell_no }}</div>
        </div>

        <div class="form-field">
            <label style="margin-left: 50px;">Fax No.:</label>
            <div class="value">{{ $speaker->office->fax_no }}</div>
        </div>


        <!-- Home/Residence Address -->
        <div class="form-field">
            <label>Home/Residence Address:</label>
        </div>

        <div class="address-row">
            <label>Building No.:</label>
            <div class="value">{{ $speaker->home_building_no }}</div>
            <label>Street/Barangay:</label>
            <div class="value">{{ $speaker->home_barangay }}</div>
        </div>

        <div class="address-row">
            <label>Municipality/City:</label>
            <div class="value">{{ $speaker->home_municipality }}</div>
            <label>Province:</label>
            <div class="value">{{ $speaker->home_province }}</div>
        </div>

        <div class="form-field">
            <label>Zip Code:</label>
            <div class="value">{{ $speaker->home_zip_code }}</div>
        </div>

        <div class="contact-row">
            <label>Tel. No.:</label>
            <div class="value">{{ $speaker->home_tel_no }}</div>
            <label>Cellphone No.:</label>
            <div class="value">{{ $speaker->home_cell_no }}</div>
        </div>

        <div class="form-field">
            <label style="margin-left: 50px;">Fax No.:</label>
            <div class="value">{{ $speaker->home_fax_no }}</div>
        </div>


        <!-- Gender and Email Row -->
        <div class="birth-age-row">
            {{-- <label><strong>Gender:</strong></label>
            <div class="value">{{ $speaker->gender }}</div> --}}

            <label><strong>E-mail Address:</strong></label>
            <div class="value">{{ $speaker->email }}</div>
        </div>

        <!-- Fields of Specialization/Expertise -->
        <div class="form-field">
            <label>Field/s of Expertise:</label>
            <div class="value">{{ optional($speaker->expertises)->pluck('expertis')->implode(', ') ?? 'N/A' }}</div>
        </div>

  {{-- Educational Background --}}
  <div class="section">
    <div class="label">Educational Background</div>
    <table>
      <tr>
        <th>Level/Degree</th>
        <th>Year From</th>
        <th>Year To</th>
        <th>School/Institution</th>
        <th>Year Graduated</th>
        <th>Awards</th>
      </tr>
      @foreach($speaker->educationalBackground as $edu)
        <tr>
          <td>{{ $edu->level }}</td>
          <td>{{ $edu->from_year }}</td>
          <td>{{ $edu->to_year }}</td>
          <td>{{ $edu->school }}</td>
          <td>{{ $edu->year_graduated }}</td>
          <td>{{ $edu->awards }}</td>
        </tr>
      @endforeach
    </table>
  </div>


  {{-- Work Experience --}}
  <div class="section">
    <div class="label">Work Experience</div>
    <table>
      <tr><th>Start Date</th><th>End Date</th><th>Company</th><th>Position</th><th>Division</th></tr>
      @foreach($speaker->workExperiences as $w)
        <tr>
          <td>{{ $w->date_started }}</td>
          <td>{{ $w->date_ended }}</td>
          <td>{{ $w->name_company }}</td>
          <td>{{ $w->position }}</td>
          <td>{{ $w->division }}</td>
        </tr>
      @endforeach
    </table>
  </div>

  {{-- Training / Seminar Experience --}}
  <div class="section">
    <div class="label">Training Experience as Trainer</div>
    <table>
      <tr><th>Title</th><th>Venue</th><th>Date</th><th>Hours</th></tr>
      @foreach($speaker->trainings as $t)
        <tr>
          <td>{{ $t->rt_title }}</td>
          <td>{{ $t->rt_venue }}</td>
          <td>{{ $t->rt_date }}</td>
          <td>{{ $t->rt_no_hours }}</td>
        </tr>
      @endforeach
    </table>
  </div>

  {{-- Training as Trainer --}}
  <div class="section">
    <div class="label">Training/Seminar Experience</div>
    <table>
      <tr><th>Title</th><th>Venue</th><th>Date</th><th>Hours</th></tr>
      @foreach($speaker->experienceTrainer as $et)
        <tr>
          <td>{{ $et->rst_title }}</td>
          <td>{{ $et->rst_venue }}</td>
          <td>{{ $et->rst_date }}</td>
          <td>{{$et->rst_no_hours}}</td>
        </tr>
      @endforeach
    </table>
  </div>

  {{-- Publications --}}
  <div class="section">
    <div class="label">Publications</div>
    <table>
      <tr><th>Title</th><th>Date</th><th>Venue</th></tr>
      @foreach($speaker->publications as $p)
        <tr>
          <td>{{ $p->p_title }}</td>
          <td>{{ $p->p_date }}</td>
          <td>{{ $p->p_venue }}</td>
        </tr>
      @endforeach
    </table>
  </div>

  {{-- References --}}
  <div class="section">
    <div class="label">References for Training</div>
    <table>
      <tr><th>Agency</th><th>Address</th><th>Contact Person</th><th>Position</th><th>Tel No.</th><th>Cell No.</th></tr>
      @foreach($speaker->referencesTrainings as $r)
        <tr>
          <td>{{ $r->name_agency }}</td>
          <td>{{ $r->address }}</td>
          <td>{{ $r->contact_person }}</td>
          <td>{{ $r->position }}</td>
          <td>{{ $r->tel_no }}</td>
          <td>{{ $r->cell_no }}</td>
        </tr>
      @endforeach
    </table>
  </div>

</div>

@endsection
