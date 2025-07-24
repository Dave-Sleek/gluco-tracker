<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Blood Sugar Analytics</title>
  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* Global */
body.dark-mode {
  background-color: #121212 !important;
  color: #e0e0e0;
}

/* Navbar */
.dark-mode .navbar,
.dark-mode .offcanvas,
.dark-mode .dropdown-menu {
  background-color: #1c1c1c !important;
  color: #ffffff !important;
  border-color: #2c2c2c;
}

/* Cards */
.dark-mode .card,
.dark-mode .modal-content,
.dark-mode .alert {
  background-color: #1e1e1e !important;
  color: #e0e0e0 !important;
  border-color: #333;
}

/* Text */
.dark-mode h1,
.dark-mode h2,
.dark-mode h3,
.dark-mode h4,
.dark-mode h5,
.dark-mode h6,
.dark-mode p,
.dark-mode a,
.dark-mode small,
.dark-mode label {
  color: #e0e0e0 !important;
}

/* Forms */
.dark-mode .form-control,
.dark-mode .form-select,
.dark-mode input,
.dark-mode select,
.dark-mode textarea {
  background-color: #2b2b2b;
  color: #ffffff;
  border-color: #444;
}

/* Buttons */
.dark-mode .btn-primary {
  background-color: #4a90e2;
  border-color: #4a90e2;
}

.dark-mode .btn,
.dark-mode .btn-close {
  color: #ffffff;
}

/* Table */
.dark-mode table,
.dark-mode th,
.dark-mode td {
  background-color: #1e1e1e;
  color: #ffffff;
  border-color: #444;
}

/* Bootstrap Modal Backdrop */
.dark-mode .modal-backdrop {
  background-color: rgba(0, 0, 0, 0.9);
}
</style>
<script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
</head>
