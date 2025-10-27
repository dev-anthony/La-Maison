<?php
require_once '../../config/config.php'; // base URL config

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="<?= $BASE_URL ?>/frontend/css/admin-dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <style>
    /* Modal and button styles unchanged */
    .modal { display: none; position: fixed; z-index: 3000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
    .modal-content { background: #fff; padding: 20px; width: 400px; max-width: 90%; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); animation: fadeIn 0.3s ease; }
    .modal-content h3 { margin-bottom: 15px; color: #6c63ff; }
    .modal-content label { display: block; margin-top: 10px; font-size: 13px; font-weight: 600; color: #444; }
    .modal-content input, .modal-content textarea { width: 100%; margin-top: 5px; padding: 8px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
    .modal-content button { margin-top: 15px; width: 100%; }
    .close { position: absolute; right: 20px; top: 10px; font-size: 22px; cursor: pointer; color: #666; }
    .close:hover { color: #000; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.9);} to { opacity: 1; transform: scale(1);} }
    .actions { display: flex; justify-content:space-between; align-items:center; gap: 10px; margin-bottom:0; }
    .btn { padding: 6px 12px; font-size: 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s ease-in-out; }
    .edit-btn { background-color: #3f23b1; color: white; }
    .edit-btn:hover { background-color: #5848d3; }
    .delete-btn { background-color: #000; color: white; }
    .delete-btn:hover { background-color: #d9363e; }
    .search-stuff{ display: flex; flex-direction: column; gap: 0.5em; }
    .responsive{ display: flex; justify-content: space-between; align-items: flex-start; width:100%; }
    @media (max-width: 768px){ .responsive{ flex-direction: column; } }
  </style>
</head>
<body>

<div class="dashboard">
  <aside class="sidebar">
    <h2>La Maison <i class="fa-solid fa-house"></i></h2>
    <a href="#" class="nav-link">Dashboard</a>
    <a href="<?= $BASE_URL ?>/frontend/html/properties.html" class="nav-link">Properties</a>
    <a href="<?= $BASE_URL ?>/frontend/html/application.html" class="nav-link">Applications</a>
    <a href="<?= $BASE_URL ?>/frontend/php/admin-inbox.php" class="nav-link">Messages</a>
    <a href="<?= $BASE_URL ?>/frontend/php/add-admin.php" class="nav-link">Add Admin</a>
    <a href="<?= $BASE_URL ?>/backend/logout.php" class="nav-link">Logout</a>
  </aside>

  <div class="main-content">
    <div class="topbar">
      <div class="responsive">
        <h3 id="user"></h3>
        <div class="search-stuff">
          <div class="search-bar">
            <input id="searchInput" type="text" placeholder="Search properties..." />
          </div>
          <button id="search-btn">Search</button>
        </div>
      </div>
      <button id="menubutton"><i class="fa fa-bars"></i></button>
    </div>

    <div class="text">
      <h2>Properties</h2>
      <a href="<?= $BASE_URL ?>/frontend/html/admin-add-house.html">Add Property <i class="fa fa-plus"></i></a>
    </div>

    <div class="house-section">
      <div class="house-list" id="house-list"></div>
    </div>

    <div id="editModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Edit House</h3>
        <form id="editHouseForm">
          <input type="hidden" id="editHouseId">
          <label>Title</label><input type="text" id="editTitle" required>
          <label>Price</label><input type="number" id="editPrice" required>
          <label>Location</label><input type="text" id="editLocation" required>
          <label>Description</label><textarea id="editDescription" rows="3" required></textarea>
          <button type="submit" class="btn edit-btn">Save Changes</button>
        </form>
      </div>
    </div>

  </div>
</div>

<script>
  const BASE_URL = "<?= $BASE_URL ?>";

  fetch(`${BASE_URL}/backend/get-anyuser-info.php`)
    .then(res => res.json())
    .then((data) => {
      document.getElementById('user').innerText = `Welcome ${data.user_name}!`;
    });

  let houseData = [];

  async function fetchHouses() {
    const res = await fetch(`${BASE_URL}/backend/get-houses.php`);
    houseData = await res.json();
    displayHouses(houseData);
  }

  fetchHouses();
  setInterval(fetchHouses, 2000);

  function displayHouses(houses) {
    const container = document.getElementById("house-list");
    container.innerHTML = "";
    if (!houses.length) {
      container.innerHTML = "No houses available at the moment";
      return;
    }
    houses.forEach(house => {
      const card = document.createElement('div');
      card.className = 'house-card';
      card.innerHTML = `
        <div class="image-container">
          <img src="${BASE_URL}/assets/${house.image}" alt="House image">
        </div>
        <div class="card-contents">
          <div class="flex">
            <h3>${house.title}, ${house.location}</h3>
            <span class="price">₦${house.price}</span>
          </div>
          <p class="details">${house.description}</p>
          <div class="actions">
            <button class="btn edit-btn" onclick="editHouse(${house.id})">✏️ Edit</button>
            <button class="btn delete-btn" onclick="deleteHouse(${house.id})">🗑️ Delete</button>
          </div>
        </div>
      `;
      container.appendChild(card);
    });
  }

  function filterHouses() {
    const query = document.getElementById("searchInput").value.toLowerCase();
    const filtered = houseData.filter(h => h.location.toLowerCase().includes(query) ||
                                           h.title.toLowerCase().includes(query) ||
                                           h.price.toString().includes(query));
    displayHouses(filtered);
  }

  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("search-btn").addEventListener("click", filterHouses);
    document.getElementById("searchInput").addEventListener("input", filterHouses);
  });

  const menubtn = document.getElementById("menubutton");
  const sidebar = document.querySelector('.sidebar');
  menubtn.addEventListener('click', () => {
    const icon = menubtn.querySelector("i");
    sidebar.classList.toggle('active');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
  });

  async function deleteHouse(id) {
    if (!confirm("Are you sure you want to delete this house?")) return;
    const res = await fetch(`${BASE_URL}/backend/delete-house.php?id=${id}`);
    const result = await res.json();
    alert(result.message);
    fetchHouses();
  }

  function editHouse(id) {
    const house = houseData.find(h => h.id == id);
    if (!house) return;
    document.getElementById("editHouseId").value = house.id;
    document.getElementById("editTitle").value = house.title;
    document.getElementById("editPrice").value = house.price;
    document.getElementById("editLocation").value = house.location;
    document.getElementById("editDescription").value = house.description;
    document.getElementById("editModal").style.display = "flex";
  }

  function closeModal() {
    document.getElementById("editModal").style.display = "none";
  }

  document.getElementById("editHouseForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append("id", document.getElementById("editHouseId").value);
    formData.append("title", document.getElementById("editTitle").value);
    formData.append("price", document.getElementById("editPrice").value);
    formData.append("location", document.getElementById("editLocation").value);
    formData.append("description", document.getElementById("editDescription").value);

    const res = await fetch(`${BASE_URL}/backend/edit-house.php`, { method: "POST", body: formData });
    const data = await res.json();
    alert(data.message);
    closeModal();
    fetchHouses();
  });

  window.onclick = function(event) {
    const modal = document.getElementById("editModal");
    if (event.target === modal) closeModal();
  }
</script>
</body>
</html>
