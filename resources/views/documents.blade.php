<?php
// ============================================================
// DormEase — Document Management Page
// ============================================================

$dorm_name  = "Sanctissimo Rosario Ladies Dormitory";
$admin_name = "Kyla";

// Simulated document data
$all_documents = [
    ["id"=>1, "title"=>"SR-Receipt-Feb1926",    "type"=>"Payment Receipt", "tenant"=>"Maria Vera",       "date"=>"Feb 19, 2026", "category"=>"Payment Receipts", "color"=>"red"],
    ["id"=>2, "title"=>"SR-MoveOut-Permit",      "type"=>"Permit",          "tenant"=>"Angela Zapanta",   "date"=>"Feb 19, 2026", "category"=>"Permits",          "color"=>"red"],
    ["id"=>3, "title"=>"SR-Water-Feb1926",       "type"=>"Payment Receipt", "tenant"=>"Mae Abad",         "date"=>"Feb 19, 2026", "category"=>"Payment Receipts", "color"=>"red"],
    ["id"=>4, "title"=>"Water-Feb2026",          "type"=>"Payment Receipt", "tenant"=>"Admin Upload",     "date"=>"Feb 18, 2026", "category"=>"Payment Receipts", "color"=>"green"],
    ["id"=>5, "title"=>"Cruz-Rent-Receipt",      "type"=>"Payment Receipt", "tenant"=>"Jane Cruz",        "date"=>"Feb 18, 2026", "category"=>"Payment Receipts", "color"=>"red"],
    ["id"=>6, "title"=>"SR-R102-Contract",       "type"=>"Contract",        "tenant"=>"Mikay Andrade",    "date"=>"Feb 18, 2026", "category"=>"Contracts",        "color"=>"red"],
    ["id"=>7, "title"=>"SR-WIFI-F3",             "type"=>"Payment Receipt", "tenant"=>"Admin Upload",     "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"red"],
    ["id"=>8, "title"=>"Manahan-Rent-Receipt",   "type"=>"Payment Receipt", "tenant"=>"Kay Manahan",      "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"orange"],
    ["id"=>9, "title"=>"DelaCruz-Rent-Receipt",  "type"=>"Payment Receipt", "tenant"=>"Jenna Dela Cruz",  "date"=>"Feb 15, 2026", "category"=>"Payment Receipts", "color"=>"orange"],
    ["id"=>10,"title"=>"SR-Clearance-Feb2026",   "type"=>"Clearance",       "tenant"=>"Bea Santos",       "date"=>"Feb 14, 2026", "category"=>"Clearance",        "color"=>"red"],
    ["id"=>11,"title"=>"Room205-Contract",       "type"=>"Contract",        "tenant"=>"Lea Reyes",        "date"=>"Feb 13, 2026", "category"=>"Contracts",        "color"=>"red"],
    ["id"=>12,"title"=>"PolicyDoc-HouseRules",   "type"=>"Policy Document", "tenant"=>"Admin Upload",     "date"=>"Feb 10, 2026", "category"=>"Policy Documents", "color"=>"red"],
    ["id"=>13,"title"=>"SR-Clearance-Santos",    "type"=>"Clearance",       "tenant"=>"Ana Santos",       "date"=>"Feb 10, 2026", "category"=>"Clearance",        "color"=>"red"],
    ["id"=>14,"title"=>"MovIn-Permit-R301",      "type"=>"Permit",          "tenant"=>"Carla Dizon",      "date"=>"Feb 09, 2026", "category"=>"Permits",          "color"=>"green"],
    ["id"=>15,"title"=>"Reception-PolicyDoc",    "type"=>"Policy Document", "tenant"=>"Admin Upload",     "date"=>"Feb 08, 2026", "category"=>"Policy Documents", "color"=>"red"],
    ["id"=>16,"title"=>"Lim-Rent-Receipt",       "type"=>"Payment Receipt", "tenant"=>"Grace Lim",        "date"=>"Feb 07, 2026", "category"=>"Payment Receipts", "color"=>"red"],
    ["id"=>17,"title"=>"R204-Contract-Ramos",    "type"=>"Contract",        "tenant"=>"Maria Ramos",      "date"=>"Feb 06, 2026", "category"=>"Contracts",        "color"=>"red"],
    ["id"=>18,"title"=>"SR-WaterBill-Jan2026",   "type"=>"Payment Receipt", "tenant"=>"Admin Upload",     "date"=>"Feb 05, 2026", "category"=>"Payment Receipts", "color"=>"red"],
];

$categories = [
    "All Documents"   => count($all_documents),
    "Clearance"       => count(array_filter($all_documents, fn($d)=>$d['category']==='Clearance')),
    "Payment Receipts"=> count(array_filter($all_documents, fn($d)=>$d['category']==='Payment Receipts')),
    "Contracts"       => count(array_filter($all_documents, fn($d)=>$d['category']==='Contracts')),
    "Permits"         => count(array_filter($all_documents, fn($d)=>$d['category']==='Permits')),
    "Policy Documents"=> count(array_filter($all_documents, fn($d)=>$d['category']==='Policy Documents')),
];

$nav_items = [
    ["icon"=>"🏠","label"=>"Dashboard",           "active"=>false, "href"=>"dormease_dashboard.php"],
    ["icon"=>"👥","label"=>"Manage Tenants",       "active"=>false],
    ["icon"=>"📄","label"=>"Document Management",  "active"=>true],
    ["icon"=>"🚨","label"=>"Emergency Reports",    "active"=>false],
    ["icon"=>"🔧","label"=>"Maintenance Requests", "active"=>false],
    ["icon"=>"💧","label"=>"Water Billing",        "active"=>false],
    ["icon"=>"📋","label"=>"Visitor Logs",         "active"=>false],
    ["icon"=>"📢","label"=>"Announcements",        "active"=>false],
    ["icon"=>"👔","label"=>"Manage Staff",         "active"=>false],
    ["icon"=>"⚙️","label"=>"Settings",            "active"=>false],
];

$per_page = 9;
$current_page = max(1, intval($_GET['page'] ?? 1));
$search    = trim($_GET['search'] ?? '');
$filter_cat= $_GET['cat'] ?? 'All Documents';
$filter_type=$_GET['type'] ?? 'All';
$date_from = $_GET['from'] ?? 'Feb 10, 2026';
$date_to   = $_GET['to']   ?? 'Feb 19, 2026';

// Filter documents
$filtered = $all_documents;
if ($filter_cat !== 'All Documents') {
    $filtered = array_filter($filtered, fn($d) => $d['category'] === $filter_cat);
}
if ($filter_type !== 'All') {
    $filtered = array_filter($filtered, fn($d) => $d['type'] === $filter_type);
}
if ($search !== '') {
    $s = strtolower($search);
    $filtered = array_filter($filtered, fn($d) =>
        str_contains(strtolower($d['title']), $s) ||
        str_contains(strtolower($d['tenant']), $s)
    );
}
$filtered = array_values($filtered);
$total = count($filtered);
$total_pages = max(1, ceil($total / $per_page));
$current_page = min($current_page, $total_pages);
$paged = array_slice($filtered, ($current_page - 1) * $per_page, $per_page);

$doc_types = ["All", "Payment Receipt", "Permit", "Contract", "Clearance", "Policy Document"];

// Color map for file indicator dots
$dot_colors = [
    "red"    => "#e8417a",
    "green"  => "#4caf76",
    "orange" => "#f59e0b",
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DormEase — Document Management</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
  :root {
    --pink-50:  #fff0f3;
    --pink-100: #ffd6e0;
    --pink-200: #ffadc2;
    --pink-300: #ff85a3;
    --pink-400: #f4608a;
    --pink-500: #e8417a;
    --pink-600: #c72d63;
    --pink-700: #9e1d4b;
    --rose-bg:  #fdf2f5;
    --card-bg:  #ffffff;
    --border:   #f5d0da;
    --text-dark: #1a1a2e;
    --text-mid:  #5a4a52;
    --text-soft: #9b8490;
    --shadow-sm: 0 1px 4px rgba(200,60,100,.08);
    --shadow-md: 0 4px 16px rgba(200,60,100,.12);
    --shadow-lg: 0 8px 32px rgba(200,60,100,.18);
    --radius-sm: 10px;
    --radius-md: 16px;
    --radius-lg: 22px;
    --font-body: 'DM Sans', sans-serif;
    --font-display: 'DM Serif Display', serif;
    --transition: all .2s cubic-bezier(.4,0,.2,1);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: var(--font-body);
    background: var(--rose-bg);
    color: var(--text-dark);
    min-height: 100vh;
    display: flex;
    overflow: hidden;
  }

  /* ===== SIDEBAR ===== */
  .sidebar {
    width: 240px;
    min-height: 100vh;
    background: var(--card-bg);
    border-right: 1.5px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 0 0 20px;
    flex-shrink: 0;
    z-index: 10;
    box-shadow: 2px 0 16px rgba(200,60,100,.06);
  }
  .sidebar-brand {
    display: flex; align-items: center; gap: 10px;
    padding: 22px 20px 18px;
    border-bottom: 1.5px solid var(--border);
  }
  .brand-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--pink-400), var(--pink-600));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    box-shadow: 0 2px 8px rgba(200,60,100,.3);
  }
  .brand-name {
    font-family: var(--font-display);
    font-size: 20px; color: var(--pink-600); letter-spacing: -.3px;
  }
  .admin-badge {
    margin: 14px 16px;
    background: var(--pink-50);
    border: 1.5px solid var(--pink-100);
    border-radius: var(--radius-sm);
    padding: 8px 12px;
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; font-weight: 600; color: var(--pink-600);
    letter-spacing: .5px; text-transform: uppercase;
  }
  .admin-dot {
    width: 8px; height: 8px;
    background: var(--pink-500); border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(232,65,122,.2);
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0%,100% { box-shadow: 0 0 0 3px rgba(232,65,122,.2); }
    50%      { box-shadow: 0 0 0 6px rgba(232,65,122,.05); }
  }
  .sidebar-nav { flex: 1; padding: 6px 10px; overflow-y: auto; }
  .sidebar-nav::-webkit-scrollbar { width: 3px; }
  .sidebar-nav::-webkit-scrollbar-thumb { background: var(--pink-100); border-radius: 4px; }
  .nav-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 12px; border-radius: var(--radius-sm);
    cursor: pointer; transition: var(--transition);
    font-size: 14px; font-weight: 500; color: var(--text-mid);
    margin-bottom: 2px; text-decoration: none;
  }
  .nav-item:hover { background: var(--pink-50); color: var(--pink-600); }
  .nav-item.active {
    background: linear-gradient(135deg, var(--pink-50), #fce4ec);
    color: var(--pink-600); font-weight: 700;
    border-left: 3px solid var(--pink-500);
  }
  .nav-icon { font-size: 16px; width: 20px; text-align: center; }
  .sidebar-footer {
    padding: 12px 10px 0;
    border-top: 1.5px solid var(--border);
    margin: 0 6px;
  }
  .logout-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: var(--radius-sm);
    cursor: pointer; color: var(--text-soft);
    font-size: 14px; font-weight: 500; transition: var(--transition);
    border: none; background: none; width: 100%; font-family: var(--font-body);
  }
  .logout-btn:hover { background: var(--pink-50); color: var(--pink-500); }

  /* ===== MAIN ===== */
  .main-wrap { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 28px;
    background: var(--card-bg);
    border-bottom: 1.5px solid var(--border);
    flex-shrink: 0;
  }
  .breadcrumb { font-size: 12px; color: var(--text-soft); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--pink-500); font-weight: 600; }
  .topbar-actions { display: flex; align-items: center; gap: 14px; }
  .notif-bell {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--pink-50); border: 1.5px solid var(--pink-100);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 16px; position: relative; transition: var(--transition);
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

  /* ===== CONTENT ===== */
  .content-scroll { flex: 1; overflow-y: auto; padding: 24px 28px; }
  .content-scroll::-webkit-scrollbar { width: 4px; }
  .content-scroll::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 4px; }

  .page-header { margin-bottom: 20px; }
  .page-title { font-family: var(--font-display); font-size: 32px; color: var(--text-dark); margin-bottom: 4px; }
  .page-sub { font-size: 15px; color: var(--pink-500); font-weight: 500; }

  /* ===== FILTER BAR ===== */
  .filter-bar {
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    background: var(--card-bg); border: 1.5px solid var(--border);
    border-radius: var(--radius-md); padding: 14px 18px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
  }
  .filter-label { font-size: 13px; font-weight: 600; color: var(--text-mid); white-space: nowrap; }
  .filter-select {
    padding: 7px 30px 7px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 13px; font-family: var(--font-body);
    color: var(--text-dark); background: var(--pink-50);
    cursor: pointer; transition: var(--transition); outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23c72d63' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
  }
  .filter-select:focus { border-color: var(--pink-400); background-color: #fff; box-shadow: 0 0 0 3px rgba(232,65,122,.1); }
  .filter-divider { width: 1px; height: 28px; background: var(--border); }
  .date-range {
    display: flex; align-items: center; gap: 8px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    padding: 7px 12px; background: var(--pink-50); cursor: pointer;
    font-size: 13px; color: var(--text-mid); transition: var(--transition);
  }
  .date-range:hover { border-color: var(--pink-300); }
  .date-range input[type="date"] {
    border: none; background: transparent; font-family: var(--font-body);
    font-size: 13px; color: var(--text-dark); outline: none; cursor: pointer;
    width: 110px;
  }
  .search-wrap {
    flex: 1; min-width: 200px;
    display: flex; align-items: center; gap: 8px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    padding: 7px 14px; background: var(--pink-50); transition: var(--transition);
  }
  .search-wrap:focus-within { border-color: var(--pink-400); background: #fff; box-shadow: 0 0 0 3px rgba(232,65,122,.1); }
  .search-wrap input {
    flex: 1; border: none; background: transparent; font-family: var(--font-body);
    font-size: 13px; color: var(--text-dark); outline: none;
  }
  .search-wrap input::placeholder { color: var(--text-soft); }

  /* ===== MAIN GRID ===== */
  .doc-layout { display: grid; grid-template-columns: 200px 1fr; gap: 18px; align-items: start; }

  /* ===== CATEGORY SIDEBAR ===== */
  .cat-panel {
    background: var(--card-bg); border: 1.5px solid var(--border);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);
    overflow: hidden;
  }
  .cat-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; cursor: pointer; transition: var(--transition);
    border-bottom: 1px solid var(--pink-50); font-size: 13px;
    font-weight: 500; color: var(--text-mid); text-decoration: none;
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

  /* ===== DOCUMENTS TABLE CARD ===== */
  .doc-card {
    background: var(--card-bg); border: 1.5px solid var(--border);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;
  }
  .doc-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px;
    border-bottom: 1.5px solid var(--pink-50);
  }
  .doc-card-title { font-size: 16px; font-weight: 700; color: var(--pink-600); }
  .upload-btn {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 18px;
    background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-size: 13px; font-weight: 700; cursor: pointer;
    font-family: var(--font-body); transition: var(--transition); letter-spacing: .2px;
  }
  .upload-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(200,60,100,.3); }

  /* Table */
  .doc-table { width: 100%; border-collapse: collapse; }
  .doc-table thead tr {
    background: linear-gradient(135deg, var(--pink-50), #fce4ec);
    border-bottom: 1.5px solid var(--pink-100);
  }
  .doc-table th {
    padding: 12px 16px; text-align: left;
    font-size: 12px; font-weight: 700; color: var(--pink-600);
    letter-spacing: .4px; text-transform: uppercase; white-space: nowrap;
  }
  .doc-table th .sort-icon { margin-left: 4px; opacity: .6; font-size: 10px; }
  .doc-table tbody tr {
    border-bottom: 1px solid var(--pink-50);
    transition: var(--transition); cursor: default;
  }
  .doc-table tbody tr:last-child { border-bottom: none; }
  .doc-table tbody tr:hover { background: var(--pink-50); }
  .doc-table td { padding: 13px 16px; font-size: 13px; color: var(--text-mid); vertical-align: middle; }

  .doc-title-cell { display: flex; align-items: center; gap: 10px; }
  .doc-dot {
    width: 10px; height: 10px; border-radius: 2px; flex-shrink: 0;
  }
  .doc-name { font-weight: 600; color: var(--text-dark); font-size: 13px; }

  /* Action icons */
  .action-cell { display: flex; align-items: center; gap: 6px; }
  .action-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: var(--transition); font-size: 14px;
    border: 1.5px solid var(--border); background: var(--pink-50);
    color: var(--text-mid);
  }
  .action-btn:hover.view  { background: #e8f4ff; border-color: #90cdf4; color: #2b6cb0; }
  .action-btn:hover.edit  { background: #fef9c3; border-color: #fcd34d; color: #92400e; }
  .action-btn:hover.del   { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }

  /* Empty state */
  .empty-state {
    text-align: center; padding: 60px 20px;
    color: var(--text-soft);
  }
  .empty-icon { font-size: 48px; margin-bottom: 14px; opacity: .5; }
  .empty-text { font-size: 15px; font-weight: 500; }

  /* ===== PAGINATION ===== */
  .pagination {
    display: flex; align-items: center; justify-content: center;
    gap: 5px; padding: 18px;
    border-top: 1.5px solid var(--pink-50);
  }
  .page-btn {
    min-width: 34px; height: 34px; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 600; cursor: pointer;
    border: 1.5px solid var(--border); background: var(--card-bg);
    color: var(--text-mid); transition: var(--transition);
    text-decoration: none; padding: 0 10px;
  }
  .page-btn:hover { background: var(--pink-50); border-color: var(--pink-300); color: var(--pink-600); }
  .page-btn.active {
    background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
    color: #fff; border-color: var(--pink-500);
    box-shadow: 0 2px 8px rgba(200,60,100,.3);
  }
  .page-btn.disabled { opacity: .4; pointer-events: none; }
  .page-dots { color: var(--text-soft); font-size: 13px; padding: 0 4px; }

  /* ===== MODAL ===== */
  .modal-overlay {
    position: fixed; inset: 0;
    background: rgba(26,10,18,.45); backdrop-filter: blur(4px);
    z-index: 100; display: none; align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--card-bg); border-radius: var(--radius-lg);
    padding: 30px; max-width: 480px; width: 92%;
    box-shadow: var(--shadow-lg);
    animation: slideUp .25s cubic-bezier(.4,0,.2,1);
  }
  @keyframes slideUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .modal-title { font-family: var(--font-display); font-size: 22px; color: var(--text-dark); margin-bottom: 20px; }
  .form-group { margin-bottom: 15px; }
  .form-label { font-size: 13px; font-weight: 600; color: var(--text-mid); margin-bottom: 6px; display: block; }
  .form-input, .form-select {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: 14px; font-family: var(--font-body); color: var(--text-dark);
    background: var(--pink-50); transition: var(--transition); outline: none;
  }
  .form-input:focus, .form-select:focus {
    border-color: var(--pink-400); background: #fff;
    box-shadow: 0 0 0 3px rgba(232,65,122,.1);
  }
  .file-drop {
    border: 2px dashed var(--pink-200); border-radius: var(--radius-md);
    padding: 28px; text-align: center; cursor: pointer;
    transition: var(--transition); background: var(--pink-50);
  }
  .file-drop:hover, .file-drop.dragover { border-color: var(--pink-500); background: #fce4ec; }
  .file-drop-icon { font-size: 32px; margin-bottom: 8px; }
  .file-drop-text { font-size: 13px; color: var(--text-soft); }
  .file-drop-text strong { color: var(--pink-600); }
  .file-name-preview { margin-top: 8px; font-size: 12px; color: var(--pink-600); font-weight: 600; display: none; }
  .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
  .btn-cancel {
    padding: 9px 20px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    background: #fff; font-size: 14px; font-weight: 600; color: var(--text-mid);
    cursor: pointer; font-family: var(--font-body); transition: var(--transition);
  }
  .btn-cancel:hover { border-color: var(--pink-300); color: var(--pink-500); }
  .btn-primary {
    padding: 9px 22px;
    background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-size: 14px; font-weight: 700; cursor: pointer;
    font-family: var(--font-body); transition: var(--transition);
  }
  .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(200,60,100,.3); }
  .btn-danger {
    padding: 9px 22px;
    background: linear-gradient(135deg, #dc2626, #991b1b);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-size: 14px; font-weight: 700; cursor: pointer;
    font-family: var(--font-body); transition: var(--transition);
  }
  .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(220,38,38,.3); }

  /* ===== VIEW MODAL ===== */
  .doc-preview {
    background: var(--pink-50); border: 1.5px solid var(--border);
    border-radius: var(--radius-md); padding: 20px; margin-bottom: 16px;
  }
  .doc-preview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .doc-preview-field label { font-size: 11px; font-weight: 700; color: var(--text-soft); text-transform: uppercase; letter-spacing: .5px; }
  .doc-preview-field p { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-top: 2px; }

  /* ===== TOAST ===== */
  .toast {
    position: fixed; bottom: 28px; right: 28px;
    background: linear-gradient(135deg, var(--pink-500), var(--pink-700));
    color: #fff; padding: 14px 22px; border-radius: var(--radius-md);
    font-size: 14px; font-weight: 600; box-shadow: var(--shadow-lg);
    z-index: 200; transform: translateY(80px); opacity: 0;
    transition: all .35s cubic-bezier(.4,0,.2,1); pointer-events: none;
  }
  .toast.show { transform: translateY(0); opacity: 1; }

  /* Result count */
  .result-info { font-size: 12px; color: var(--text-soft); padding: 10px 22px 0; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 4px; }

  @media (max-width: 900px) {
    .doc-layout { grid-template-columns: 1fr; }
    .cat-panel { display: flex; flex-wrap: wrap; }
    .cat-item { border-bottom: none; border-right: 1px solid var(--pink-50); }
  }
  @media (max-width: 700px) {
    .sidebar { width: 64px; }
    .brand-name, .nav-item span:not(.nav-icon), .admin-badge span, .logout-btn span:last-child { display: none; }
    .content-scroll { padding: 16px; }
    .filter-bar { gap: 8px; }
    .doc-table th:nth-child(4), .doc-table td:nth-child(4) { display: none; }
  }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">🏢</div>
    <span class="brand-name">DormEase</span>
  </div>
  <div class="admin-badge">
    <div class="admin-dot"></div>
    <span>Admin</span>
  </div>
  <nav class="sidebar-nav">
    <?php foreach ($nav_items as $item): ?>
    <a class="nav-item <?= $item['active'] ? 'active' : '' ?>"
       href="<?= $item['href'] ?? '#' ?>"
       <?= !isset($item['href']) ? 'onclick="showToast(\'Opening '.htmlspecialchars($item['label']).'...\'); return false;"' : '' ?>>
      <span class="nav-icon"><?= $item['icon'] ?></span>
      <span><?= htmlspecialchars($item['label']) ?></span>
    </a>
    <?php endforeach; ?>
  </nav>
  <div class="sidebar-footer">
    <button class="logout-btn" onclick="showToast('Logging out...')">
      <span>↩️</span><span>Log Out</span>
    </button>
  </div>
</aside>

<!-- MAIN -->
<div class="main-wrap">
  <div class="topbar">
    <div class="breadcrumb">Pages / <span>Document Management</span></div>
    <div class="topbar-actions">
      <div class="notif-bell" onclick="showToast('Opening notifications...')">
        🔔<div class="notif-badge">4</div>
      </div>
      <div class="avatar">K</div>
    </div>
  </div>

  <div class="content-scroll">
    <div class="page-header">
      <div class="page-title">Document Management</div>
      <div class="page-sub"><?= htmlspecialchars($dorm_name) ?></div>
    </div>

    <!-- FILTER BAR -->
    <form method="GET" id="filterForm">
      <div class="filter-bar">
        <span class="filter-label">Filter By:</span>
        <select class="filter-select" name="cat" onchange="this.form.submit()">
          <?php foreach (array_keys($categories) as $cat): ?>
          <option value="<?= htmlspecialchars($cat) ?>" <?= $filter_cat===$cat?'selected':'' ?>>
            <?= htmlspecialchars($cat) ?>
          </option>
          <?php endforeach; ?>
        </select>

        <div class="filter-divider"></div>

        <span class="filter-label">Document Type:</span>
        <select class="filter-select" name="type" onchange="this.form.submit()">
          <?php foreach ($doc_types as $dt): ?>
          <option value="<?= htmlspecialchars($dt) ?>" <?= $filter_type===$dt?'selected':'' ?>>
            <?= htmlspecialchars($dt) ?>
          </option>
          <?php endforeach; ?>
        </select>

        <div class="filter-divider"></div>

        <span class="filter-label">From:</span>
        <div class="date-range">
          📅 <input type="date" name="from" value="2026-02-10" onchange="this.form.submit()">
        </div>
        <span class="filter-label" style="margin:0 -6px;">to</span>
        <div class="date-range">
          <input type="date" name="to" value="2026-02-19" onchange="this.form.submit()">
        </div>

        <div class="search-wrap">
          🔍
          <input type="text" name="search" placeholder="Search by Title or Tenant"
                 value="<?= htmlspecialchars($search) ?>" onchange="this.form.submit()">
        </div>
        <input type="hidden" name="page" value="1">
      </div>
    </form>

    <div class="doc-layout">
      <!-- Category Sidebar -->
      <div class="cat-panel">
        <?php foreach ($categories as $cat => $count): ?>
        <a class="cat-item <?= $filter_cat===$cat?'active':'' ?>"
           href="?cat=<?= urlencode($cat) ?>&type=<?= urlencode($filter_type) ?>&search=<?= urlencode($search) ?>&page=1">
          <?= htmlspecialchars($cat) ?>
          <span class="cat-badge"><?= $count ?></span>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Documents Table -->
      <div class="doc-card">
        <div class="doc-card-header">
          <div class="doc-card-title">Documents</div>
          <button class="upload-btn" onclick="openUploadModal()">📤 Upload New Document</button>
        </div>

        <?php if (count($paged) > 0): ?>
        <div class="result-info">Showing <?= ($current_page-1)*$per_page+1 ?>–<?= min($current_page*$per_page,$total) ?> of <?= $total ?> documents</div>
        <table class="doc-table">
          <thead>
            <tr>
              <th>Title <span class="sort-icon">↕</span></th>
              <th>Document Type <span class="sort-icon">↕</span></th>
              <th>Tenant Name <span class="sort-icon">↕</span></th>
              <th>Date Posted <span class="sort-icon">↕</span></th>
              <th style="text-align:center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($paged as $doc):
              $dot_color = $dot_colors[$doc['color']] ?? '#e8417a';
            ?>
            <tr>
              <td>
                <div class="doc-title-cell">
                  <div class="doc-dot" style="background:<?= $dot_color ?>"></div>
                  <span class="doc-name"><?= htmlspecialchars($doc['title']) ?></span>
                </div>
              </td>
              <td><?= htmlspecialchars($doc['type']) ?></td>
              <td><?= htmlspecialchars($doc['tenant']) ?></td>
              <td><?= htmlspecialchars($doc['date']) ?></td>
              <td>
                <div class="action-cell" style="justify-content:center">
                  <div class="action-btn view" title="View"
                       onclick="viewDoc(<?= htmlspecialchars(json_encode($doc), ENT_QUOTES) ?>)">👁</div>
                  <div class="action-btn edit" title="Edit"
                       onclick="editDoc(<?= htmlspecialchars(json_encode($doc), ENT_QUOTES) ?>)">✏️</div>
                  <div class="action-btn del" title="Delete"
                       onclick="confirmDelete(<?= $doc['id'] ?>, '<?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>')">🗑</div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
          <a class="page-btn <?= $current_page<=1?'disabled':'' ?>"
             href="?cat=<?= urlencode($filter_cat) ?>&type=<?= urlencode($filter_type) ?>&search=<?= urlencode($search) ?>&page=<?= $current_page-1 ?>">‹ Previous</a>

          <?php
          $pages_to_show = [];
          $pages_to_show[] = 1;
          if ($current_page > 3) $pages_to_show[] = '...';
          for ($p = max(2,$current_page-1); $p <= min($total_pages-1,$current_page+1); $p++) $pages_to_show[] = $p;
          if ($current_page < $total_pages-2) $pages_to_show[] = '...';
          if ($total_pages > 1) $pages_to_show[] = $total_pages;

          foreach ($pages_to_show as $p):
            if ($p === '...'):
          ?>
            <span class="page-dots">...</span>
          <?php else: ?>
            <a class="page-btn <?= $p==$current_page?'active':'' ?>"
               href="?cat=<?= urlencode($filter_cat) ?>&type=<?= urlencode($filter_type) ?>&search=<?= urlencode($search) ?>&page=<?= $p ?>"><?= $p ?></a>
          <?php endif; endforeach; ?>

          <a class="page-btn <?= $current_page>=$total_pages?'disabled':'' ?>"
             href="?cat=<?= urlencode($filter_cat) ?>&type=<?= urlencode($filter_type) ?>&search=<?= urlencode($search) ?>&page=<?= $current_page+1 ?>">Next ›</a>
        </div>

        <?php else: ?>
        <div class="empty-state">
          <div class="empty-icon">📂</div>
          <div class="empty-text">No documents found matching your filters.</div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div><!-- /content-scroll -->
</div><!-- /main-wrap -->

<!-- ===== UPLOAD MODAL ===== -->
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
        <option>Payment Receipt</option>
        <option>Permit</option>
        <option>Contract</option>
        <option>Clearance</option>
        <option>Policy Document</option>
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
      <button class="btn-cancel" onclick="closeModal('uploadModal')">Cancel</button>
      <button class="btn-primary" onclick="submitUpload()">Upload</button>
    </div>
  </div>
</div>

<!-- ===== VIEW MODAL ===== -->
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
    <div style="background:var(--pink-50);border:1.5px dashed var(--pink-200);border-radius:var(--radius-md);padding:30px;text-align:center;color:var(--text-soft);font-size:13px;">
      📄 Document preview would appear here in production
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('viewModal')">Close</button>
      <button class="btn-primary" onclick="showToast('📥 Downloading document...'); closeModal(\'viewModal\')">Download</button>
    </div>
  </div>
</div>

<!-- ===== EDIT MODAL ===== -->
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
      <button class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
      <button class="btn-primary" onclick="submitEdit()">Save Changes</button>
    </div>
  </div>
</div>

<!-- ===== DELETE CONFIRM MODAL ===== -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-title">Delete Document</div>
    <p style="font-size:14px;color:var(--text-mid);margin-bottom:8px;">
      Are you sure you want to delete <strong id="deleteDocName"></strong>?
      This action cannot be undone.
    </p>
    <input type="hidden" id="deleteId">
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
      <button class="btn-danger" onclick="submitDelete()">Delete</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
// Toast
let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}

