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
                    Utilisateurs
                </div>
                <div class="card-body">
                    @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2">
                            <i class="bi bi-plus-circle"></i> Ajouter un nouvel utilisateur
                        </a>
                    @endcan

                    <table id="usersTable" class="table table-bordered">
                        <thead class="{{ session('dark_mode') ? 'table-secondary' : 'table-light' }}">
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Département</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nb. de tâches</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->department ? $user->department->name : 'Aucun département' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tasks_count }}</td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>

                                        @can('update users')
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>
                                        @endcan

                                        @can('delete users')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <span class="text-danger"><strong>Aucun utilisateur trouvé !</strong></span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#usersTable').DataTable({
                order: [[1, 'asc']],
                language: {
                    searchPlaceholder: "Rechercher un utilisateur",
                    search: ""
                }
            });
        });
    </script>

@endsection
