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
                <div class="card-header {{ session('dark_mode') ? 'bg-dark text-white' : ''}}">
                    Tâches
                </div>
                <div class="card-body">
                    @can('create tasks')
                        <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm my-2">
                            <i class="bi bi-plus-circle"></i>
                            Ajouter une nouvelle tâche
                        </a>
                    @endcan
                            @can('export excel')
                            <a href="{{ route('tasks.export') }}" class="btn btn-success btn-sm ms-2">
                                <i class="bi bi-file-earmark-excel-fill"></i> Exporter des tâches vers Excel
                            </a>
                            @endcan

                            @can('export pdf')
                            <a href="{{ route('tasks.exportPdf') }}" class="btn btn-danger btn-sm ms-2">
                                Télécharger en PDF
                            </a>
                    @endcan

                        <table id="taskTable" class="table table-striped table-bordered {{ session('dark_mode') ? 'table-secondary' : 'table-light' }}">
                            <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Due le</th>
                            <th scope="col">Démarré le</th>
                            <th scope="col">Terminé le</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Créé le</th>
                            <th scope="col">Mis à jour le</th>
                            <th scope="col">Actes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->due_at }}</td>
                                <td>{{ $task->started_at }}</td>
                                <td>{{ $task->ended_at }}</td>
                                <td>{{ $task->user->name ?? 'No User Assigned' }}</td>
                                <td>{{ $task->created_at }}</td>
                                <td>{{ $task->updated_at }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i>Voir
                                        </a>
                                        @can('update tasks')
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>
                                        @endcan
                                        @can('delete tasks')
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this task?')">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        @endcan
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <span class="text-danger"><strong>No Tasks Found</strong></span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- jQuery & DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#taskTable').DataTable({
                order: [[1, 'asc']],
                language: {
                    searchPlaceholder: "Rechercher des tâches..",
                    search: ""
                }
            });
        });
    </script>
@endsection
