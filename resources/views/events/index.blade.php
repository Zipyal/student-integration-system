@extends('layouts.app')

@section('title', 'Список мероприятий')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1>@lang('Предстоящие мероприятия')</h1>
    </div>
    @can('create', App\Models\Event::class)
    <div class="col-auto">
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            @lang('Создать мероприятие')
        </a>
    </div>
    @endcan
</div>

<div class="row">
    @foreach($events as $event)
    <div class="col-md-4 mb-4">
        @include('events.partials.card', ['event' => $event])
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $events->links() }}
</div>
@endsection

@section('scripts')
<script>
    // Скрипты для этой страницы
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Events page loaded');
    });
</script>
@endsection