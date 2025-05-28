@extends('layouts.app')

@section('title','Calendar')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar with AJAX</title>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.17/index.global.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
    <style>

        body { font-family: Arial, sans-serif; }

        #calendar { max-width: 1150px; margin: 60px auto; }

        .fc .fc-event-title { white-space: normal !important; }

        .fc-event { overflow: visible !important; font-size: 14px; padding: 2px 4px; }
    </style>
</head>
<body>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="calendar"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            eventColor: '#378006',

            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/calendar/events')
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
            },

            eventDrop: function(info) {
                const event = info.event;

                fetch(`/calendar/update-date/${event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        newDate: event.startStr // or event.start.toISOString() if your controller expects full timestamp
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            info.revert();
                            alert('Erreur lors de la mise à jour de la tâche.');
                        }
                    })
                    .catch(() => {
                        info.revert();
                        alert('Erreur de communication avec le serveur.');
                    });
            }
        });

        calendar.render();
    });
</script>

</body>
</html>

@endsection
