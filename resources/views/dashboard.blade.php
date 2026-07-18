<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Service Board — Daily Tracker</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap');

  :root{
    --ink:#211f1c;
    --paper:#f6f1e7;
    --board:#221f1d;
    --board-soft:#2c2925;
    --copper:#a8471f;
    --copper-bright:#c8592b;
    --brass:#c9a44c;
    --herb:#3f6653;
    --line:#43403b;
    --line-light:#d9d0bd;
    --muted:#8a8478;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    background:var(--board);
    color:var(--paper);
    font-family:'Work Sans', sans-serif;
    -webkit-font-smoothing:antialiased;
  }
  .wrap{
    max-width:980px;
    margin:0 auto;
    padding:28px 20px 60px;
  }

  /* ---------- Header / receipt strip ---------- */
  .receipt{
    background:var(--paper);
    color:var(--ink);
    border-radius:2px;
    padding:26px 30px 22px;
    position:relative;
    box-shadow:0 18px 40px -20px rgba(0,0,0,.6);
  }
  .receipt::before, .receipt::after{
    content:"";
    position:absolute;
    left:0; right:0; height:10px;
    background:
      linear-gradient(135deg, var(--paper) 50%, transparent 50%) 0 0/14px 14px repeat-x,
      linear-gradient(-135deg, var(--paper) 50%, transparent 50%) 0 0/14px 14px repeat-x;
    background-color:var(--board);
  }
  .receipt::before{ top:-9px; }
  .receipt::after{ bottom:-9px; transform:rotate(180deg); }

  .eyebrow{
    font-family:'IBM Plex Mono', monospace;
    font-size:11px;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:var(--copper);
    display:flex;
    justify-content:space-between;
  }
  h1{
    font-family:'Fraunces', serif;
    font-weight:700;
    font-size:clamp(28px, 4vw, 40px);
    margin:6px 0 2px;
    letter-spacing:-.01em;
  }
  .sub{
    font-size:13px;
    color:var(--muted);
    margin-bottom:18px;
  }
  .stat-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:0;
    border-top:1px dashed var(--line-light);
    padding-top:16px;
  }
  .stat{
    padding-right:14px;
    border-right:1px dashed var(--line-light);
  }
  .stat:last-child{ border-right:none; }
  .stat .num{
    font-family:'IBM Plex Mono', monospace;
    font-size:22px;
    font-weight:600;
  }
  .stat .lbl{
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--muted);
    margin-top:2px;
  }

  /* ---------- Panels ---------- */
  .panel{
    background:var(--board-soft);
    border:1px solid var(--line);
    border-radius:2px;
    margin-top:22px;
    padding:22px 24px 24px;
  }
  .panel h2{
    font-family:'Fraunces', serif;
    font-size:19px;
    font-weight:600;
    margin:0 0 4px;
    display:flex;
    align-items:center;
    gap:10px;
  }
  .panel h2 .tag{
    font-family:'IBM Plex Mono', monospace;
    font-size:10px;
    letter-spacing:.1em;
    text-transform:uppercase;
    color:var(--brass);
    border:1px solid var(--brass);
    border-radius:20px;
    padding:2px 8px;
  }
  .panel .desc{ font-size:12.5px; color:var(--muted); margin-bottom:16px; }

  /* ---------- Entry form ---------- */
  .form-grid{
    display:grid;
    grid-template-columns:1.1fr 1fr 1fr 1fr auto;
    gap:12px;
    align-items:end;
  }
  label{
    display:block;
    font-family:'IBM Plex Mono', monospace;
    font-size:10.5px;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--muted);
    margin-bottom:6px;
  }
  input{
    width:100%;
    background:var(--board);
    border:1px solid var(--line);
    color:var(--paper);
    padding:10px 10px;
    border-radius:2px;
    font-family:'Work Sans', sans-serif;
    font-size:14px;
  }
  input:focus{ outline:none; border-color:var(--copper-bright); }
  input[type=date]{ font-family:'IBM Plex Mono', monospace; font-size:13px; }
  button{
    font-family:'IBM Plex Mono', monospace;
    text-transform:uppercase;
    letter-spacing:.06em;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    border-radius:2px;
    border:none;
    transition:transform .12s ease, opacity .12s ease;
  }
  button:active{ transform:scale(.97); }
  .btn-primary{
    background:var(--copper);
    color:#fff2e9;
    padding:11px 18px;
  }
  .btn-primary:hover{ background:var(--copper-bright); }
  .btn-primary:disabled{ opacity:.6; cursor:default; }
  .form-msg{
    font-family:'IBM Plex Mono', monospace;
    font-size:11.5px;
    color:var(--herb);
    height:16px;
    margin-top:10px;
  }

  /* ---------- Chart ---------- */
  .metric-tabs{ display:flex; gap:6px; margin-bottom:16px; }
  .metric-tabs button{
    background:transparent;
    border:1px solid var(--line);
    color:var(--muted);
    padding:7px 14px;
  }
  .metric-tabs button.active{
    border-color:var(--copper-bright);
    color:var(--paper);
    background:rgba(168,71,31,.18);
  }
  .chart-scroll{ overflow-x:auto; padding-bottom:6px; }
  .chart{ min-width:100%; }
  .empty{
    text-align:center;
    color:var(--muted);
    font-size:13px;
    padding:40px 10px;
    border:1px dashed var(--line);
    border-radius:2px;
  }

  /* ---------- Log table ---------- */
  table{ width:100%; border-collapse:collapse; font-size:13px; }
  th{
    text-align:left;
    font-family:'IBM Plex Mono', monospace;
    font-size:10.5px;
    text-transform:uppercase;
    letter-spacing:.07em;
    color:var(--muted);
    font-weight:500;
    padding:8px 10px;
    border-bottom:1px solid var(--line);
  }
  td{
    padding:9px 10px;
    border-bottom:1px solid var(--line);
    font-family:'IBM Plex Mono', monospace;
  }
  tr:hover td{ background:rgba(255,255,255,.02); }
  .del{
    background:transparent;
    color:var(--muted);
    border:1px solid var(--line);
    padding:5px 9px;
    font-size:10.5px;
  }
  .del:hover{ color:var(--copper-bright); border-color:var(--copper-bright); }

  footer{
    text-align:center;
    color:var(--muted);
    font-size:11px;
    margin-top:24px;
    font-family:'IBM Plex Mono', monospace;
  }

  @media (max-width:720px){
    .stat-row{ grid-template-columns:repeat(2,1fr); row-gap:14px; }
    .stat:nth-child(2){ border-right:none; }
    .form-grid{ grid-template-columns:1fr 1fr; }
  }
