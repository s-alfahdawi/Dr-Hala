import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',

        // 🔥 1. تحميل الأحداث من لارافيل API
        events: '/api/calendar-followups',

        // 🔥 2. إنشاء زر اليوم المخصص
        customButtons: {
            todayButton: {
                text: 'اليوم 📅',
                click: function() {
                    calendar.today();
                }
            }
        },

        // 🔥 3. تخصيص شريط الأدوات العلوي
        headerToolbar: {
            left: 'prev,next todayButton',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },

        // 🔥 4. فتح رابط المريضة في نافذة جديدة عند النقر
        eventClick: function(info) {
            if (info.event.url) {
                window.open(info.event.url, '_blank');
                info.jsEvent.preventDefault();
            }
        },

        // 🔥 5. تمييز اليوم الحالي بخلفية صفراء
        dayCellDidMount: function (info) {
            const today = new Date();
            if (
                info.date.getFullYear() === today.getFullYear() &&
                info.date.getMonth() === today.getMonth() &&
                info.date.getDate() === today.getDate()
            ) {
                info.el.style.backgroundColor = '#FEF9C3'; // لون خلفية اليوم الحالي
            }
        },
    });

    calendar.render();
});