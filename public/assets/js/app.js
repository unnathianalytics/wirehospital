
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
//grok date component
const startDateStr = window.financialYearDates.from_date;
const endDateStr = window.financialYearDates.to_date;
const startParts = startDateStr.split('-');
const fyStartYear = parseInt(startParts[0], 10);
const minDate = new Date(fyStartYear, parseInt(startParts[1], 10) - 1, parseInt(startParts[2], 10));
const endParts = endDateStr.split('-');
const fyEndYear = parseInt(endParts[0], 10);
const maxDate = new Date(fyEndYear, parseInt(endParts[1], 10) - 1, parseInt(endParts[2], 10));

const inputs = document.querySelectorAll('.date-component');
inputs.forEach(input => {
    input.addEventListener('keydown', function (e) {
        const pos = this.selectionStart;
        const val = this.value;
        const key = e.key;
        const separators = ['.', '/', '-'];
        if (separators.includes(key)) {
            e.preventDefault();
            const before = val.substring(0, pos);
            const after = val.substring(pos);
            const parts = before.split('-');
            const field = parts.length;
            let currentStr = parts[parts.length - 1];
            if (field === 1 || field === 2) {
                if (currentStr.length > 0) {
                    const newBefore = parts.slice(0, -1).join('-') + (parts.length > 1 ? '-' : '') + currentStr + '-';
                    this.value = newBefore + after;
                    const newPos = newBefore.length;
                    this.selectionStart = this.selectionEnd = newPos;
                }
            }
        } else if (/^\d$/.test(key)) {
            const parts = val.split('-');
            const fieldIndex = val.substring(0, pos).split('-').length - 1;
            const currentField = parts[fieldIndex] || '';
            const maxLen = fieldIndex < 2 ? 2 : 4;
            if (currentField.length >= maxLen && this.selectionStart === this.selectionEnd) {
                e.preventDefault();
            }
        } else {
            const allowed = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Tab', 'Enter'];
            if (!allowed.includes(key)) {
                e.preventDefault();
            }
        }
    });

    input.addEventListener('blur', function () {
        let val = this.value.trim();
        if (!val) return;
        val = val.replace(/[.\/]/g, '-');
        const parts = val.split('-');
        let dayStr, monthStr, yearStr;
        if (parts.length === 2) {
            dayStr = parts[0].padStart(2, '0');
            monthStr = parts[1].padStart(2, '0');
            const month = parseInt(monthStr, 10);
            yearStr = (month >= 4 ? fyStartYear : fyEndYear).toString();
        } else if (parts.length === 3) {
            dayStr = parts[0].padStart(2, '0');
            monthStr = parts[1].padStart(2, '0');
            yearStr = parts[2];
            if (yearStr.length === 2) {
                yearStr = '20' + yearStr;
            } else if (yearStr.length !== 4) {
                this.value = '';
                return;
            }
        } else {
            this.value = '';
            return;
        }
        const day = parseInt(dayStr, 10);
        const month = parseInt(monthStr, 10);
        const year = parseInt(yearStr, 10);
        if (isNaN(day) || isNaN(month) || isNaN(year) || day < 1 || day > 31 || month < 1 || month > 12) {
            this.value = '';
            return;
        }
        let date = new Date(year, month - 1, day);
        if (date.getFullYear() !== year || date.getMonth() !== month - 1 || date.getDate() !== day) {
            this.value = '';
            return;
        }
        if (date < minDate) {
            date = minDate;
        } else if (date > maxDate) {
            date = maxDate;
        }
        const finalDay = String(date.getDate()).padStart(2, '0');
        const finalMonth = String(date.getMonth() + 1).padStart(2, '0');
        const finalYear = date.getFullYear();
        this.value = `${finalDay}-${finalMonth}-${finalYear}`;
        this.dispatchEvent(new Event('input', { bubbles: true })); // Trigger Livewire update on blur
    });

    // Add change event listener to complement blur
    input.addEventListener('change', function () {
        let val = this.value.trim();
        if (val) {
            const parts = val.split('-');
            if (parts.length === 2 || parts.length === 3) {
                let day = parts[0].padStart(2, '0');
                let month = parts[1].padStart(2, '0');
                let year = parts[2] || (parseInt(month) >= 4 ? fyStartYear : fyEndYear).toString();
                if (year.length === 2) year = '20' + year;
                this.value = `${day}-${month}-${year}`;
                this.dispatchEvent(new Event('input', { bubbles: true })); // Trigger Livewire update on change
            }
        }
    });
});
//grok date component
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
