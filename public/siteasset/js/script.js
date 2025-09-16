// Calendar functionality
let currentDate = new Date();

function renderCalendar() {
    const monthYear = document.getElementById('current-month');
    const daysContainer = document.getElementById('calendar-days');
    
    if (!monthYear || !daysContainer) return;
    
    // Clear previous calendar
    daysContainer.innerHTML = '';
    
    // Set month and year header
    const months = ["January", "February", "March", "April", "May", "June", 
                   "July", "August", "September", "October", "November", "December"];
    monthYear.textContent = `${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
    
    // Get first day of month and number of days in month
    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
    const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
    
    // Create empty days for first week
    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.classList.add('day', 'empty');
        daysContainer.appendChild(emptyDay);
    }
    
    // Create days for the month
    const today = new Date();
    for (let i = 1; i <= daysInMonth; i++) {
        const day = document.createElement('div');
        day.classList.add('day');
        
        const dayNumber = document.createElement('div');
        dayNumber.classList.add('day-number');
        dayNumber.textContent = i;
        day.appendChild(dayNumber);
        
        // Highlight current day
        if (i === today.getDate() && 
            currentDate.getMonth() === today.getMonth() && 
            currentDate.getFullYear() === today.getFullYear()) {
            day.style.backgroundColor = '#1b998b';
        }
        
        // Add sample events (in a real app, these would come from a database)
        if (i === 15) {
            const event = document.createElement('div');
            event.classList.add('event');
            event.textContent = 'Meeting with team';
            day.appendChild(event);
        }
        
        if (i === 20) {
            const event = document.createElement('div');
            event.classList.add('event');
            event.textContent = 'Project deadline';
            day.appendChild(event);
        }
        
        daysContainer.appendChild(day);
    }
}

function changeMonth(direction) {
    currentDate.setMonth(currentDate.getMonth() + direction);
    renderCalendar();
}

// Function when marking task as done
function markDone(btn) {
    Swal.fire({
        icon: 'success',
        title: 'Good Job!',
        text: 'You have completed the task.',
        showConfirmButton: false,
        timer: 1500
    });
}

// Function when deleting a task
function deleteTask(btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This task will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('.task-card').remove();
            Swal.fire('Deleted!', 'Your task has been deleted.', 'success');
        }
    });
}

// Function for logout
function logout() {
    Swal.fire({
        icon: 'info',
        title: 'Logging Out',
        text: 'You have been logged out successfully.',
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = 'login.html';
    });
}

// Initialize calendar on page load if calendar exists
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('calendar-days')) {
        renderCalendar();
    }
    
    // Set active navigation link
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.html')) {
            link.classList.add('active');
        }
    });
});

function previewImage(event) {
            const preview = document.getElementById('profile-preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(file);
            }
        }
        
        // Update profile function
        function updateProfile() {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile has been updated successfully.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'profile.html';
            });
        }
        