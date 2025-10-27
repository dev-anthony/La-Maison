<!-- house-details.html (frontend)
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>House Details</title>
  <link rel="stylesheet" href="/Authentication/frontend/css/house-details.css">
</head>
<body>
  <div id="house-details"></div>
  <div id="status-message"></div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const houseId = urlParams.get('id');

    fetch(`/Authentication/backend/get-house-details.php?id=${houseId}`, { credentials: 'include' })
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('house-details');
        if (data.error) {
          container.innerHTML = `<p>${data.error}</p>`;
          return;
        }

        container.innerHTML = `
          <div class="card">
            <div class="img-container">
              <img src="/Authentication/assets/${data.image}" alt="House Image">
            </div>
            <div class="card-content">
              <div class="flex">
                <h2>${data.title}, ${data.location}</h2>
                <p class="price">₦${data.price}</p>
              </div>
              <div class="details">
                <p class="desc"><strong>Features:</strong> ${data.description}</p>
                <p class="landlord"><strong>Landlord:</strong> ${data.admin_name}</p>
              </div>
              <div class="buttons">
                <button id="applyBtn">Apply to Rent</button>
                <button onclick="messageLandlord(${data.admin_id})">Message Landlord</button>
                <button onclick="pay()" id="payBtn" style="display:none">Pay Now</button>
              </div>
            </div>
          </div>
        `;

        // Check application status
        fetch('/Authentication/backend/check-application-status.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ house_id: houseId })
})
.then(res => res.json())
.then(data => {
  const applyBtn = document.getElementById('applyBtn');
  const payBtn = document.getElementById('payBtn');

  if (data.taken && !data.is_owner) {
    applyBtn.style.display = 'none';
    payBtn.style.display = 'none';
    document.getElementById('status-message').innerText = 'House already taken';
  } else if (data.approved && data.is_owner) {
    applyBtn.style.display = 'none';
    payBtn.style.display = 'block'; // show pay button
  } else if (data.applied) {
    applyBtn.style.display = 'none';
    payBtn.style.display = 'none';
    document.getElementById('status-message').innerText = 'Application Pending';
  } else {
    applyBtn.style.display = 'block'; // user can apply
    payBtn.style.display = 'none';
  }
});

        document.getElementById('applyBtn').onclick = () => {
          fetch('/Authentication/backend/apply-to-rent.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ house_id: houseId })
          })
          .then(res => res.text())
          .then(alert);
        };
      });
      function pay(){
        window.location.href = `/Authentication/frontend/html/pay.html?id=${houseId}`;
      }

    function messageLandlord(adminId) {
      fetch('/Authentication/backend/get-anyuser-info.php', { credentials: 'include' })
        .then(res => res.json())
        .then(data => {
          const user_id = data.user_id;
          window.location.href = `/Authentication/frontend/php/user-messages.php?user_id=${user_id}&admin_id=${adminId}`;
        })
        .catch(error => {
          alert('Error fetching user info.');
        });
    }
  </script>
</body>
</html> -->
<?php
require_once '../../config/config.php'; // load $BASE_URL
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>House Details</title>
  <link rel="stylesheet" href="<?= $BASE_URL ?>/frontend/css/house-details.css">
</head>
<body>
  <div id="house-details"></div>
  <div id="status-message"></div>

  <script>
    const BASE_URL = "<?= $BASE_URL ?>";
    const urlParams = new URLSearchParams(window.location.search);
    const houseId = urlParams.get('id');

    fetch(`${BASE_URL}/backend/get-house-details.php?id=${houseId}`, { credentials: 'include' })
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('house-details');
        if (data.error) {
          container.innerHTML = `<p>${data.error}</p>`;
          return;
        }

        container.innerHTML = `
          <div class="card">
            <div class="img-container">
              <img src="${BASE_URL}/assets/${data.image}" alt="House Image">
            </div>
            <div class="card-content">
              <div class="flex">
                <h2>${data.title}, ${data.location}</h2>
                <p class="price">₦${data.price}</p>
              </div>
              <div class="details">
                <p class="desc"><strong>Features:</strong> ${data.description}</p>
                <p class="landlord"><strong>Landlord:</strong> ${data.admin_name}</p>
              </div>
              <div class="buttons">
                <button id="applyBtn">Apply to Rent</button>
                <button onclick="messageLandlord(${data.admin_id})">Message Landlord</button>
                <button onclick="pay()" id="payBtn" style="display:none">Pay Now</button>
              </div>
            </div>
          </div>
        `;

        // Check application status
        fetch(`${BASE_URL}/backend/check-application-status.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ house_id: houseId }),
          credentials: 'include'
        })
        .then(res => res.json())
        .then(data => {
          const applyBtn = document.getElementById('applyBtn');
          const payBtn = document.getElementById('payBtn');

          if (data.taken && !data.is_owner) {
            applyBtn.style.display = 'none';
            payBtn.style.display = 'none';
            document.getElementById('status-message').innerText = 'House already taken';
          } else if (data.approved && data.is_owner) {
            applyBtn.style.display = 'none';
            payBtn.style.display = 'block';
          } else if (data.applied) {
            applyBtn.style.display = 'none';
            payBtn.style.display = 'none';
            document.getElementById('status-message').innerText = 'Application Pending';
          } else {
            applyBtn.style.display = 'block';
            payBtn.style.display = 'none';
          }
        });

        document.getElementById('applyBtn').onclick = () => {
          fetch(`${BASE_URL}/backend/apply-to-rent.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ house_id: houseId })
          })
          .then(res => res.text())
          .then(alert);
        };
      });

    function pay() {
      window.location.href = `${BASE_URL}/frontend/html/pay.html?id=${houseId}`;
    }

    function messageLandlord(adminId) {
      fetch(`${BASE_URL}/backend/get-anyuser-info.php`, { credentials: 'include' })
        .then(res => res.json())
        .then(data => {
          const user_id = data.user_id;
          window.location.href = `${BASE_URL}/frontend/php/user-messages.php?user_id=${user_id}&admin_id=${adminId}`;
        })
        .catch(error => {
          alert('Error fetching user info.');
        });
    }
  </script>
</body>
</html>
