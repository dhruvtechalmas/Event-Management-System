@extends('backend.layout.main')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem; color: #212529;">Your Notification History Log</span>
            <span class="badge bg-primary px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                {{ auth()->user()->unreadNotifications->count() }} Unread Remaining
            </span>
        </div>
        
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                    <!-- Unread rows will get a light highlight background color -->
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 transitions" 
                         style="{{ !$notification->read() ? 'background-color: #f8fafd; border-left: 4px solid #0d6efd;' : 'background-color: #ffffff;' }}">
                        
                        <div style="max-width: 80%;">
                            <h6 class="mb-1 {{ !$notification->read() ? 'fw-bold text-dark' : 'text-secondary' }}" style="font-size: 0.92rem;">
                                {{ $notification->data['title'] }}
                            </h6>
                            <p class="mb-1 text-muted small" style="line-height: 1.4;">
                                {{ $notification->data['message'] }}
                            </p>
                            <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                <i class="bi bi-clock me-1"></i>{{ $notification->created_at->format('M d, Y @ h:i A') }} ({{ $notification->created_at->diffForHumans() }})
                            </small>
                        </div>
                        
                        <div>
                            @if(!$notification->read())
                                <!-- Quick mark read button action for unread alerts -->
                                <a href="{{ route('notifications.markRead', $notification->id) }}" class="btn btn-sm btn-primary px-3 fw-semibold" style="font-size: 0.75rem; border-radius: 4px;">
                                    Mark as Read
                                </a>
                            @else
                                <span class="badge bg-light text-secondary border px-2.5 py-1.5 font-monospace" style="font-size: 0.65rem; border-radius: 4px;">
                                    READ LOG
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder-x display-4 text-secondary mb-3"></i>
                        <p class="mb-0">Your notification history log is completely empty.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        {{-- <!-- Pagination Links -->
        <div class="card-footer bg-white d-flex justify-content-center border-top py-3">
            {{ $notifications->links() }}
        </div> --}}
    </div>
</div>
@endsection

