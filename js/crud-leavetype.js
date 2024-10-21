// Function to confirm delete (already existing)
function confirmDelete(leaveType, leaveId) {
    document.getElementById("leave-type-display").textContent = leaveType;
    document.getElementById("deleteConfirmationDialog").style.display = "flex";

    document.getElementById("confirm-delete-button").onclick = function() {
        // Add your delete logic here, e.g., making an AJAX request to delete the leave type
        window.location.href = `delete-leave-type.php?leave_id=${leaveId}`; // Example delete action
    };

    document.getElementById("cancel-delete-button").onclick = function() {
        document.getElementById("deleteConfirmationDialog").style.display = "none";
    };
}

// Function to open the Create Leave Type Modal
function openCreateLeaveTypeModal() {
    document.getElementById('createLeaveTypeModal').style.display = 'flex';
}

// Function to close the Create Leave Type Modal
function closeModal() {
    document.getElementById('createLeaveTypeModal').style.display = 'none';
}

// Function to open the Edit Credits Modal
function openEditCreditsModal() {
    document.getElementById('editCreditsModal').style.display = 'flex';
}

// Function to close the Edit Credits Modal
function closeCreditsModal() {
    document.getElementById('editCreditsModal').style.display = 'none';
}


// Function to open the Edit Leave Type modal (already existing)
function openEditModal(leaveId, leaveType, allowableCredits) {
    document.getElementById("edit_leave_id").value = leaveId;
    document.getElementById("edit_leave_type").value = leaveType;
    document.getElementById("editLeaveTypeModal").style.display = "flex";
}

// Function to close the Edit modal
function closeEditModal() {
    document.getElementById("editLeaveTypeModal").style.display = "none";
}



// Add an event listener to close modal when clicking outside of it
window.onclick = function(event) {
    const createModal = document.getElementById("createLeaveTypeModal");
    const editModal = document.getElementById("editLeaveTypeModal");
    const deleteDialog = document.getElementById("deleteConfirmationDialog");
    

    if (event.target === createModal) {
        closeModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
    if (event.target === deleteDialog) {
        deleteDialog.style.display = "none";
    }
};


function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("leaveTypeTable");
    const trs = table.getElementsByTagName("tr");

    for (let i = 1; i < trs.length; i++) { // Skip the header row
        const tds = trs[i].getElementsByTagName("td");
        let found = false;
        
        for (let j = 0; j < tds.length; j++) {
            if (tds[j]) {
                const txtValue = tds[j].textContent || tds[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Stop checking if one match is found
                }
            }
        }
        
        trs[i].style.display = found ? "" : "none"; // Show or hide the row
    }
}