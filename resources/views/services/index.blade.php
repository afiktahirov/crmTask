@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Xidmətlər</h1>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
        Yeni Xidmət Yarat
    </button>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Ad</th>
                <th>Təsvir</th>
                <th>Qiymət</th>
                <th>Interval</th>
                <th>Əməliyyatlar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description }}</td>
                <td>{{ $service->price }} AZN</td>
                <td>{{ ucfirst($service->interval) }}</td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                        Redaktə Et
                    </button>
                    <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalLabel{{ $service->id }}">Xidməti Redaktə Et</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('services.update', $service->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name{{ $service->id }}" class="form-label">Ad</label>
                                            <input type="text" name="name" id="name{{ $service->id }}" class="form-control" value="{{ $service->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description{{ $service->id }}" class="form-label">Təsvir</label>
                                            <textarea name="description" id="description{{ $service->id }}" class="form-control">{{ $service->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price{{ $service->id }}" class="form-label">Qiymət</label>
                                            <input type="number" name="price" id="price{{ $service->id }}" class="form-control" step="0.01" value="{{ $service->price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="interval{{ $service->id }}" class="form-label">Interval</label>
                                            <select name="interval" id="interval{{ $service->id }}" class="form-select" required>
                                                <option value="yearly" {{ $service->interval == 'yearly' ? 'selected' : '' }}>İl</option>
                                                <option value="monthly" {{ $service->interval == 'monthly' ? 'selected' : '' }}>Ay</option>
                                                <option value="weekly" {{ $service->interval == 'weekly' ? 'selected' : '' }}>Həftə</option>
                                                <option value="daily" {{ $service->interval == 'daily' ? 'selected' : '' }}>Gün</option>
                                                <option value="hourly" {{ $service->interval == 'hourly' ? 'selected' : '' }}>Saat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                                        <button type="submit" class="btn btn-success">Yenilə</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bu xidməti silmək istədiyinizə əminsinizmi?')">Sil</button>
                    </form>
                </td>
            </tr>
            @endforeach            
        </tbody>
    </table>
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Yeni Xidmət Yarat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Təsvir</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Qiymət</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="interval" class="form-label">Interval</label>
                        <select name="interval" id="interval" class="form-select" required>
                            <option value="yearly">İl</option>
                            <option value="monthly">Ay</option>
                            <option value="weekly">Həftə</option>
                            <option value="daily" selected>Gün</option>
                            <option value="hourly">Saat</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                    <button type="submit" class="btn btn-success">Əlavə Et</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