</style>
</head>
<body>
<div class="wrap">

  <div class="receipt">
    <div class="eyebrow"><span>Service Board</span><span id="todayLabel">—</span></div>
    <h1>Daily Performance Ledger</h1>
    <div class="sub">Log covers, orders and revenue after service to keep the rail current.</div>
    <div class="stat-row">
      <div class="stat"><div class="num" id="statRevenue">$0</div><div class="lbl">Today's revenue</div></div>
      <div class="stat"><div class="num" id="statOrders">0</div><div class="lbl">Orders</div></div>
      <div class="stat"><div class="num" id="statCovers">0</div><div class="lbl">Covers</div></div>
      <div class="stat"><div class="num" id="statAvg">$0</div><div class="lbl">Avg ticket</div></div>
    </div>
  </div>

  <div class="panel">
    <h2>Log a day <span class="tag">Entry</span></h2>
    <div class="desc">One entry per date — saving again on the same day overwrites it.</div>
    <div class="form-grid">
      <div>
        <label>Date</label>
        <input type="date" id="inDate">
      </div>
      <div>
        <label>Revenue ($)</label>
        <input type="number" id="inRevenue" min="0" step="0.01" placeholder="0.00">
      </div>
      <div>
        <label>Orders</label>
        <input type="number" id="inOrders" min="0" step="1" placeholder="0">
      </div>
      <div>
        <label>Covers</label>
        <input type="number" id="inCovers" min="0" step="1" placeholder="0">
      </div>
      <button class="btn-primary" id="saveBtn">Save entry</button>
    </div>
    <div class="form-msg" id="formMsg"></div>
  </div>

  <div class="panel">
    <h2>The rail <span class="tag">Last 14 days</span></h2>
    <div class="desc">Bars show each logged day. Switch metric to compare revenue, orders or covers.</div>
    <div class="metric-tabs">
      <button class="active" data-metric="revenue">Revenue</button>
      <button data-metric="orders">Orders</button>
      <button data-metric="covers">Covers</button>
    </div>
    <div class="chart-scroll"><div id="chartHolder"></div></div>
  </div>

  <div class="panel">
    <h2>Log book <span class="tag" id="countTag">0 entries</span></h2>
    <div class="desc">All entries, most recent first.</div>
    <div id="tableHolder"></div>
  </div>

  <footer>Signed in as {{ auth()->user()->name ?? 'Guest' }} · data is private to your account.</footer>
