// Small helpers
function postJSON(url, data){
  return fetch(url, {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(data)})
    .then(r => r.json());
}
function qs(s, el=document){return el.querySelector(s)}
function qsa(s, el=document){return [...el.querySelectorAll(s)]}

// Pomodoro
export async function startPomodoro(minutes=25){
  const end = Date.now() + minutes*60*1000;
  const display = qs('#pomodoro-display');
  const startBtn = qs('#start-btn');
  startBtn.disabled = true;
  const tick = setInterval(()=>{
    const left = Math.max(0, end - Date.now());
    const m = String(Math.floor(left/60000)).padStart(2,'0');
    const s = String(Math.floor(left%60000/1000)).padStart(2,'0');
    display.textContent = `${m}:${s}`;
    if(left<=0){
      clearInterval(tick);
      display.textContent = '00:00';
      startBtn.disabled = false;
      if(Notification?.permission === 'granted'){
        new Notification('Study+','Session finished! Take a short break.');
      }
      // Save the session
      fetch('study_log.php',{method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'subject='+(qs('#subject')?.value||'General')+'&minutes='+minutes})
        .then(()=>location.href='analytics.php');
    }
  },250);
}

document.addEventListener('DOMContentLoaded', ()=>{
  if('Notification' in window && Notification.permission !== 'granted'){
    Notification.requestPermission();
  }
});
