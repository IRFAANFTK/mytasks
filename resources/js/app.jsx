import React from 'react';
import ReactDOM from 'react-dom/client';
import Calendar from './Calendar';

const root = document.getElementById('react-calendar-root');

if (root) {
    ReactDOM.createRoot(root).render(
        <React.StrictMode>
            <Calendar />
        </React.StrictMode>
    );
} else {
    console.error(' Div react-calendar-root not found!');
}
