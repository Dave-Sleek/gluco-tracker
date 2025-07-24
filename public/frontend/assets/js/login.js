document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  const msg = document.getElementById('loginMsg');
  msg.textContent = 'Logging in...';

  fetch('../backend_control/login.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    msg.textContent = data.message;
    if (data.status === 'success') {
      msg.classList.remove('text-danger');
      msg.classList.add('text-success');
      setTimeout(() => {
        window.location.href = '../public/dashboard.php';
      }, 1000);
    } else {
      msg.classList.remove('text-success');
      msg.classList.add('text-danger');
    }
  });
});

