import React, { useRef } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

import '@fullcalendar/common/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/interaction/main.css';

export default function Calendar() {
    const calendarRef = useRef();

    // Fetch tasks from Laravel controller
    const fetchEvents = async (fetchInfo, successCallback, failureCallback) => {
        try {
            const res = await axios.get('/calendar/events');
            successCallback(res.data);
        } catch (err) {
            failureCallback(err);
        }
    };

    // Handle drag & drop to update task date
    const handleEventDrop = async (info) => {
        try {
            const response = await axios.put(`/calendar/update-date/${info.event.id}`, {
                newDate: info.event.startStr,
            });

            if (!response.data.success) {
                info.revert();
                alert('Erreur lors de la mise à jour de la tâche.');
            }
        } catch (err) {
            info.revert();
            alert('Erreur de communication avec le serveur.');
        }
    };

    return (
        <div id="calendar-wrapper" style={{ maxWidth: '1150px', margin: '60px auto' }}>
            <FullCalendar
                ref={calendarRef}
                plugins={[dayGridPlugin, interactionPlugin]}
                initialView="dayGridMonth"
                editable={true}
                eventColor="#378006"
                events={fetchEvents}
                eventDrop={handleEventDrop}
            />
        </div>
    );
}
