@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Регистрация</div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">ФИО</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="new-password">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Подтверждение пароля</label>
                        <input id="password-confirm" type="password" class="form-control" 
                               name="password_confirmation" required autocomplete="new-password">
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Роль</label>
                        <select id="role" class="form-select @error('role') is-invalid @enderror" 
                                name="role" required>
                            @foreach($roles as $value => $label)
                                <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            Зарегистрироваться
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection