<!DOCTYPE html>
<html>
<head>
    <title>Liste des tâches</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
<h2>Liste des tâches</h2>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Date de début</th>
        <th>Date de fin</th>
        <th>Responsable</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $i => $task)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $task->name }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->start_date }}</td>
            <td>{{ $task->end_date }}</td>
            <td>{{ $task->assignee->name ?? 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
