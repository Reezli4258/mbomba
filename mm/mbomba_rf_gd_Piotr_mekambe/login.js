async function loginWithLicense(licenseKey) {
  const deviceId = window.deviceId;
  const response = await fetch('api/login.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ licenseKey, deviceId }),
  });

  const result = await response.json();

  if (response.ok) {
    alert('✅ Dostęp przyznany');
  } else {
    alert('❌ Błąd: ' + result.message);
  }
}

document.getElementById('loginForm').addEventListener('submit', e => {
  e.preventDefault();
  const licenseKey = document.getElementById('licenseKey').value.trim();
  loginWithLicense(licenseKey);
});


document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('loginForm').addEventListener('submit', e => {
    e.preventDefault();
    const licenseInput = document.getElementById('licenseKey');
    if (!licenseInput) {
      alert('Błąd: nie znaleziono pola licencji!');
      return;
    }

    const licenseKey = licenseInput.value.trim();
    loginWithLicense(licenseKey);
  });
});
