@extends('layouts.admin')

@section('content')

{{-- <style>
    #sidebarToggle, #sidenavAccordion {
        display: none !important;
    }

    #sidenavAccordion, .sibedar {
        margin: 0 !important;
    }

    .lumawa{
        margin-left: 0 !important;
    }

</style> --}}

{{-- <pre>{{ dd($training, $resources) }}</pre> --}}

<!-- Edit Modal -->
    <div class="col-md-12 mt-4 card card-default color-palette-box">
        <div class="card-header">
                <div class="card-title card-info">
                    <strong>Update Request Resource Speaker</strong>
                </div>
                <hr>
                <div class="card-body">
                     <form action="{{ route('request_resource_speaker.update', $request->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Training Title</label>
                                <input type="text" class="form-control" name="training_title" value="{{ $request->training_title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Venue</label>
                                <input type="text" class="form-control" name="venue" value="{{ $request->venue }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" value="{{ $request->date }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. of Hours</label>
                                <input type="number" class="form-control" name="no_hours" value="{{ $request->no_hours }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. of Participants</label>
                                <input type="number" class="form-control" name="no_participants" value="{{ $request->no_participants }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Replace File (optional)</label>
                                <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Speaker</label>
                                <select class="form-control" name="rstbl_id" id="rstbl_id" required>
                                    <option value="">Select Speaker</option>
                                    @foreach ($speakers as $speaker)
                                        <option value="{{ $speaker->id }}" {{ $request->rstbl_id == $speaker->id ? 'selected' : '' }}>
                                            {{ $speaker->given_name }} {{ $speaker->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-control" name="gender" id="gender" value="{{ $request->gender }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Agency</label>
                                <input type="text" class="form-control" name="agency" id="agency" value="{{ $request->agency }}" readonly>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Requesting Division</label>
                                    <select class="form-select" name="division" id="division" required>
                                        <option value="" selected disabled>Select Division</option>
                                        @foreach ($divisions as $id => $name)
                                            <option value="{{ $name }}" {{ old('division', $request->division ?? '') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> --}}
                    <button type="submit" class="btn btn-success">Update Request</button>
                </div>
            </form>
        </div>
    </div>


<script>
    // Inject speakers data into JavaScript
    const speakersData = @json($speakers->mapWithKeys(function ($speaker) {
        return [$speaker->id => [
            'gender' => $speaker->gender,
            'agency' => $speaker->agency
        ]];
    }));

    // Event listener when speaker is changed
    document.getElementById('rstbl_id').addEventListener('change', function () {
        const selectedId = this.value;
        const speaker = speakersData[selectedId];

        if (speaker) {
            document.getElementById('gender').value = speaker.gender ?? '';
            document.getElementById('agency').value = speaker.agency ?? '';
        } else {
            document.getElementById('gender').value = '';
            document.getElementById('agency').value = '';
        }
    });

    // Optional: auto-fill fields on page load
    window.addEventListener('DOMContentLoaded', () => {
        const selectedId = document.getElementById('rstbl_id').value;
        if (speakersData[selectedId]) {
            document.getElementById('gender').value = speakersData[selectedId].gender ?? '';
            document.getElementById('agency').value = speakersData[selectedId].agency ?? '';
        }
    });
</script>



@endsection
