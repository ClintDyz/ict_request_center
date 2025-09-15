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
            <table id="datatablesSimple" class="table table-striped table-bordered">
               <thead>
                    <tr>
                        {{-- <th>Select</th> --}}
                        <th>Speaker Name</th>
                        <th>Field of Expertise</th>
                        <th>Education</th>
                        <th>Work</th>
                        <th>Seminar</th>
                        <th>Experience</th>
                        <th>Award</th>
                        <th>Total</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                            @foreach ($trainers as $trainer)
                        <tr>
                                        {{-- <td><input type="checkbox" class="trainer-checkbox" value="{{ $trainer->id }}"></td> --}}
                                        <td>
                                            <a href="{{ route('resource_speaker.view', $trainer->rstbl_id) }}" style="text-decoration:none">
                                                {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ $trainer->field_of_expertise }}</td>
                                        <td>{{ $trainer->education }}</td>
                                        <td>{{ $trainer->work }}</td>
                                        <td>{{ $trainer->seminar }}</td>
                                        <td>{{ $trainer->experience }}</td>
                                        <td>{{ $trainer->award }}</td>
                                        <td>{{ $trainer->total }}</td>
                        {{-- <td>
                            <a href="{{ route('accreditation.average.print', $trainer->id) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa-solid fa-print"></i></a>
                        </td> --}}
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
