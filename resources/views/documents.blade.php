@php
$dorm_name  = "Sanctissimo Rosario Ladies Dormitory";
$admin_name = "Admin User";

$all_documents = [
    ["id"=>1,  "title"=>"SR-Receipt-Feb1926",   "type"=>"Payment Receipt", "tenant"=>"Maria Vera",      "date"=>"Feb 19, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
    ["id"=>2,  "title"=>"SR-MoveOut-Permit",     "type"=>"Permit",          "tenant"=>"Angela Zapanta",  "date"=>"Feb 19, 2026", "category"=>"Permits",          "color"=>"#e8417a"],
    ["id"=>3,  "title"=>"SR-Water-Feb1926",      "type"=>"Payment Receipt", "tenant"=>"Mae Abad",        "date"=>"Feb 19, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
    ["id"=>4,  "title"=>"Water-Feb2026",         "type"=>"Payment Receipt", "tenant"=>"Admin Upload",    "date"=>"Feb 18, 2026", "category"=>"Payment Receipts", "color"=>"#4caf76"],
    ["id"=>5,  "title"=>"Cruz-Rent-Receipt",     "type"=>"Payment Receipt", "tenant"=>"Jane Cruz",       "date"=>"Feb 18, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
    ["id"=>6,  "title"=>"SR-R102-Contract",      "type"=>"Contract",        "tenant"=>"Mikay Andrade",   "date"=>"Feb 18, 2026", "category"=>"Contracts",        "color"=>"#e8417a"],
    ["id"=>7,  "title"=>"SR-WIFI-F3",            "type"=>"Payment Receipt", "tenant"=>"Admin Upload",    "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
    ["id"=>8,  "title"=>"Manahan-Rent-Receipt",  "type"=>"Payment Receipt", "tenant"=>"Kay Manahan",     "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"#f59e0b"],
    ["id"=>9,  "title"=>"DelaCruz-Rent-Receipt", "type"=>"Payment Receipt", "tenant"=>"Jenna Dela Cruz", "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"#f59e0b"],
    ["id"=>10, "title"=>"SR-Clearance-Feb2026",  "type"=>"Clearance",       "tenant"=>"Bea Santos",      "date"=>"Feb 14, 2026", "category"=>"Clearance",        "color"=>"#e8417a"],
    ["id"=>11, "title"=>"Room205-Contract",      "type"=>"Contract",        "tenant"=>"Lea Reyes",       "date"=>"Feb 13, 2026", "category"=>"Contracts",        "color"=>"#e8417a"],
    ["id"=>12, "title"=>"PolicyDoc-HouseRules",  "type"=>"Policy Document", "tenant"=>"Admin Upload",    "date"=>"Feb 10, 2026", "category"=>"Policy Documents", "color"=>"#e8417a"],
    ["id"=>13, "title"=>"SR-Clearance-Santos",   "type"=>"Clearance",       "tenant"=>"Ana Santos",      "date"=>"Feb 10, 2026", "category"=>"Clearance",        "color"=>"#e8417a"],
    ["id"=>14, "title"=>"MovIn-Permit-R301",     "type"=>"Permit",          "tenant"=>"Carla Dizon",     "date"=>"Feb 09, 2026", "category"=>"Permits",          "color"=>"#4caf76"],
    ["id"=>15, "title"=>"Reception-PolicyDoc",   "type"=>"Policy Document", "tenant"=>"Admin Upload",    "date"=>"Feb 08, 2026", "category"=>"Policy Documents", "color"=>"#e8417a"],
    ["id"=>16, "title"=>"Lim-Rent-Receipt",      "type"=>"Payment Receipt", "tenant"=>"Grace Lim",       "date"=>"Feb 07, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
    ["id"=>17, "title"=>"R204-Contract-Ramos",   "type"=>"Contract",        "tenant"=>"Maria Ramos",     "date"=>"Feb 06, 2026", "category"=>"Contracts",        "color"=>"#e8417a"],
    ["id"=>18, "title"=>"SR-WaterBill-Jan2026",  "type"=>"Payment Receipt", "tenant"=>"Admin Upload",    "date"=>"Feb 05, 2026", "category"=>"Payment Receipts", "color"=>"#e8417a"],
];

$categories = [
    "All Documents"    => count($all_documents),
    "Clearance"        => count(array_filter($all_documents, fn($d) => $d['category'] === 'Clearance')),
    "Payment Receipts" => count(array_filter($all_documents, fn($d) => $d['category'] === 'Payment Receipts')),
    "Contracts"        => count(array_filter($all_documents, fn($d) => $d['category'] === 'Contracts')),
    "Permits"          => count(array_filter($all_documents, fn($d) => $d['category'] === 'Permits')),
    "Policy Documents" => count(array_filter($all_documents, fn($d) => $d['category'] === 'Policy Documents')),
];

$nav_items = [
    ["icon" => "🏠", "label" => "Dashboard",            "active" => false, "route" => "dashboard"],
    ["icon" => "👥", "label" => "Manage Tenants",       "active" => false, "route" => "tenants"],
    ["icon" => "📄", "label" => "Document Management",  "active" => true,  "route" => "documents"],
    ["icon" => "🚨", "label" => "Emergency Reports",    "active" => false, "route" => "emergency"],
    ["icon" => "🔧", "label" => "Maintenance Requests", "active" => false, "route" => "maintenance"],
    ["icon" => "💧", "label" => "Water Billing",        "active" => false, "route" => "water-billing"],
    ["icon" => "🚪", "label" => "Visitor Logs",         "active" => false, "route" => "visitor-logs"],
    ["icon" => "📢", "label" => "Announcements",        "active" => false, "route" => "announcements"],
    ["icon" => "🧑‍💼", "label" => "Manage Staff",         "active" => false, "route" => "staff"],
    ["icon" => "⚙️", "label" => "Settings",             "active" => false, "route" => "settings"],
];

$doc_types   = ["All", "Payment Receipt", "Permit", "Contract", "Clearance", "Policy Document"];
$per_page    = 9;
$search      = trim(request('search', ''));
$filter_cat  = request('cat', 'All Documents');
$filter_type = request('type', 'All');
$cur_page    = max(1, intval(request('page', 1)));

$filtered = $all_documents;
if ($filter_cat !== 'All Documents') {
    $filtered = array_values(array_filter($filtered, fn($d) => $d['category'] === $filter_cat));
}
if ($filter_type !== 'All') {
    $filtered = array_values(array_filter($filtered, fn($d) => $d['type'] === $filter_type));
}
if ($search !== '') {
    $s = strtolower($search);
    $filtered = array_values(array_filter($filtered, fn($d) =>
        str_contains(strtolower($d['title']), $s) || str_contains(strtolower($d['tenant']), $s)
    ));
}
$total       = count($filtered);
$total_pages = max(1, (int) ceil($total / $per_page));
$cur_page    = min($cur_page, $total_pages);
$paged       = array_slice($filtered, ($cur_page - 1) * $per_page, $per_page);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DormEase — Document Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --pink:       #CA5D86;
  --pink-light: #FFB0CE;
  --pink-soft:  #FF7E86;
  --pink-bg:    #fdf0f5;
  --pink-card:  #fce8f1;
  --gray:       #B5B7C0;
  --gray-light: #E5ECF6;
  --mint:       #A6E7D8;
  --green:      #29BD9B;
  --peach:      #FFD7C7;
  --salmon:     #EB9C7D;
  --blush:      #FFC5C5;
  --red:        #DF0404;
  --white:      #ffffff;
  --ink:        #1a1a2e;
  --ink-muted:  #7a5f6e;
   --pink-50:  #fdf2f6;
  --pink-100: #fce4ec;
  --pink-200: #f8bbd0;
  --pink-300: #f48fb1;
  --pink-400: #f06292;
  --pink-500: #ec407a;
  --pink-600: #d81b60;
  --pink-700: #ad1457;
  --gray:       #B5B7C0;
  --gray-light: #E5ECF6;
  --mint:       #A6E7D8;
  --green:      #29BD9B;
  --peach:      #FFD7C7;
  --salmon:     #EB9C7D;
  --blush:      #FFC5C5;
  --red:        #DF0404;
  --white:      #ffffff;
  --ink:        #1a1a2e;
  --ink-muted:  #7a5f6e;
  --border:     rgba(202,93,134,.12);
  --shadow:     0 2px 16px rgba(202,93,134,.08);
  --shadow-sm:  0 1px 4px rgba(200,60,100,.08);
  --shadow-lg:  0 8px 32px rgba(200,60,100,.18);
  --ff-display: 'DM Serif Display', Georgia, serif;
  --ff-body:    'DM Sans', sans-serif;
  --sidebar-w:  260px;
  --rose-bg:    #fdf0f5;
  --card-bg:    #ffffff;
  --text-dark:  #1a1a2e;
  --text-mid:   #5a4a52;
  --text-soft:  #9b8490;
  --font:       'DM Sans', sans-serif;
  --radius-sm:  10px;
  --radius-md:  16px;
  --radius-lg:  22px;
  --ease:       all .2s cubic-bezier(.4,0,.2,1);
}

*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

html { scroll-behavior: smooth; }

body {
  min-height: 100vh;
  font-family: var(--ff-body);
  background: var(--rose-bg);
  color: var(--text-dark);
  display: flex;
  width: 100%;
  overflow-x: hidden;
}

.main {
  margin-left: var(--sidebar-w);
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

    .sidebar {
      width: var(--sidebar-w);
      background: var(--white);
      display: flex; flex-direction: column;
      position: fixed; top: 0; left: 0; bottom: 0;
      z-index: 100;
      border-right: 1px solid var(--border);
      box-shadow: 2px 0 20px rgba(202,93,134,.06);
      transition: transform .3s ease;
    }

    .sidebar-logo {
      padding: 1.4rem 1.5rem 1rem;
      display: flex; align-items: center; gap: .65rem;
      border-bottom: 1px solid var(--border);
    }
    .sidebar-logo-icon {
      width: 38px; height: 38px; border-radius: 10px;
      background: linear-gradient(135deg, var(--pink) 0%, #a8446c 100%);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; flex-shrink: 0;
    }
    .sidebar-logo-text {
      font-family: var(--ff-display); font-size: 1.3rem;
      font-weight: 700; color: var(--ink); letter-spacing: -.01em;
    }
    .sidebar-logo-text em { font-style: italic; color: var(--pink); }

    .sidebar-role {
      margin: .8rem 1.5rem;
      display: inline-flex; align-items: center; gap: .4rem;
      background: var(--pink-card); border: 1px solid var(--pink-light);
      border-radius: 6px; padding: .28rem .7rem;
      font-size: .72rem; font-weight: 700; color: var(--pink);
      letter-spacing: .06em; text-transform: uppercase;
    }

    .sidebar-nav { flex: 1; padding: .5rem 1rem 1rem; overflow-y: auto; }
    .nav-item {
      display: flex; align-items: center; gap: .75rem;
      padding: .68rem .85rem; border-radius: 10px;
      font-size: .87rem; font-weight: 500; color: var(--ink-muted);
      cursor: pointer; margin-bottom: .15rem;
      transition: background .2s, color .2s;
      border: none; background: none; width: 100%; text-align: left;
      text-decoration: none;
    }
    .nav-item:hover { background: var(--pink-bg); color: var(--pink); }
    .nav-item.active { background: var(--pink-card); color: var(--pink); font-weight: 600; }
    .nav-item.active .nav-icon { color: var(--pink); }
    .nav-icon { font-size: 1.05rem; width: 22px; text-align: center; flex-shrink: 0; }
    .nav-divider { height: 1px; background: var(--border); margin: .6rem 0; }

    .sidebar-logout { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
    .logout-btn {
      display: flex; align-items: center; gap: .65rem;
      font-size: .87rem; font-weight: 500; color: var(--ink-muted);
      background: none; border: none; cursor: pointer;
      padding: .5rem .3rem; width: 100%; transition: color .2s;
    }
    .logout-btn:hover { color: var(--red); }

.main {
  margin-left: var(--sidebar-w);
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* ===== TOPBAR ===== */
.topbar {
  position: sticky;
  top: 0;
  z-index: 50;
  background: var(--white);
  border-bottom: 1px solid var(--border);
  padding: .85rem 2rem;
  display: flex; align-items: center; justify-content: space-between;
}
.breadcrumb { font-size: .8rem; color: var(--ink-muted); }
.breadcrumb span { color: var(--pink); font-weight: 600; }
.topbar-right { display: flex; align-items: center; gap: 1rem; }

.notif-bell {
  width: 36px; height: 36px; border-radius: 50%;
  background: var(--pink-50); border: 1.5px solid var(--pink-100);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 16px; position: relative; transition: var(--ease);
}
.notif-bell:hover { background: var(--pink-100); }
.notif-badge {
  position: absolute; top: -3px; right: -3px;
  width: 16px; height: 16px; background: var(--pink-500);
  border-radius: 50%; font-size: 9px; color: #fff; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #fff;
}
.avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, var(--pink-400), var(--pink-600));
  border: 2px solid var(--pink-200);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 700; color: #fff; cursor: pointer;
}

.content-scroll {
  flex: 1;
  min-height: 0;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 1.8rem 2rem;
}
.content-scroll::-webkit-scrollbar { width: 5px; }
.content-scroll::-webkit-scrollbar-track { background: transparent; }
.content-scroll::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 4px; }

.page-header { margin-bottom: 1.2rem; }
.page-title {

  color: var(--ink);
  letter-spacing: -.02em;
  line-height: 1.15;
  margin-bottom: .2rem;
}
.page-sub { font-size: 1rem; color: var(--pink); font-weight: 600; }

/* ===== FILTER BAR ===== */
.filter-bar {
  display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
  background: var(--card-bg); border: 1.5px solid var(--border);
  border-radius: var(--radius-md); padding: 13px 18px;
  margin-bottom: 20px; box-shadow: var(--shadow-sm);
}
.filter-label { font-size: 13px; font-weight: 600; color: var(--text-mid); white-space: nowrap; }
.filter-select {
  padding: 7px 28px 7px 11px;
  border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  font-size: 13px; font-family: var(--font); color: var(--text-dark);
  background: var(--pink-50); cursor: pointer; outline: none; transition: var(--ease);
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23c72d63' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 9px center;
}
.filter-select:focus { border-color: var(--pink-400); background-color:#fff; box-shadow: 0 0 0 3px rgba(232,65,122,.1); }

.filter-divider { width: 1px; height: 26px; background: var(--border); flex-shrink: 0; }

.date-wrap {
  display: flex; align-items: center; gap: 7px;
  border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  padding: 7px 11px; background: var(--pink-50); transition: var(--ease);
  font-size: 13px; color: var(--text-mid);
}
.date-wrap:focus-within { border-color: var(--pink-400); background: #fff; }
.date-wrap input[type="date"] {
  border: none; background: transparent; font-family: var(--font);
  font-size: 13px; color: var(--text-dark); outline: none; cursor: pointer; width: 108px;
}

.search-wrap {
  flex: 1; min-width: 180px;
  display: flex; align-items: center; gap: 8px;
  border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  padding: 7px 13px; background: var(--pink-50); transition: var(--ease);
}
.search-wrap:focus-within { border-color: var(--pink-400); background: #fff; box-shadow: 0 0 0 3px rgba(232,65,122,.1); }
.search-wrap input { flex:1; border:none; background:transparent; font-family:var(--font); font-size:13px; color:var(--text-dark); outline:none; }
.search-wrap input::placeholder { color: var(--text-soft); }

.doc-layout { display: grid; grid-template-columns: 220px 1fr; gap: 1.5rem; align-items: start; }

.cat-panel {
  background: var(--card-bg); border: 1.5px solid var(--border);
  border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;
}
.cat-item {
  display: flex; align-items: center; justify-content: space-between;
  padding: 12px 16px; cursor: pointer; transition: var(--ease);
  border-bottom: 1px solid var(--pink-50);
  font-size: 13px; font-weight: 500; color: var(--text-mid); text-decoration: none;
}
.cat-item:last-child { border-bottom: none; }
.cat-item:hover { background: var(--pink-50); color: var(--pink-600); }
.cat-item.active {
  background: linear-gradient(135deg, var(--pink-50), #fce4ec);
  color: var(--pink-600); font-weight: 700;
  border-left: 3px solid var(--pink-500);
}
.cat-badge {
  background: var(--pink-500); color: #fff;
  font-size: 10px; font-weight: 700;
  padding: 2px 7px; border-radius: 20px; min-width: 22px; text-align: center;
}
.cat-item.active .cat-badge { background: var(--pink-700); }

.doc-card {
  background: var(--card-bg); border: 1px solid var(--border);
  border-radius: 16px; box-shadow: var(--shadow); overflow: hidden;
}
.doc-card-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 22px; border-bottom: 1.5px solid var(--pink-50);
}
.doc-card-title { font-size: 1rem; font-weight: 700; color: var(--ink); }
.upload-btn {
  display: flex; align-items: center; gap: 7px;
  padding: 8px 18px;
  background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
  color: #fff; border: none; border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 700; cursor: pointer; font-family: var(--font); transition: var(--ease);
}
.upload-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(200,60,100,.3); }

.result-info { font-size: 12px; color: var(--text-soft); padding: 10px 22px 0; }

.doc-table { width: 100%; border-collapse: collapse; }
.doc-table thead tr {
  background: linear-gradient(135deg, var(--pink-50), #fce4ec);
  border-bottom: 1.5px solid var(--pink-100);
}
.doc-table th {
  padding: 12px 16px; text-align: left;
  font-size: 11px; font-weight: 700; color: var(--pink-600);
  letter-spacing: .5px; text-transform: uppercase; white-space: nowrap;
}
.sort { margin-left: 4px; opacity: .5; font-size: 10px; }
.doc-table tbody tr { border-bottom: 1px solid var(--pink-50); transition: var(--ease); }
.doc-table tbody tr:last-child { border-bottom: none; }
.doc-table tbody tr:hover { background: var(--pink-50); }
.doc-table td { padding: 13px 16px; font-size: 13px; color: var(--text-mid); vertical-align: middle; }

.doc-title-cell { display: flex; align-items: center; gap: 10px; }
.doc-dot { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; }
.doc-name { font-weight: 600; color: var(--text-dark); font-size: 13px; }

.action-cell { display: flex; align-items: center; justify-content: center; gap: 6px; }
.action-btn {
  width: 30px; height: 30px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: var(--ease); font-size: 13px;
  border: 1.5px solid var(--border); background: var(--pink-50);
}
.action-btn.view:hover { background: #e8f4ff; border-color: #90cdf4; }
.action-btn.edit:hover { background: #fef9c3; border-color: #fcd34d; }
.action-btn.del:hover  { background: #fee2e2; border-color: #fca5a5; }

.empty-state { text-align: center; padding: 60px 20px; color: var(--text-soft); }
.empty-icon  { font-size: 48px; margin-bottom: 14px; opacity: .4; }
.empty-text  { font-size: 15px; font-weight: 500; }

/* ===== PAGINATION ===== */
.pagination {
  display: flex; align-items: center; justify-content: center;
  gap: 5px; padding: 16px; border-top: 1.5px solid var(--pink-50); flex-wrap: wrap;
}
.page-btn {
  min-width: 34px; height: 34px; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 600;
  border: 1.5px solid var(--border); background: var(--card-bg);
  color: var(--text-mid); transition: var(--ease);
  text-decoration: none; padding: 0 10px; white-space: nowrap;
}
.page-btn:hover:not(.disabled):not(.active) { background: var(--pink-50); border-color: var(--pink-300); color: var(--pink-600); }
.page-btn.active {
  background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
  color: #fff; border-color: var(--pink-500);
  box-shadow: 0 2px 8px rgba(200,60,100,.3);
}
.page-btn.disabled { opacity: .4; pointer-events: none; }
.page-dots { color: var(--text-soft); font-size: 13px; padding: 0 2px; align-self: center; }

.modal-overlay {
  position: fixed; inset: 0;
  background: rgba(26,26,46,.45); backdrop-filter: blur(4px);
  z-index: 100; display: none; align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal {
  background: var(--card-bg); border-radius: var(--radius-lg);
  padding: 30px; width: 92%; max-width: 480px;
  box-shadow: var(--shadow-lg); max-height: 90vh; overflow-y: auto;
  animation: fadeUp .3s ease;
}

.modal-title { font-family: var(--font-display); font-size: 22px; color: var(--text-dark); margin-bottom: 20px; }
.form-group  { margin-bottom: 15px; }
.form-label  { font-size: 13px; font-weight: 600; color: var(--text-mid); margin-bottom: 6px; display: block; }
.form-input, .form-select {
  width: 100%; padding: 10px 14px;
  border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  font-size: 14px; font-family: var(--font); color: var(--text-dark);
  background: var(--pink-50); transition: var(--ease); outline: none;
}
.form-input:focus, .form-select:focus {
  border-color: var(--pink-400); background: #fff; box-shadow: 0 0 0 3px rgba(232,65,122,.1);
}

.file-drop {
  border: 2px dashed var(--pink-200); border-radius: var(--radius-md);
  padding: 26px; text-align: center; cursor: pointer; transition: var(--ease); background: var(--pink-50);
}
.file-drop:hover, .file-drop.dragover { border-color: var(--pink-500); background: #fce4ec; }
.file-drop-icon  { font-size: 30px; margin-bottom: 8px; }
.file-drop-text  { font-size: 13px; color: var(--text-soft); }
.file-drop-text strong { color: var(--pink-600); }
.file-name-preview { margin-top: 8px; font-size: 12px; color: var(--pink-600); font-weight: 600; display: none; }

    .modal-overlay {
      position: fixed; inset: 0; background: rgba(26,26,46,.45);
      backdrop-filter: blur(4px); z-index: 300;
      display: none; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
      background: var(--white); border-radius: 20px;
      padding: 2rem; width: 90%; max-width: 440px;
      box-shadow: 0 20px 60px rgba(26,26,46,.2);
      animation: fadeUp .3s ease;
      max-height: 90vh; overflow-y: auto;
    }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-close:hover { color: var(--red); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.4rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: #a8446c; }

.doc-preview {
  background: var(--pink-50); border: 1.5px solid var(--border);
  border-radius: var(--radius-md); padding: 18px; margin-bottom: 16px;
}
.doc-preview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.doc-preview-field label { font-size: 10px; font-weight: 700; color: var(--text-soft); text-transform: uppercase; letter-spacing: .6px; }
.doc-preview-field p { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-top: 3px; }

.main {
  margin-left: var(--sidebar-w);
  width: calc(100% - var(--sidebar-w)); /* ✅ ensures it fills remaining space */
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content-scroll {
  flex: 1;
  min-height: 0;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 1.8rem 2rem;
  width: 100%;
}

.toast {
  position: fixed; bottom: 28px; right: 28px;
  background: linear-gradient(135deg, var(--pink), #a8446c);
  color: #fff; padding: 13px 22px; border-radius: var(--radius-md);
  font-size: 14px; font-weight: 600; box-shadow: var(--shadow-lg);
  z-index: 300; transform: translateY(80px); opacity: 0;
  transition: all .35s cubic-bezier(.4,0,.2,1); pointer-events: none;
}
.toast.show { transform: translateY(0); opacity: 1; }

@keyframes fadeUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
.fade-up { opacity: 0; animation: fadeUp .5s ease forwards; }
.d1 { animation-delay:.05s; } .d2 { animation-delay:.12s; }
.d3 { animation-delay:.19s; } .d4 { animation-delay:.26s; }
.d5 { animation-delay:.33s; } .d6 { animation-delay:.40s; }

@media (max-width: 960px) {
  .doc-layout { grid-template-columns: 1fr; }
  .cat-panel { display: flex; flex-wrap: wrap; }
  .cat-item { border-bottom: none; border-right: 1px solid var(--pink-50); }
}
@media (max-width: 720px) {
  .sidebar { width: 64px; }
  .brand-name,
  .nav-item > span:last-child,
  .admin-badge > span:last-child,
  .logout-btn > span:last-child { display: none; }
  .admin-badge { justify-content: center; }
  .content-scroll { padding: 16px; }
  .doc-table th:nth-child(4), .doc-table td:nth-child(4) { display: none; }
}
</style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon">🏠</div>
    <div class="sidebar-logo-text">Dorm<em>Ease</em></div>
  </div>

  <div class="sidebar-role">👤 Admin</div>

  <nav class="sidebar-nav">
    @foreach ($nav_items as $item)
      @php try { $href = route($item['route']); } catch (\Exception $e) { $href = '#'; } @endphp
      <a class="nav-item {{ $item['active'] ? 'active' : '' }}" href="{{ $href }}">
        <span class="nav-icon">{{ $item['icon'] }}</span>
        <span>{{ $item['label'] }}</span>
      </a>
      @if ($item['label'] === 'Announcements')
        <div class="nav-divider"></div>
      @endif
    @endforeach
  </nav>

  <div class="sidebar-logout">
    <form method="POST" action="/logout" id="logout-form">@csrf</form>
      <button class="logout-btn" onclick="openModal('logout-modal')">      <span>↩</span> Log Out
    </button>
  </div>
</aside>

<div class="modal-overlay" id="logout-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Log Out</div>
      <button class="modal-close" onclick="closeModal('logout-modal')">✕</button>
    </div>
    <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;">Are you sure you want to log out of DormEase?</p>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('logout-modal')">Cancel</button>
<form method="POST" action="/logout" id="logout-form">
  @csrf
</form>
<button class="btn-submit" onclick="document.getElementById('logout-form').submit()" style="background:var(--red);">Log Out</button>    </div>
  </div>
</div>

<div class="main">

  <div class="topbar">
    <div class="breadcrumb">Pages / <span>Document Management</span></div>
    <div class="topbar-right">
      <div class="notif-bell" onclick="showToast('No new notifications')">
        🔔<div class="notif-badge">4</div>
      </div>
      <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
    </div>
  </div>

  <div class="content-scroll">

    <div class="page-header fade-up d1">
      <h1 class="page-title">Document Management</h1>
      <div class="page-sub">{{ $dorm_name }}</div>
    </div>

    <form method="GET" action="{{ route('documents') }}">
      <div class="filter-bar fade-up d2">
        <span class="filter-label">Filter By:</span>
        <select class="filter-select" name="cat" onchange="this.form.submit()">
          @foreach (array_keys($categories) as $cat)
            <option value="{{ $cat }}" {{ $filter_cat === $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>

        <div class="filter-divider"></div>

        <span class="filter-label">Document Type:</span>
        <select class="filter-select" name="type" onchange="this.form.submit()">
          @foreach ($doc_types as $dt)
            <option value="{{ $dt }}" {{ $filter_type === $dt ? 'selected' : '' }}>{{ $dt }}</option>
          @endforeach
        </select>

        <div class="filter-divider"></div>

        <span class="filter-label">From:</span>
        <div class="date-wrap">
          📅 <input type="date" name="from" value="{{ request('from', '2026-02-10') }}" onchange="this.form.submit()">
        </div>
        <span class="filter-label" style="margin:0 -4px">to</span>
        <div class="date-wrap">
          <input type="date" name="to" value="{{ request('to', '2026-02-19') }}" onchange="this.form.submit()">
        </div>

        <div class="search-wrap">
          🔍
          <input type="text" name="search" placeholder="Search by Title or Tenant"
                 value="{{ $search }}" onkeydown="if(event.key==='Enter')this.form.submit()">
        </div>
        <input type="hidden" name="page" value="1">
      </div>
    </form>

    <div class="doc-layout fade-up d3">

      <div class="cat-panel">
        @foreach ($categories as $cat => $count)
          <a class="cat-item {{ $filter_cat === $cat ? 'active' : '' }}"
             href="{{ route('documents', ['cat' => $cat, 'type' => $filter_type, 'search' => $search, 'page' => 1]) }}">
            {{ $cat }}
            <span class="cat-badge">{{ $count }}</span>
          </a>
        @endforeach
      </div>

      <div class="doc-card fade-up d4">
        <div class="doc-card-header">
          <div class="doc-card-title">Documents</div>
          <button type="button" class="upload-btn" onclick="openModal('uploadModal')">
            📤 Upload New Document
          </button>
        </div>

        @if (count($paged) > 0)
          <div class="result-info">
            Showing {{ ($cur_page - 1) * $per_page + 1 }}–{{ min($cur_page * $per_page, $total) }}
            of {{ $total }} document{{ $total !== 1 ? 's' : '' }}
          </div>

          <table class="doc-table">
            <thead>
              <tr>
                <th>Title <span class="sort">↕</span></th>
                <th>Document Type <span class="sort">↕</span></th>
                <th>Tenant Name <span class="sort">↕</span></th>
                <th>Date Posted <span class="sort">↕</span></th>
                <th style="text-align:center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($paged as $doc)
              <tr>
                <td>
                  <div class="doc-title-cell">
                    <div class="doc-dot" style="background:{{ $doc['color'] }}"></div>
                    <span class="doc-name">{{ $doc['title'] }}</span>
                  </div>
                </td>
                <td>{{ $doc['type'] }}</td>
                <td>{{ $doc['tenant'] }}</td>
                <td>{{ $doc['date'] }}</td>
                <td>
                  <div class="action-cell">
                    <div class="action-btn view" title="View"
                         onclick='viewDoc({{ json_encode($doc) }})'>👁</div>
                    <div class="action-btn edit" title="Edit"
                         onclick='editDoc({{ json_encode($doc) }})'>✏️</div>
                    <div class="action-btn del"  title="Delete"
                         onclick="confirmDelete({{ $doc['id'] }}, '{{ addslashes($doc['title']) }}')">🗑</div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          @if ($total_pages > 1)
          <div class="pagination">
            @php
              $base = ['cat' => $filter_cat, 'type' => $filter_type, 'search' => $search];
            @endphp

            <a class="page-btn {{ $cur_page <= 1 ? 'disabled' : '' }}"
               href="{{ route('documents', array_merge($base, ['page' => $cur_page - 1])) }}">‹ Previous</a>

            @php
              $show = [1];
              if ($cur_page > 3) $show[] = '…';
              for ($p = max(2, $cur_page-1); $p <= min($total_pages-1, $cur_page+1); $p++) $show[] = $p;
              if ($cur_page < $total_pages - 2) $show[] = '…';
              if ($total_pages > 1) $show[] = $total_pages;
            @endphp

            @foreach ($show as $p)
              @if ($p === '…')
                <span class="page-dots">…</span>
              @else
                <a class="page-btn {{ $p == $cur_page ? 'active' : '' }}"
                   href="{{ route('documents', array_merge($base, ['page' => $p])) }}">{{ $p }}</a>
              @endif
            @endforeach

            <a class="page-btn {{ $cur_page >= $total_pages ? 'disabled' : '' }}"
               href="{{ route('documents', array_merge($base, ['page' => $cur_page + 1])) }}">Next ›</a>
          </div>
          @endif

        @else
          <div class="empty-state">
            <div class="empty-icon">📂</div>
            <div class="empty-text">No documents match your filters.</div>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>


<div class="modal-overlay" id="uploadModal">
  <div class="modal">
    <div class="modal-title">Upload New Document</div>
    <div class="form-group">
      <label class="form-label">Document Title</label>
      <input class="form-input" id="upTitle" type="text" placeholder="e.g. SR-Receipt-Feb1926">
    </div>
    <div class="form-group">
      <label class="form-label">Document Type</label>
      <select class="form-select" id="upType">
        <option>Payment Receipt</option><option>Permit</option>
        <option>Contract</option><option>Clearance</option><option>Policy Document</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Tenant Name</label>
      <input class="form-input" id="upTenant" type="text" placeholder="e.g. Maria Vera or Admin Upload">
    </div>
    <div class="form-group">
      <label class="form-label">File</label>
      <div class="file-drop" id="fileDrop"
           onclick="document.getElementById('fileInput').click()"
           ondragover="event.preventDefault();this.classList.add('dragover')"
           ondragleave="this.classList.remove('dragover')"
           ondrop="handleDrop(event)">
        <div class="file-drop-icon">📄</div>
        <div class="file-drop-text">Drop file here or <strong>click to browse</strong></div>
        <div class="file-name-preview" id="fileNamePreview"></div>
        <input type="file" id="fileInput" style="display:none"
               onchange="previewFile(this)" accept=".pdf,.doc,.docx,.jpg,.png">
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" type="button" onclick="closeModal('uploadModal')">Cancel</button>
      <button class="btn-primary" type="button" onclick="submitUpload()">Upload</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="viewModal">
  <div class="modal">
    <div class="modal-title">Document Details</div>
    <div class="doc-preview">
      <div class="doc-preview-grid">
        <div class="doc-preview-field"><label>Title</label><p id="vTitle">—</p></div>
        <div class="doc-preview-field"><label>Type</label><p id="vType">—</p></div>
        <div class="doc-preview-field"><label>Tenant</label><p id="vTenant">—</p></div>
        <div class="doc-preview-field"><label>Date Posted</label><p id="vDate">—</p></div>
        <div class="doc-preview-field"><label>Category</label><p id="vCat">—</p></div>
      </div>
    </div>
    <div style="background:var(--pink-50);border:1.5px dashed var(--pink-200);border-radius:var(--radius-md);padding:28px;text-align:center;color:var(--text-soft);font-size:13px;">
      📄 Document preview would appear here in production
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" type="button" onclick="closeModal('viewModal')">Close</button>
      <button class="btn-primary" type="button" onclick="showToast('📥 Downloading...'); closeModal('viewModal')">Download</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-title">Edit Document</div>
    <input type="hidden" id="editId">
    <div class="form-group">
      <label class="form-label">Document Title</label>
      <input class="form-input" id="editTitle" type="text">
    </div>
    <div class="form-group">
      <label class="form-label">Document Type</label>
      <select class="form-select" id="editType">
        <option>Payment Receipt</option><option>Permit</option>
        <option>Contract</option><option>Clearance</option><option>Policy Document</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Tenant Name</label>
      <input class="form-input" id="editTenant" type="text">
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" type="button" onclick="closeModal('editModal')">Cancel</button>
      <button class="btn-primary" type="button" onclick="submitEdit()">Save Changes</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-title">Delete Document</div>
    <p style="font-size:14px;color:var(--text-mid);line-height:1.6;margin-bottom:6px;">
      Are you sure you want to delete <strong id="deleteDocName"></strong>?
      This action cannot be undone.
    </p>
    <input type="hidden" id="deleteId">
    <div class="modal-actions">
      <button class="btn-cancel" type="button" onclick="closeModal('deleteModal')">Cancel</button>
      <button class="btn-danger"  type="button" onclick="submitDelete()">Yes, Delete</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
let _tt;
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(_tt);
  _tt = setTimeout(() => t.classList.remove('show'), 2800);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(o =>
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); })
);

function previewFile(input) {
  if (!input.files[0]) return;
  const p = document.getElementById('fileNamePreview');
  p.textContent = '📎 ' + input.files[0].name;
  p.style.display = 'block';
}
function handleDrop(e) {
  e.preventDefault();
  document.getElementById('fileDrop').classList.remove('dragover');
  const file = e.dataTransfer.files[0];
  if (file) {
    const p = document.getElementById('fileNamePreview');
    p.textContent = '📎 ' + file.name;
    p.style.display = 'block';
  }
}
function submitUpload() {
  if (!document.getElementById('upTitle').value.trim()) {
    showToast('⚠️ Please enter a document title.'); return;
  }
  closeModal('uploadModal');
  showToast('✅ Document uploaded successfully!');
  document.getElementById('upTitle').value  = '';
  document.getElementById('upTenant').value = '';
  document.getElementById('fileNamePreview').style.display = 'none';
}

function viewDoc(doc) {
  document.getElementById('vTitle').textContent  = doc.title;
  document.getElementById('vType').textContent   = doc.type;
  document.getElementById('vTenant').textContent = doc.tenant;
  document.getElementById('vDate').textContent   = doc.date;
  document.getElementById('vCat').textContent    = doc.category;
  openModal('viewModal');
}

function editDoc(doc) {
  document.getElementById('editId').value     = doc.id;
  document.getElementById('editTitle').value  = doc.title;
  document.getElementById('editType').value   = doc.type;
  document.getElementById('editTenant').value = doc.tenant;
  openModal('editModal');
}
function submitEdit() {
  if (!document.getElementById('editTitle').value.trim()) {
    showToast('⚠️ Title cannot be empty.'); return;
  }
  closeModal('editModal');
  showToast('✅ Document updated successfully!');
}

function confirmDelete(id, name) {
  document.getElementById('deleteId').value = id;
  document.getElementById('deleteDocName').textContent = name;
  openModal('deleteModal');
}
function submitDelete() {
  closeModal('deleteModal');
  showToast('🗑️ Document deleted.');
}
</script>
</body>
</html>