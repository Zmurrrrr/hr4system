document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('closePopupButton').addEventListener('click', function() {
        document.getElementById('popup').classList.remove('show');
    });
});

