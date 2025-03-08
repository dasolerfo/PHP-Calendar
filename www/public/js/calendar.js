document.addEventListener("DOMContentLoaded", function () {
    const countrySelect = document.getElementById("country");
    const prevMonthBtn = document.querySelector(".calendar-header span:first-child");
    const nextMonthBtn = document.querySelector(".calendar-header span:last-child");
    const days = document.querySelectorAll(".day"); 

    let currentMonth = new URLSearchParams(window.location.search).get("month") || new Date().getMonth() + 1;
    let currentYear = new URLSearchParams(window.location.search).get("year") || new Date().getFullYear();

    function updateURL() {
        const selectedCountry = countrySelect.value;
        window.location.href = `?month=${currentMonth}&year=${currentYear}&country=${selectedCountry}`;
    }

    countrySelect.addEventListener("change", updateURL);

    prevMonthBtn.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        updateURL();
    });

    nextMonthBtn.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        updateURL();
    });

    days.forEach(day => {
        day.addEventListener("click", function () {
            if (!day.classList.contains("disabled")) { 
                const selectedDay = day.textContent.trim();
                const selectedCountry = countrySelect.value;
                window.location.href = `?day=${selectedDay}&month=${currentMonth}&year=${currentYear}&country=${selectedCountry}`;
            }
        });
    });
});
