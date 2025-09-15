<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Form</title>
    <style>
        body { font-family: helvetica, sans-serif; font-size: 10pt; }
        .container {
            width: 100%;
            padding: 5px;
        }
        h3, h4 { text-align: center; margin: 5px 0; }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; }
        .no-border td, .no-border th { border: none; }
        .underline { border-bottom: 1px solid #000; display: inline-block; min-width: 200px; }
    </style>
</head>
<body>
<div class="container">
    <h3>APPLICATION FORM FOR THE ACCREDITATION OF</h3>
    <h4>TECHNICAL PERSONNEL / TRAINER / SUBJECT MATTER SPECIALIST</h4>

    {{-- Applicant Info --}}
    <p><strong>Name of Applicant:</strong>
        <span class="underline">{{ $speaker->given_name }} {{ $speaker->middle_name }} {{ $speaker->last_name }} {{ $speaker->ext_name }}</span>
    </p>

    <p><strong>Field of Expertise:</strong>
        <span class="underline">
            {{ $speaker->expertises->pluck('expertis')->implode(', ') ?: 'N/A' }}
        </span>
    </p>

    <p><strong>Office/Organization:</strong>
        <span class="underline">{{ $speaker->office->office_name ?? 'N/A' }}</span>
    </p>

    {{-- Educational Background --}}
    <div class="section-title">Educational Background</div>
    <table>
        <thead>
        <tr>
            <th>Level/Degree</th>
            <th>From Year</th>
            <th>To Year</th>
            <th>School/Institution</th>
            <th>Year Graduated</th>
            <th>Awards</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->educationalBackground as $edu)
            <tr>
                <td>{{ $edu->level }}</td>
                <td>{{ $edu->from_year }}</td>
                <td>{{ $edu->to_year }}</td>
                <td>{{ $edu->school }}</td>
                <td>{{ $edu->year_graduated }}</td>
                <td>{{ $edu->awards }}</td>
            </tr>
        @empty
            <tr><td colspan="6" align="center">No educational background records.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Work Experience --}}
    <div class="section-title">Work Experience</div>
    <table>
        <thead>
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Company/Organization</th>
            <th>Position</th>
            <th>Division/Department</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->workExperiences as $work)
            <tr>
                <td>{{ $work->date_started }}</td>
                <td>{{ $work->date_ended }}</td>
                <td>{{ $work->name_company }}</td>
                <td>{{ $work->position }}</td>
                <td>{{ $work->division }}</td>
            </tr>
        @empty
            <tr><td colspan="5" align="center">No work experience records.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Training / Seminar --}}
    <div class="section-title">Training / Seminar Experience</div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Venue</th>
            <th>Date</th>
            <th>Hours</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->trainings as $training)
            <tr>
                <td>{{ $training->rt_title }}</td>
                <td>{{ $training->rt_venue }}</td>
                <td>{{ $training->rt_date }}</td>
                <td>{{ $training->rt_no_hours }}</td>
                <td>{{ $training->remarks ?? '' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" align="center">No training records.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Trainer Experience --}}
    <div class="section-title">Experience as Trainer</div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Venue</th>
            <th>Date</th>
            <th>Hours</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->experienceTrainer as $exp)
            <tr>
                <td>{{ $exp->rst_title }}</td>
                <td>{{ $exp->rst_venue }}</td>
                <td>{{ $exp->rst_date }}</td>
                <td>{{ $exp->rst_no_hours }}</td>
            </tr>
        @empty
            <tr><td colspan="4" align="center">No trainer experience records.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Publications --}}
    <div class="section-title">Publications</div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Publisher</th>
            <th>Date</th>
            <th>Venue</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->publications as $pub)
            <tr>
                <td>{{ $pub->p_title }}</td>
                <td>{{ $pub->p_publisher }}</td>
                <td>{{ $pub->p_date }}</td>
                <td>{{ $pub->p_venue }}</td>
            </tr>
        @empty
            <tr><td colspan="4" align="center">No publication records.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- References --}}
    <div class="section-title">References</div>
    <table>
        <thead>
        <tr>
            <th>Name/Agency</th>
            <th>Address</th>
            <th>Contact Person</th>
            <th>Position</th>
            <th>Tel No.</th>
            <th>Cell No.</th>
        </tr>
        </thead>
        <tbody>
        @forelse($speaker->referencesTrainings as $ref)
            <tr>
                <td>{{ $ref->name_agency }}</td>
                <td>{{ $ref->address }}</td>
                <td>{{ $ref->contact_person }}</td>
                <td>{{ $ref->position }}</td>
                <td>{{ $ref->tel_no }}</td>
                <td>{{ $ref->cell_no }}</td>
            </tr>
        @empty
            <tr><td colspan="6" align="center">No references records.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
