document.getElementById("generateAllPayslips").addEventListener("click", function() {
    // Call your PHP script via AJAX (replace 'generate_all_payslips.php' with your actual script)
    fetch('generate_all_payslips.php')
        .then(response => response.text())
        .then(data => {
            // Assuming your PHP script returns a success message
            console.log(data); // Check the console for the server response
            
            // Show the dialog overlay
            document.getElementById("dialogOverlay").style.display = "block";
        })
        .catch(error => {
            console.error('Error generating payslips:', error);
        });
});

// Close dialog
document.getElementById("closeDialog").addEventListener("click", function() {
    document.getElementById("dialogOverlay").style.display = "none";
});
