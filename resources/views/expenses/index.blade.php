@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Xərclər</h1>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
        Yeni Xərc Əlavə Et
    </button>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Kateqoriya</th>
                <th>Təsvir</th>
                <th>Məbləğ</th>
                <th>Tarix</th>
                <th>Əməliyyatlar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->category }}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ $expense->amount }} AZN</td>
                <td>{{ $expense->expense_date }}</td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editExpenseModal{{ $expense->id }}">
                        Redaktə Et
                    </button>

                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bu xərcin silinməsinə əminsinizmi?')">Sil</button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="editExpenseModal{{ $expense->id }}" tabindex="-1" aria-labelledby="editExpenseModalLabel{{ $expense->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExpenseModalLabel{{ $expense->id }}">Xərci Redaktə Et</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category{{ $expense->id }}" class="form-label">Kateqoriya</label>
                                    <input type="text" name="category" id="category{{ $expense->id }}" class="form-control" value="{{ $expense->category }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description{{ $expense->id }}" class="form-label">Təsvir</label>
                                    <textarea name="description" id="description{{ $expense->id }}" class="form-control">{{ $expense->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="amount{{ $expense->id }}" class="form-label">Məbləğ</label>
                                    <input type="number" name="amount" id="amount{{ $expense->id }}" class="form-control" step="0.01" value="{{ $expense->amount }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="expense_date{{ $expense->id }}" class="form-label">Tarix</label>
                                    <input type="date" name="expense_date" id="expense_date{{ $expense->id }}" class="form-control" value="{{ $expense->expense_date }}" required>
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
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="createExpenseModal" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createExpenseModalLabel">Yeni Xərc Əlavə Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Kateqoriya</label>
                        <input type="text" name="category" id="category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Təsvir</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Məbləğ</label>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="expense_date" class="form-label">Tarix</label>
                        <input type="date" name="expense_date" id="expense_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                    <button type="submit" class="btn btn-primary">Əlavə Et</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
