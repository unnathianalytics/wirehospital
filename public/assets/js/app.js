
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

// Function to initialize Enter key navigation for focusable inputs
function initializeEnterKeyNavigation() {
    const focusableInputs = document.querySelectorAll('.focusable');
    focusableInputs.forEach((input, index) => {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const nextIndex = index + 1;
                if (nextIndex < focusableInputs.length) {
                    const nextInput = focusableInputs[nextIndex];
                    nextInput.focus();
                }
            }
        });
    });
}

// Initialize Enter key navigation on page load
document.addEventListener('DOMContentLoaded', () => {
    initializeEnterKeyNavigation();
});

function isValidDate(yyyy, mm, dd) {
    const date = new Date(`${yyyy}-${mm}-${dd}`);
    return (
        date.getFullYear() === yyyy &&
        (date.getMonth() + 1) === mm &&
        date.getDate() === dd
    );
}

function isWithinRange(dateStr, minStr, maxStr) {
    const date = new Date(dateStr);
    if (minStr) {
        const min = new Date(minStr);
        if (date < min) return false;
    }
    if (maxStr) {
        const max = new Date(maxStr);
        if (date > max) return false;
    }
    return true;
}

function isValidDate(year, month, day) {
    if (isNaN(year) || isNaN(month) || isNaN(day)) return false;
    if (month < 1 || month > 12) return false;
    const daysInMonth = [31, (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if (day < 1 || day > daysInMonth[month - 1]) return false;
    return true;
}

function isWithinRange(date, min, max) {
    if (!min && !max) return true;
    const dateObj = new Date(date);
    if (min && new Date(min) > dateObj) return false;
    if (max && new Date(max) < dateObj) return false;
    return true;
}

function applyIsoDateMask(input) {
    if (!input || input.dataset.maskAttached === "true") return;
    input.dataset.maskAttached = "true";
    input.addEventListener('input', function () {
        let raw = input.value.replace(/\D/g, '').slice(0, 8);
        let formatted = '';
        if (raw.length >= 4) {
            formatted = raw.slice(0, 4);
            if (raw.length >= 6) {
                formatted += '-' + raw.slice(4, 6);
                if (raw.length >= 8) {
                    formatted += '-' + raw.slice(6, 8);
                    let yyyy = parseInt(raw.slice(0, 4));
                    let mm = parseInt(raw.slice(4, 6));
                    let dd = parseInt(raw.slice(6, 8));
                    let fullDate = `${yyyy}-${String(mm).padStart(2, '0')}-${String(dd).padStart(2, '0')}`;
                    if (!isValidDate(yyyy, mm, dd)) {
                        alert("Invalid date: " + fullDate);
                        input.value = '';
                        return;
                    }
                    const min = window.financialYearDates.start_date;
                    const max = window.financialYearDates.end_date;
                    if (!isWithinRange(fullDate, min, max)) {
                        alert(
                            `Date out of range: ${fullDate}\nAllowed: ${min || 'Any'} to ${max || 'Any'}`
                        );
                        input.value = '';
                        return;
                    }
                } else {
                    formatted += '-' + raw.slice(6);
                }
            } else {
                formatted += '-' + raw.slice(4);
            }
        } else {
            formatted = raw;
        }
        input.value = formatted;
    });
    input.addEventListener('keypress', function (e) {
        if (!/[0-9]/.test(e.key)) e.preventDefault();
    });
}

function initGlobalIsoDateMasking() {
    document.querySelectorAll('input.date-iso').forEach(applyIsoDateMask);
}
document.addEventListener('DOMContentLoaded', initGlobalIsoDateMasking);
document.addEventListener('livewire:load', initGlobalIsoDateMasking);
document.addEventListener('livewire:navigated', initGlobalIsoDateMasking);
if (window.Livewire) {
    Livewire.hook('message.processed', initGlobalIsoDateMasking);
}
document.addEventListener('focusin', function (e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
        e.target.select();
    }
});


// TABLEOPTIONS START
// Initialize sortDirections only if not already defined
if (typeof sortDirections === 'undefined') {
    let sortDirections = []; // Will be initialized based on the number of columns
}

function filterTable() {
    const table = document.getElementById("dataTable");
    if (!table) return; // Exit if table does not exist
    const input = document.getElementById("searchInput");
    if (!input) return; // Exit if search input does not exist
    const value = input.value.toLowerCase();
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let found = false;
        const cells = rows[i].getElementsByTagName("td");
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const text = cell.textContent || cell.innerText;
                if (text.toLowerCase().indexOf(value) > -1) {
                    found = true;
                    break;
                }
            }
        }
        rows[i].style.display = found ? "" : "none";
    }
}

function sortTable(n) {
    const table = document.getElementById("dataTable");
    if (!table) return; // Exit if table does not exist
    let rows = Array.from(table.getElementsByTagName("tr")).slice(1); // Exclude header
    const direction = sortDirections[n] === 1 ? -1 : 1;
    sortDirections = new Array(table.getElementsByTagName("th").length).fill(0); // Reset all directions
    sortDirections[n] = direction === 1 ? 1 : -1;

    rows.sort((a, b) => {
        const aText = a.getElementsByTagName("td")[n].textContent || a.getElementsByTagName("td")[n].innerText;
        const bText = b.getElementsByTagName("td")[n].textContent || b.getElementsByTagName("td")[n].innerText;
        return direction === 1 ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });

    const tbody = table.getElementsByTagName("tbody")[0];
    rows.forEach(row => tbody.appendChild(row));

    const headers = table.getElementsByTagName("th");
    for (let i = 0; i < headers.length; i++) {
        let span = headers[i].querySelector("span");
        if (!span) {
            span = document.createElement("span");
            headers[i].appendChild(span);
        }
        span.textContent = i === n ? (sortDirections[n] === 1 ? " ↑" : " ↓") : "";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("dataTable");
    if (!table) return; // Exit if table does not exist

    const headers = table.getElementsByTagName("th");
    if (typeof sortDirections === 'undefined' || sortDirections.length !== headers.length) {
        sortDirections = new Array(headers.length).fill(0); // Initialize or reset sortDirections
    }

    for (let i = 0; i < headers.length; i++) {
        headers[i].addEventListener("click", function () {
            sortTable(i);
        });
    }

    window.onpageshow = function (event) {
        const input = document.getElementById("searchInput");
        if (input) input.value = "";
        if (table) {
            const rows = table.getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "";
            }
        }
        if (typeof sortDirections === 'undefined' || sortDirections.length !== headers.length) {
            sortDirections = new Array(headers.length).fill(0); // Reset sort directions
        }
        for (let i = 0; i < headers.length; i++) {
            const span = headers[i].querySelector("span");
            if (span) span.textContent = "";
        }
    };
});
// TABLEOPTIONS END

document.addEventListener('livewire:navigated', () => {
    if (window.setTheme && window.getPreferredTheme) {
        window.setTheme(window.getPreferredTheme());
    }
    if (window.showActiveTheme) {
        window.showActiveTheme(window.getPreferredTheme());
    }
});
