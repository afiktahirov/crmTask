@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($service) ? 'Xidməti Redaktə Et' : 'Yeni Xidmət Yarat' }}</h1>
    <form action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}" method="POST">
        @csrf
        @if(isset($service))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Ad</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $service->name ?? old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Təsvir</label>
            <textarea name="description" id="description" class="form-control">{{ $service->description ?? old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Qiymət</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $service->price ?? old('price') }}" required>
        </div>
        <div class="mb-3">
            <label for="interval" class="form-label">Interval</label>
            <select name="interval" id="interval" class="form-select" required>
                <option value="yearly" {{ (isset($service) && $service->interval == 'yearly') ? 'selected' : '' }}>İl</option>
                <option value="monthly" {{ (isset($service) && $service->interval == 'monthly') ? 'selected' : '' }}>Ay</option>
                <option value="weekly" {{ (isset($service) && $service->interval == 'weekly') ? 'selected' : '' }}>Həftə</option>
                <option value="daily" {{ (isset($service) && $service->interval == 'daily') ? 'selected' : '' }}>Gün</option>
                <option value="hourly" {{ (isset($service) && $service->interval == 'hourly') ? 'selected' : '' }}>Saat</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">{{ isset($service) ? 'Yenilə' : 'Əlavə Et' }}</button>
    </form>
</div>
@endsection
