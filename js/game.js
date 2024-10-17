// js/game.js

document.addEventListener('DOMContentLoaded', function() {
    const groupSelect = document.getElementById('group');
    const pointsContainer = document.getElementById('points-container');
    const pointsSelect = document.getElementById('points');

    function updatePointsOptions() {
        const selectedGroup = groupSelect.value;

        if (selectedGroup === 'طلایی') {
            // پنهان کردن کادر امتیاز
            pointsContainer.style.display = 'none';

            // افزودن فیلد مخفی با مقدار ۳۰
            let hiddenInput = document.getElementById('hidden-points');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'hidden-points';
                hiddenInput.name = 'points';
                hiddenInput.value = '30';
                pointsContainer.parentNode.insertBefore(hiddenInput, pointsContainer.nextSibling);
            }
        } else {
            // نمایش کادر امتیاز
            pointsContainer.style.display = 'block';

            // حذف فیلد مخفی امتیاز
            const hiddenInput = document.getElementById('hidden-points');
            if (hiddenInput) {
                hiddenInput.parentNode.removeChild(hiddenInput);
            }

            // تنظیم گزینه‌های امتیاز
            pointsSelect.innerHTML = '';
            const pointsOptions = [
                {value: '2', text: '2 امتیازی'},
                {value: '4', text: '4 امتیازی'},
                {value: '6', text: '6 امتیازی'}
            ];

            pointsOptions.forEach(function(optionData) {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;
                pointsSelect.appendChild(option);
            });
        }
    }

    // وقتی گروه تغییر کرد، گزینه‌های امتیاز را به‌روزرسانی می‌کنیم
    groupSelect.addEventListener('change', updatePointsOptions);

    // بارگذاری اولیه گزینه‌های امتیاز
    updatePointsOptions();
});
