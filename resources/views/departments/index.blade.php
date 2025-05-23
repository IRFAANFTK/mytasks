@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">
                    Départements
                </div>

                <div class="card-body">
                    @can('create department')
                        <a href="{{ route('departments.create') }}" class="btn btn-success btn-sm my-2">
                            <i class="bi bi-plus-circle"></i> Ajouter un département
                        </a>
                    @endcan

                    <table class="table table-bordered" id="departmentTable">
                        <thead class="{{ session('dark_mode') ? 'table-secondary' : 'table-light' }}">
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($departments as $department)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $department->name }}</td>
                                <td>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>

                                        @can('update department')
                                            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>
                                        @endcan

                                        @can('delete department')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Voulez-vous supprimer ce département ?');">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <span class="text-danger">
                                        <strong>Aucun département trouvé !</strong>
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#departmentTable').DataTable({
                order: [[1, 'asc']],
                language: {
                    searchPlaceholder: "Rechercher un département",
                    search: ""
                }
            });
        });
    </script>

@endsection
