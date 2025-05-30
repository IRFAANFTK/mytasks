@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">

@section('title', 'Calendrier')
@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 style="font-weight: bold;">📅 Vue du Calendrier des Tâches</h2>
        </div>
        <div id="calendar"></div>
    </div>
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventColor: '#0d6efd',
                eventTextColor: '#fff',
                eventDisplay: 'block',

                events: function (fetchInfo, successCallback, failureCallback) {
                    fetch('/calendar/events')
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },

                eventDrop: function (info) {
                    const event = info.event;
                    fetch(`/calendar/update-date/${event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            newDate: event.startStr
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                info.revert();
                                alert('❌ Erreur lors de la mise à jour de la tâche.');
                            }
                        })
                        .catch(() => {
                            info.revert();
                            alert('⚠️ Erreur de communication avec le serveur.');
                        });
                }
            });

            calendar.render();
        });
    </script>
@endpush
