let isClockedIn = false;
let timeIn = '';
let timeOut = '';

document.getElementById('clocking-button').addEventListener('click', function() {
    const button = this;
    const clockStatus = document.getElementById('clock-status');
    const now = new Date();
    const hours = now.getHours();
    const formattedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

    if (!isClockedIn) {
        // Time-In action
        timeIn = formattedTime;
        isClockedIn = true;

        // Determine if early or on time
        const earlyTime = new Date();
        earlyTime.setHours(8, 0, 0); // 8:00 AM
        let statusMessage = `Clocked In at ${timeIn}`;

        if (now < earlyTime) {
            statusMessage += ' - Early';
        } else if (hours >= 17) { // 5:00 PM
            statusMessage += ' - Late';
        }

        // Update button and status
        button.innerHTML = '<i class="fas fa-sign-out-alt"></i> Time-Out';
        clockStatus.innerHTML = statusMessage;
    } else {
        // Time-Out action
        timeOut = formattedTime;
        isClockedIn = false;

        // Determine if overtime
        const overtimeStart = new Date();
        overtimeStart.setHours(17, 1, 0); // 5:01 PM
        let statusMessage = `Clocked In at ${timeIn} and Clocked Out at ${timeOut}`;

        if (now > overtimeStart) {
            statusMessage += ' - Overtime';
        } else if (hours < 8) { // Before 8:00 AM
            statusMessage += ' - Early';
        } else if (hours >= 17) { // 5:00 PM
            statusMessage += ' - Late';
        }

        // Update button and status
        button.innerHTML = '<i class="fas fa-sign-in-alt"></i> Time-In';
        clockStatus.innerHTML = statusMessage;
    }
});

// Cancel button functionality
document.getElementById('cancel-button').addEventListener('click', function() {
    const button = document.getElementById('clocking-button');
    const clockStatus = document.getElementById('clock-status');

    // Reset clocking status
    isClockedIn = false;
    timeIn = '';
    timeOut = '';

    // Update button and status
    button.innerHTML = '<i class="fas fa-sign-in-alt"></i> Time-In';
    clockStatus.innerHTML = 'Clocking status has been reset.';
});


