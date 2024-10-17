// script.js
document.addEventListener('DOMContentLoaded', function() {
    const teamCountInput = document.getElementById('team_count');
    const teamNamesContainer = document.getElementById('team-names-container');

    function generateTeamNames() {
        // حذف فیلدهای قبلی نام تیم‌ها
        teamNamesContainer.innerHTML = '';

        // ایجاد فیلدهای جدید نام تیم‌ها
        const teamCount = parseInt(teamCountInput.value);
        if (isNaN(teamCount) || teamCount < 2) return;

        for (let i = 1; i <= teamCount; i++) {
            const label = document.createElement('label');
            label.textContent = 'نام تیم ' + i + ':';
            label.classList.add('team-name');

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'team_names[]';
            input.required = true;
            input.classList.add('team-name');

            teamNamesContainer.appendChild(label);
            teamNamesContainer.appendChild(input);
            teamNamesContainer.appendChild(document.createElement('br'));
        }
    }

    teamCountInput.addEventListener('input', generateTeamNames);
    // فراخوانی تابع برای بارگذاری اولیه
    generateTeamNames();
});
