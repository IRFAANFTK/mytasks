import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import axios from 'axios';


const Calendar = () => {
    const [events, setEvents] = useState([]);

    useEffect(() => {
        axios.get('/calendar/events')
            .then(res => {
                console.log(res.data);
                setEvents(res.data);
            })

            .catch(err => console.error(err));
    }, []);

    const handleEventClick = (clickInfo) => {
        clickInfo.jsEvent.preventDefault();
        if (clickInfo.event.url) {
            window.open(clickInfo.event.url, '_blank');
        }
    };

    return (
        <div style={{ maxWidth: 1150, margin: '60px auto' }}>
            <FullCalendar
                plugins={[dayGridPlugin]}
                initialView="dayGridMonth"
                events={events}
                eventColor="#378006"
                eventClick={handleEventClick}
            />
        </div>
    );
};

export default Calendar;
