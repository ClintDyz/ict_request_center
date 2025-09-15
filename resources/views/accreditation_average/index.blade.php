@extends('layouts.admin')

@section('content')

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                 List of Accredited
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Speaker Name</th>
                                <th>Field of Expertise</th>
                                <th>Education</th>
                                <th>Work</th>
                                <th>Seminar</th>
                                <th>Experience</th>
                                <th>Award</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                @foreach($accredited as $trainer)
                    <tr>
                        {{-- Speaker Name --}}
                        <td id="avgSpeaker">
                            <a href="{{ route('resource_speaker.view', optional($trainer->speaker)->id) }}" style="text-decoration:none">
                                {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                            </a>
                        </td>

                            {{-- Field of Expertise (multiple, comma-separated) --}}
                            <td id="avgExpertise">
                                {{ $trainer->speaker->expertises->pluck('expertis')->implode(', ') ?: 'N/A' }}
                            </td>

                        {{-- Other averages --}}
                        <td id="avgEducation">{{ $trainer->avg_education }}</td>
                        <td id="avgWork">{{ $trainer->avg_work }}</td>
                        <td id="avgSeminar">{{ $trainer->avg_seminar }}</td>
                        <td id="avgExperience">{{ $trainer->avg_experience }}</td>
                        <td id="avgAward">{{ $trainer->avg_award }}</td>
                        <td id="avgTotal">{{ $trainer->avg_total }}</td>
                        <td>
                            {{-- <a href="{{ route('accreditation.pdf', $trainer->id) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-print"></i>
                            </a> --}}

                            <a href="{{ route('accreditation.average.print', $trainer->id) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa-solid fa-print"></i></a>

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <div class="card-footer bg-success"></div>
    </div>
</div>


@endsection

@section('scripts')
@endsection
