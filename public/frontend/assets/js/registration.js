document.getElementById('registerForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  const msg = document.getElementById('registerMsg');
  msg.textContent = 'Processing...';

  fetch('../backend_control/register.php', {
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
        form.reset();
        var modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        modal.hide();
      }, 2000);
    } else {
      msg.classList.remove('text-success');
      msg.classList.add('text-danger');
    }
  });
});