// Modals
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(m =>
  m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); })
);

// Upload
function openUploadModal() { openModal('uploadModal'); }
function previewFile(input) {
  if (input.files[0]) {
    const p = document.getElementById('fileNamePreview');
    p.textContent = '📎 ' + input.files[0].name;
    p.style.display = 'block';
  }
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
  const title = document.getElementById('upTitle').value.trim();
  if (!title) { showToast('⚠️ Please enter a document title.'); return; }
  closeModal('uploadModal');
  showToast('✅ Document uploaded successfully!');
  document.getElementById('upTitle').value = '';
  document.getElementById('upTenant').value = '';
  document.getElementById('fileNamePreview').style.display = 'none';
}

// View
function viewDoc(doc) {
  document.getElementById('vTitle').textContent  = doc.title;
  document.getElementById('vType').textContent   = doc.type;
  document.getElementById('vTenant').textContent = doc.tenant;
  document.getElementById('vDate').textContent   = doc.date;
  document.getElementById('vCat').textContent    = doc.category;
  openModal('viewModal');
}

// Edit
function editDoc(doc) {
  document.getElementById('editId').value       = doc.id;
  document.getElementById('editTitle').value    = doc.title;
  document.getElementById('editType').value     = doc.type;
  document.getElementById('editTenant').value   = doc.tenant;
  openModal('editModal');
}
function submitEdit() {
  const title = document.getElementById('editTitle').value.trim();
  if (!title) { showToast('⚠️ Title cannot be empty.'); return; }
  closeModal('editModal');
  showToast('✅ Document updated successfully!');
}

// Delete
function confirmDelete(id, name) {
  document.getElementById('deleteId').value = id;
  document.getElementById('deleteDocName').textContent = name;
  openModal('deleteModal');
}
function submitDelete() {
  closeModal('deleteModal');
  showToast('🗑 Document deleted.');
}
</script>
</body>
</html>