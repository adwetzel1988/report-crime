@extends('layouts.app')

@section('title', 'Report Details')

@section('content')
<div class="container">
    <h1 class="mb-4">Report Details</h1>
    <button id="printButton" class="btn btn-secondary mb-3">Print</button>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Report #{{ $complaint->complaint_number }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Status:</strong> {{ \Illuminate\Support\Str::headline($complaint->status) }}</p>
                    <p class="card-text"><strong>Type:</strong> {{ \Illuminate\Support\Str::headline($complaint->complaint_type) }}</p>
                    @if($complaint->status === 'completed')
                        <p class="card-text"><strong>Closed Date:</strong> {{ $complaint->updated_at }}</p>
                    @endif
                    <p class="card-text"><strong>Created By:</strong> {{ $complaint->user->name ?? 'Anonymous' }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $complaint->user->address ?? '' }}</p>
                    <p class="card-text"><strong>City:</strong> {{ $complaint->user->city ?? '' }}</p>
                    <p class="card-text"><strong>State:</strong> {{ $complaint->user->state ?? '' }}</p>
                    <p class="card-text"><strong>Zip:</strong> {{ $complaint->user->zip ?? '' }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $complaint->description }}</p>
                    <p class="card-text"><strong>Incident Date:</strong> {{ $complaint->incident_date }}</p>
                    @if(!is_null($complaint->city))
                        <p class="card-text"><strong>Incident Location:</strong> {{ $complaint->city->name }}, {{ $complaint->city->state->name }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h6 class="mt-4">Assigned Information</h6>
                    <p class="card-text"><strong>Name:</strong> {{ $complaint->assignedTo->name ?? '' }}</p>
                </div>
            </div>

            <h6 class="mt-5">Attachments</h6>
            @if($complaint->attachments->count() > 0)
                <ul class="list-group mb-3">
                    @foreach($complaint->attachments as $attachment)
                        <li class="list-group-item">
                            <a href="{{ Storage::url($attachment->file_path) }}"
                               target="_blank">{{ $attachment->file_name }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No attachments for this complaint.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">Attachments</h2>
            @if($complaint->attachments->count() > 0)
                <ul class="list-group">
                    @foreach($complaint->attachments as $attachment)
                        <li class="list-group-item">
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No attachments for this complaint.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">Messages</h2>
            @foreach($complaint->messages as $message)
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ $message->sender->name }} - {{ $message->created_at->format('M d, Y H:i') }}</h6>
                        <p class="card-text">{{ $message->content }}</p>
                    </div>
                </div>
            @endforeach

            <form action="{{ route('messages.store', $complaint) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="content" class="form-label">New Message</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // when clicked printButton it will trigger print dialog
    document.getElementById('printButton').addEventListener('click', function() {
        window.print();
    });
  });
</script>
