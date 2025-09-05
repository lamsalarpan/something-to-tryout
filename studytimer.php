<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';
?>
  <h3>Study Timer</h3>
  <div class="center-text" style="margin:20px 0">
    <div style="font-size:56px;font-weight:700" id="pomodoro-display">25:00</div>
    <div class="row" style="justify-content:center;margin:10px 0">
      <select id="subject" class="input" style="max-width:240px">
        <option value="General">General</option>
        <option value="Math">Math</option>
        <option value="Science">Science</option>
        <option value="English">English</option>
      </select>
      <select id="minutes" class="input" style="max-width:140px">
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="45">45</option>
        <option value="60">60</option>
      </select>
      <button id="start-btn" class="btn">Start</button>
    </div>
  </div>
  <script type="module">
    import { startPomodoro } from './assets/js/script.js';
    const btn = document.getElementById('start-btn');
    btn.addEventListener('click', ()=>{
      const m = parseInt(document.getElementById('minutes').value,10);
      document.getElementById('pomodoro-display').textContent = String(m).padStart(2,'0')+':00';
      startPomodoro(m);
    });
  </script>
<?php echo $footer_html; ?>