</div>

<script>
const $ = (id) => document.getElementById(id);
const money = (n) => '$' + Number(n||0).toLocaleString(undefined,{maximumFractionDigits:0});
const todayStr = () => new Date().toISOString().slice(0,10);
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let entries = {}; // date -> {revenue, orders, covers}
let metric = 'revenue';

function fmtDateLabel(d){
  const dt = new Date(d + 'T00:00:00');
  return dt.toLocaleDateString(undefined,{month:'short', day:'numeric'});
}

async function loadAll(){
  try{
    const res = await fetch("{{ route('dashboard.entries') }}", {
      headers: { 'Accept': 'application/json' }
    });
    if(!res.ok) throw new Error('Failed to load entries');
    const rows = await res.json();
    entries = {};
    rows.forEach(r => {
      entries[r.date] = {
        revenue: Number(r.revenue),
        orders: Number(r.orders),
        covers: Number(r.covers)
      };
    });
  }catch(e){
    console.error('load error', e);
  }
  render();
}

async function saveEntry(date, data){
  const res = await fetch("{{ route('dashboard.entries.store') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ date, ...data })
  });
  if(!res.ok) throw new Error('Failed to save entry');
  entries[date] = data;
  render();
}

async function deleteEntry(date){
  const res = await fetch("{{ url('/dashboard/entries') }}/" + date, {
    method: 'DELETE',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    }
  });
  if(!res.ok) throw new Error('Failed to delete entry');
  delete entries[date];
  render();
}

function renderStats(){
  const t = entries[todayStr()];
  $('todayLabel').textContent = new Date().toLocaleDateString(undefined,{weekday:'long', month:'long', day:'numeric'});
  $('statRevenue').textContent = money(t ? t.revenue : 0);
  $('statOrders').textContent = t ? t.orders : 0;
  $('statCovers').textContent = t ? t.covers : 0;
  const avg = t && t.orders ? (t.revenue / t.orders) : 0;
  $('statAvg').textContent = money(avg);
}

