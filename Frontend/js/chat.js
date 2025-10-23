
// const params = new URLSearchParams(window.location.search);
// const urlUserId  = params.get('user_id');
// const urlAdminId = params.get('admin_id');

// if (!urlUserId || !urlAdminId) {
//   alert("Unable to determine who you're chatting with.");
//   throw new Error("Missing user_id or admin_id in URL");
// }

// fetch('/Authentication/backend/get-anyuser-info.php')
//   .then(res => res.json())
//   .then(data => {
//     const sender_id   = data.user_id;
//     const sender_type = data.user_type; // 'user' or 'admin'

//     let receiver_id, receiver_type;
//     if (sender_type === 'user') {
//       receiver_id   = urlAdminId;
//       receiver_type = 'admin';
//     } else {
//       receiver_id   = urlUserId;
//       receiver_type = 'user';
//     }

//     document.getElementById('chat-header').innerText = `Chat with: ${receiver_type} ${receiver_id}`;

//     const chatBox = document.getElementById('chat-box');

//     function renderMessageHTML(msg) {
//       const isSender = msg.sender_id == sender_id && msg.sender_type == sender_type;
//       const alignClass = isSender ? 'message-right' : 'message-left';
//       const isRead = isSender && msg.is_read == '1' ? '<span class="read-receipt">✅</span>' : '';
      
//       return `
//         <div class="chat-message ${alignClass}">
//           <div class="bubble">
//             <strong class="head">${msg.sender_type} ${msg.sender_id}</strong><br>
//             <p style="margin-top:20px;">${msg.message || ''}</p>
//             ${msg.file_url ? `<br><img src="${msg.file_url}" style="max-width:100px;" />` : ''}
//             <div class="timestamp">${msg.timestamp} ${isRead}</div>
//           </div>
//         </div>
//       `;
//     }

//     function markMessagesAsRead() {
//       fetch('/Authentication/backend/mark-message-as-seen.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({
//           reader_id: sender_id,
//           reader_type: sender_type,
//           sender_id: receiver_id,
//           sender_type: receiver_type
//         })
//       });
//     }

//     function loadMessages() {
//       fetch(`/Authentication/backend/get-messages.php?user_id=${urlUserId}&admin_id=${urlAdminId}`)
//         .then(res => res.json())
//         .then(data => {
//           chatBox.innerHTML = data.map(renderMessageHTML).join('');
//           chatBox.scrollTop = chatBox.scrollHeight;
//           markMessagesAsRead(); // Mark them as read
//         });
//     }

//     document.getElementById('chat-form').addEventListener('submit', (e) => {
//       e.preventDefault();
//       const message = document.getElementById('message').value.trim();
//       const file = document.getElementById('file').files[0];

//       if (!message && !file) {
//         alert("You can't send an empty message and file together.");
//         return;
//       }

//       const formData = new FormData();
//       formData.append('sender_id', sender_id);
//       formData.append('receiver_id', receiver_id);
//       formData.append('sender_type', sender_type);
//       formData.append('receiver_type', receiver_type);
//       formData.append('message', message);
//       if (file) {
//         formData.append('file', file);
//       }

//       fetch('/Authentication/backend/send-message.php', {
//         method: 'POST',
//         body: formData
//       })
//         .then(res => res.json())
//         .then(data => {
//           if (data.status) {
//             loadMessages();
//             document.getElementById('message').value = '';
//             document.getElementById('file').value = '';
//           } else {
//             alert(data.error || 'Something went wrong');
//           }
//         })
//         .catch(console.error);
//     });

//     loadMessages();
//     setInterval(loadMessages, 2000);
//   });
// ✅ Auto-detect base URL
var BASE_URL = window.location.origin + '/Authentication';
// console.log("Base URL:", BASE_URL);

const params = new URLSearchParams(window.location.search);
const urlUserId  = params.get('user_id');
const urlAdminId = params.get('admin_id');

if (!urlUserId || !urlAdminId) {
  alert("Unable to determine who you're chatting with.");
  throw new Error("Missing user_id or admin_id in URL");
}

fetch(`${BASE_URL}/backend/get-anyuser-info.php`)
  .then(res => res.json())
  .then(data => {
    const sender_id   = data.user_id;
    const sender_type = data.user_type; // 'user' or 'admin'

    let receiver_id, receiver_type;
    if (sender_type === 'user') {
      receiver_id   = urlAdminId;
      receiver_type = 'admin';
    } else {
      receiver_id   = urlUserId;
      receiver_type = 'user';
    }

    document.getElementById('chat-header').innerText = `Chat with: ${receiver_type} ${receiver_id}`;

    const chatBox = document.getElementById('chat-box');

    function renderMessageHTML(msg) {
      const isSender = msg.sender_id == sender_id && msg.sender_type == sender_type;
      const alignClass = isSender ? 'message-right' : 'message-left';
      const isRead = isSender && msg.is_read == '1' ? '<span class="read-receipt">✅</span>' : '';
      
      return `
        <div class="chat-message ${alignClass}">
          <div class="bubble">
            <strong class="head">${msg.sender_type} ${msg.sender_id}</strong><br>
            <p style="margin-top:20px;">${msg.message || ''}</p>
            ${msg.file_url ? `<br><img src="${msg.file_url}" style="max-width:100px;" />` : ''}
            <div class="timestamp">${msg.timestamp} ${isRead}</div>
          </div>
        </div>
      `;
    }

    function markMessagesAsRead() {
      fetch(`${BASE_URL}/backend/mark-message-as-seen.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          reader_id: sender_id,
          reader_type: sender_type,
          sender_id: receiver_id,
          sender_type: receiver_type
        })
      });
    }

    function loadMessages() {
      fetch(`${BASE_URL}/backend/get-messages.php?user_id=${urlUserId}&admin_id=${urlAdminId}`)
        .then(res => res.json())
        .then(data => {
          chatBox.innerHTML = data.map(renderMessageHTML).join('');
          chatBox.scrollTop = chatBox.scrollHeight;
          markMessagesAsRead(); // Mark them as read
        });
    }

    document.getElementById('chat-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const message = document.getElementById('message').value.trim();
      const file = document.getElementById('file').files[0];

      if (!message && !file) {
        alert("You can't send an empty message and file together.");
        return;
      }

      const formData = new FormData();
      formData.append('sender_id', sender_id);
      formData.append('receiver_id', receiver_id);
      formData.append('sender_type', sender_type);
      formData.append('receiver_type', receiver_type);
      formData.append('message', message);
      if (file) {
        formData.append('file', file);
      }

      fetch(`${BASE_URL}/backend/send-message.php`, {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data.status) {
            loadMessages();
            document.getElementById('message').value = '';
            document.getElementById('file').value = '';
          } else {
            alert(data.error || 'Something went wrong');
          }
        })
        .catch(console.error);
    });

    loadMessages();
    setInterval(loadMessages, 2000);
  });
