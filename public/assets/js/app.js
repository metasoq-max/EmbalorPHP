function updateNotif() {
  const badge = document.getElementById('notif-badge');
  if (!badge) return;
  fetch('index.php?r=notifications.count', {headers: {'X-Requested-With': 'XMLHttpRequest'}})
    .then(r => r.json())
    .then(data => {
      const count = Number(data.count || 0);
      badge.textContent = String(count);
      badge.style.display = count > 0 ? 'inline-flex' : 'none';
      if (count > 0) document.title = `(${count}) رسائل جديدة`;
    })
    .catch(() => {});
}

const menuBtn = document.getElementById('menu-toggle');
const drawer = document.getElementById('mobile-drawer');
const overlay = document.getElementById('drawer-overlay');
const closeDrawer = () => {
  if (drawer) drawer.classList.remove('open');
  if (overlay) overlay.classList.remove('open');
};
if (menuBtn && drawer) {
  menuBtn.addEventListener('click', () => {
    drawer.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open');
  });
}
if (overlay) overlay.addEventListener('click', closeDrawer);
document.querySelectorAll('#mobile-drawer a').forEach((a) => a.addEventListener('click', closeDrawer));
document.addEventListener('click', (e) => {
  if (!drawer || !menuBtn || !drawer.classList.contains('open')) return;
  if (!drawer.contains(e.target) && !menuBtn.contains(e.target)) closeDrawer();
});

function watchChatRealtime() {
  const chatBox = document.getElementById('chat-box');
  if (!chatBox) return;
  const requestId = chatBox.dataset.requestId;
  let lastId = Number(chatBox.dataset.lastMessageId || 0);

  setInterval(() => {
    fetch(`index.php?r=messages.latest_id&id=${requestId}`, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
      .then((r) => r.json())
      .then((data) => {
        const latest = Number(data.latest_id || 0);
        if (latest > lastId) {
          lastId = latest;
          window.location.reload();
        }
      })
      .catch(() => {});
  }, 2000);
}

setInterval(updateNotif, 3000);
updateNotif();
watchChatRealtime();
