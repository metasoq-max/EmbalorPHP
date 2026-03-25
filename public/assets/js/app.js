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
setInterval(updateNotif, 10000);
updateNotif();
