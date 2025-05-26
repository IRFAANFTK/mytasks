@section('title','Calendar')
@extends('layouts.app')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar with AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #calendar {
            max-width: 1150px;
            margin: 60px auto;
        }
        a {
            color: black !important;
            text-decoration: none !important;
        }
        .fc .fc-event-title {
            white-space: normal !important;
        }

        .fc-event {
            overflow: visible !important;
            font-size: 14px;
            padding: 2px 4px;
        }
   </style>
</head>
<body>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '/calendar/events',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        successCallback(response);
                    },

                    error: function(xhr) {
                        failureCallback(xhr);
                    }
                });
            },
            eventColor: '#378006',
            themeSystem: 'standard'

        });

        calendar.render();

    });
</script>
@endsection
</body>
</html>





