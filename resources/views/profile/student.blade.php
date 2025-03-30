@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">Мой профиль</div>
            <div class="card-body">
                <h5>{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <p>Куратор: {{ $user->curator->name ?? 'Не назначен' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Мои мероприятия</div>
            <div class="card-body">
                @if($events->count())
                    <div class="list-group">
                        @foreach($events as $registration)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6>{{ $registration->event->title }}</h6>
                                    <span class="badge bg-{{ $registration->confirmed ? 'success' : 'warning' }}">
                                        {{ $registration->confirmed ? 'Подтверждено' : 'Ожидает подтверждения' }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    {{ $registration->event->start_time->format('d.m.Y H:i') }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Вы не записаны ни на одно мероприятие</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection