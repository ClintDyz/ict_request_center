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
  </style>
</head>
<body>

  <h2>APPLICATION FORM FOR THE ACCREDITATION OF</h2>
  <h2>TECHNICAL PERSONNEL / TRAINER / SUBJECT MATTER SPECIALIST</h2>

  {{-- Personal Info --}}
  <div class="section">
    <div class="label">Name:</div>
    <div class="row">
      <div class="cell-1">{{ $speaker->last_name }}</div>
      <div class="cell-2">{{ $speaker->given_name }}</div>
      <div class="cell-3">{{ $speaker->middle_name }}</div>
      <div class="cell-4">{{ $speaker->ext_name }}</div>
    </div>
    <div class="row">
      <div class="cell-1 label">Last Name</div>
      <div class="cell-2 label">Given Name</div>
      <div class="cell-3 label">Middle Name</div>
      <div class="cell-4 label">Name Ext’n</div>
    </div>

    <div class="row">
      <div class="cell-2 label">Date of Birth:</div>
      <div class="cell-2">{{ $speaker->date_of_birth }}</div>
      <div class="cell-2 label">Place of Birth:</div>
      <div class="cell-2">{{ $speaker->place_of_birth }}</div>
      <div class="cell-1 label">Age:</div>
      <div class="cell-1">{{ $speaker->age }}</div>
    </div>

    <div class="row">
      <div class="cell-1 label">Gender:</div>
      <div class="cell-2">{{ $speaker->gender }}</div>
      <div class="cell-2 label">E‑mail Address:</div>
      <div class="cell-3">{{ $speaker->email }}</div>
    </div>

    <div class="row">
      <div class="cell-1 label">Field/s of Expertise:</div>
      <div class="cell-4">{{ optional($speaker->expertises)->pluck('expertis')->implode(', ') ?? 'N/A' }}</div>
    </div>
  </div>

  {{-- Office & Home --}}
  <div class="section">
    <div class="label">Office Address</div>
    <div class="row">
      <div class="cell-2 label">Building No.:</div><div class="cell-2">{{ $speaker->home_building_no }}</div>
      <div class="cell-2 label">Street/Barangay:</div><div class="cell-2">{{ $speaker->home_barangay }}</div>
    </div>
    <div class="row">
      <div class="cell-2 label">Municipality/City:</div><div class="cell-2">{{ $speaker->home_municipality }}</div>
      <div class="cell-2 label">Province:</div><div class="cell-2">{{ $speaker->home_province }}</div>
    </div>
    <div class="row">
      <div class="cell-2 label">Zip Code:</div><div class="cell-2">{{ $speaker->home_zip_code }}</div>
      <div class="cell-2 label">Tel.:</div><div class="cell-2">{{ $speaker->home_tel_no }}</div>
    </div>
    <div class="row">
      <div class="cell-2 label">Cellphone:</div><div class="cell-2">{{ $speaker->home_cell_no }}</div>
      <div class="cell-2 label">Fax:</div><div class="cell-2">{{ $speaker->home_fax_no }}</div>
    </div>
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

  {{-- Training / Seminar Experience --}}
  <div class="section">
    <div class="label">Training/Seminar Experience</div>
    <table>
      <tr><th>Title</th><th>Venue</th><th>Date</th><th>Hours</th><th>Remarks</th></tr>
      @foreach($speaker->trainings as $t)
        <tr>
          <td>{{ $t->rt_title }}</td>
          <td>{{ $t->rt_venue }}</td>
          <td>{{ $t->rt_date }}</td>
          <td>{{ $t->rt_no_hours }}</td>
          <td>&nbsp;</td>
        </tr>
      @endforeach
    </table>
  </div>

  {{-- Training as Trainer --}}
  <div class="section">
    <div class="label">Training Experience as Trainer</div>
    <table>
      <tr><th>Title</th><th>Venue</th><th>Date</th><th>Hours</th><th>Remarks</th></tr>
      @foreach($speaker->experienceTrainer as $et)
        <tr>
          <td>{{ $et->rst_title }}</td>
          <td>{{ $et->rst_venue }}</td>
          <td>{{ $et->rst_date }}</td>
          <td>{{ $et->rst_no_hours }}</td>
          <td>&nbsp;</td>
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

  {{-- Publications --}}
  <div class="section">
    <div class="label">Publications</div>
    <table>
      <tr><th>Title</th><th>Publisher</th><th>Date</th><th>Venue</th></tr>
      @foreach($speaker->publications as $p)
        <tr>
          <td>{{ $p->p_title }}</td>
          <td>{{ $p->p_publisher }}</td>
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

@endsection
