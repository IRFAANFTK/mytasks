import React from 'react';
import ReactDOM from 'react-dom/client';
import Calendar from './Calendar.jsx';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

const root = document.getElementById('react-calendar-root');
if (root) {
    ReactDOM.createRoot(root).render(
        <React.StrictMode>
            <Calendar />
        </React.StrictMode>
    );
}
