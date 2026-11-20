import { createIcons, icons } from 'lucide';

// Initialize Lucide icons
function refreshIcons() {
    createIcons({ icons });
}

// Real-time Countdown Timer Engine
function initCountdowns() {
    const countdownElements = document.querySelectorAll('[data-countdown]');
    if (!countdownElements.length) return;

    function updateAll() {
        const now = new Date().getTime();

        countdownElements.forEach(el => {
            const targetStr = el.getAttribute('data-countdown');
            const targetTime = new Date(targetStr).getTime();
            const distance = targetTime - now;

            const daysSpan = el.querySelector('.cd-days');
            const hoursSpan = el.querySelector('.cd-hours');
            const minutesSpan = el.querySelector('.cd-minutes');
            const secondsSpan = el.querySelector('.cd-seconds');
            const statusNotice = el.querySelector('.cd-expired-notice');
            const timerContainer = el.querySelector('.cd-timer-grid');

            if (distance <= 0) {
                if (timerContainer) timerContainer.classList.add('hidden');
                if (statusNotice) {
                    statusNotice.classList.remove('hidden');
                } else {
                    el.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">حان موعد الفتح الآن!</span>';
                }
                // Optional: trigger state change or notification
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (daysSpan) daysSpan.textContent = String(days).padStart(2, '0');
            if (hoursSpan) hoursSpan.textContent = String(hours).padStart(2, '0');
            if (minutesSpan) minutesSpan.textContent = String(minutes).padStart(2, '0');
            if (secondsSpan) secondsSpan.textContent = String(seconds).padStart(2, '0');
        });
    }

    updateAll();
    setInterval(updateAll, 1000);
}

// Confirmation Modals handler
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
};

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
};

// Quick Date picker helper for capsule creation
window.setQuickDate = function(monthsToAdd) {
    const dateInput = document.getElementById('open_date');
    if (!dateInput) return;

    const target = new Date();
    target.setMonth(target.getMonth() + monthsToAdd);
    
    const yyyy = target.getFullYear();
    const mm = String(target.getMonth() + 1).padStart(2, '0');
    const dd = String(target.getDate()).padStart(2, '0');

    dateInput.value = `${yyyy}-${mm}-${dd}`;
    
    // Highlight button visually
    document.querySelectorAll('.quick-date-btn').forEach(b => {
        b.classList.remove('border-amber-400', 'bg-amber-400/20', 'text-amber-300');
    });
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('border-amber-400', 'bg-amber-400/20', 'text-amber-300');
    }
};

// Document ready bootstrap
document.addEventListener('DOMContentLoaded', () => {
    refreshIcons();
    initCountdowns();

    // Auto-dismiss alert toasts
    const alertToasts = document.querySelectorAll('.alert-toast');
    alertToasts.forEach(toast => {
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 400);
        }, 5000);
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.app-modal:not(.hidden)').forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.classList.remove('overflow-hidden');
        }
    });
});