function renderChart(){
  const holder = $('chartHolder');
  const dates = Object.keys(entries).sort().slice(-14);
  if(dates.length === 0){
    holder.innerHTML = '<div class="empty">No entries yet — log your first day above to start the rail.</div>';
    return;
  }
  const vals = dates.map(d => Number(entries[d][metric] || 0));
  const max = Math.max(...vals, 1);
  const barW = 46, gap = 18, leftPad = 10, topPad = 20, bottomPad = 46;
  const chartH = 220;
  const w = leftPad*2 + dates.length*(barW+gap) - gap;
  const h = topPad + chartH + bottomPad;

  const fmtVal = (v) => metric === 'revenue' ? money(v) : v.toLocaleString();

  let bars = '';
  dates.forEach((d,i)=>{
    const v = vals[i];
    const bh = Math.max(4, (v/max) * chartH);
    const x = leftPad + i*(barW+gap);
    const y = topPad + (chartH - bh);
    const isToday = d === todayStr();
    bars += `
      <g>
        <rect x="${x}" y="${topPad}" width="${barW}" height="${chartH}" fill="transparent"/>
        <rect x="${x}" y="${y}" width="${barW}" height="${bh}" rx="3"
          fill="${isToday ? 'url(#gradBright)' : 'url(#gradCopper)'}" stroke="#0000" >
          <title>${fmtDateLabel(d)}: ${fmtVal(v)}</title>
        </rect>
        <text x="${x+barW/2}" y="${y-8}" text-anchor="middle" font-family="IBM Plex Mono, monospace"
          font-size="11" fill="#c9a44c">${fmtVal(v)}</text>
        <text x="${x+barW/2}" y="${topPad+chartH+20}" text-anchor="middle" font-family="IBM Plex Mono, monospace"
          font-size="11" fill="#8a8478">${fmtDateLabel(d)}</text>
      </g>`;
  });

  holder.innerHTML = `
    <svg class="chart" width="${w}" height="${h}" viewBox="0 0 ${w} ${h}">
      <defs>
        <linearGradient id="gradCopper" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#c8592b"/>
          <stop offset="100%" stop-color="#8a3616"/>
        </linearGradient>
        <linearGradient id="gradBright" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#e0a94f"/>
          <stop offset="100%" stop-color="#a8471f"/>
        </linearGradient>
      </defs>
      <line x1="${leftPad-4}" y1="${topPad+chartH}" x2="${w-6}" y2="${topPad+chartH}" stroke="#43403b" stroke-dasharray="3,3"/>
      ${bars}
    </svg>`;
}

function renderTable(){
  const dates = Object.keys(entries).sort().reverse();
  $('countTag').textContent = dates.length + (dates.length === 1 ? ' entry' : ' entries');
  if(dates.length === 0){
    $('tableHolder').innerHTML = '<div class="empty">Nothing logged yet.</div>';
    return;
  }
  let rows = dates.map(d => {
    const e = entries[d];
    const avg = e.orders ? (e.revenue/e.orders) : 0;
    return `<tr>
      <td>${fmtDateLabel(d)}</td>
      <td>${money(e.revenue)}</td>
      <td>${e.orders}</td>
      <td>${e.covers}</td>
      <td>${money(avg)}</td>
      <td><button class="del" data-date="${d}">Remove</button></td>
    </tr>`;
  }).join('');
  $('tableHolder').innerHTML = `
    <table>
      <thead><tr><th>Date</th><th>Revenue</th><th>Orders</th><th>Covers</th><th>Avg ticket</th><th></th></tr></thead>
      <tbody>${rows}</tbody>
    </table>`;
  $('tableHolder').querySelectorAll('.del').forEach(btn=>{
    btn.addEventListener('click', () => {
      if(confirm('Remove entry for ' + fmtDateLabel(btn.dataset.date) + '?')){
        deleteEntry(btn.dataset.date).catch(()=> alert('Could not delete — try again.'));
      }
    });
  });
}

function render(){
  renderStats();
  renderChart();
  renderTable();
}

$('inDate').value = todayStr();

$('saveBtn').addEventListener('click', async () => {
  const date = $('inDate').value || todayStr();
  const revenue = parseFloat($('inRevenue').value || '0');
  const orders = parseInt($('inOrders').value || '0', 10);
  const covers = parseInt($('inCovers').value || '0', 10);
  const msg = $('formMsg');
  const btn = $('saveBtn');
  btn.disabled = true;
  try{
    await saveEntry(date, {revenue, orders, covers});
    msg.style.color = 'var(--herb)';
    msg.textContent = `Saved ${fmtDateLabel(date)}.`;
    $('inRevenue').value = ''; $('inOrders').value = ''; $('inCovers').value = '';
    setTimeout(()=>{ if(msg.textContent.startsWith('Saved')) msg.textContent=''; }, 3000);
  }catch(e){
    msg.style.color = '#c8592b';
    msg.textContent = 'Could not save — try again.';
  }finally{
    btn.disabled = false;
  }
});

document.querySelectorAll('.metric-tabs button').forEach(btn=>{
  btn.addEventListener('click', () => {
    document.querySelectorAll('.metric-tabs button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    metric = btn.dataset.metric;
    renderChart();
  });
});

loadAll();
</script>
</body>
</html>