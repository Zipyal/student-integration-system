<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title">{{ $event->title }}</h5>
        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
        <p class="card-text">
            <small class="text-muted">
                {{ $event->start_time->format('d.m.Y H:i') }} - 
                {{ $event->end_time->format('H:i') }}
            </small>
        </p>
    </div>
    <div class="card-footer bg-transparent">
        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary">
            Подробнее
        </a>
    </div>
</div>