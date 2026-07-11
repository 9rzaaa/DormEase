<script>
window.DormEasePdfReport = (function() {
    var brandName = 'Sanctissimo Rosario Ladies Dormitory';
    var appName = 'DormEase';
    var logoUrl = '{{ asset("images/logo.png") }}';

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(date) {
        return (date || new Date()).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function printTableReport(options) {
        options = options || {};
        var title = options.title || 'Report';
        var subtitle = options.subtitle || '';
        var columns = options.columns || [];
        var rows = options.rows || [];
        var orientation = options.orientation || (columns.length > 7 ? 'landscape' : 'portrait');
        var filenameTitle = title.replace(/[^\w\s-]/g, '').trim() || 'report';
        var generatedAt = options.generatedAt || formatDate(new Date());
        var preparedBy = options.preparedBy || appName;

        var tableHead = columns.map(function(column) {
            return '<th>' + escapeHtml(column) + '</th>';
        }).join('');

        var tableBody = rows.length
            ? rows.map(function(row) {
                return '<tr>' + columns.map(function(_, index) {
                    return '<td>' + escapeHtml(row[index]) + '</td>';
                }).join('') + '</tr>';
            }).join('')
            : '<tr><td class="empty" colspan="' + Math.max(columns.length, 1) + '">No records available.</td></tr>';

        var win = window.open('', '_blank');
        if (!win) {
            alert('Please allow pop-ups to export the PDF report.');
            return;
        }

        win.document.write('<!DOCTYPE html><html><head><title>' + escapeHtml(filenameTitle) + '</title>'
            + '<style>'
            + '@page{size:A4 ' + orientation + ';margin:16mm 14mm 18mm;}'
            + '*{box-sizing:border-box;}'
            + 'body{font-family:Arial,Helvetica,sans-serif;color:#232333;background:#fff;margin:0;font-size:11px;line-height:1.45;}'
            + '.report-header{display:flex;align-items:center;gap:14px;border-bottom:2px solid #E8175D;padding-bottom:12px;margin-bottom:14px;}'
            + '.report-logo-badge{width:58px;height:58px;border-radius:10px;background:#E8175D;border:1px solid #d91453;display:flex;align-items:center;justify-content:center;flex:0 0 58px;}'
            + '.report-logo{width:44px;height:44px;object-fit:contain;}'
            + '.brand{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#E8175D;margin-bottom:2px;}'
            + 'h1{font-size:22px;line-height:1.2;margin:0;color:#1f1f2f;font-weight:800;}'
            + '.subtitle{font-size:12px;color:#666879;margin-top:4px;}'
            + '.meta{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;border:1px solid #ead7df;background:#fff7fa;padding:9px 11px;margin-bottom:14px;}'
            + '.meta-item{font-size:10px;color:#6b6470;text-transform:uppercase;letter-spacing:.04em;}'
            + '.meta-item strong{display:block;color:#242433;font-size:11px;text-transform:none;letter-spacing:0;margin-top:2px;}'
            + 'table{width:100%;border-collapse:collapse;table-layout:auto;}'
            + 'thead{display:table-header-group;}'
            + 'tr{page-break-inside:avoid;}'
            + 'th{background:#E8175D;color:#fff;padding:8px 7px;text-align:left;font-size:9px;text-transform:uppercase;letter-spacing:.04em;border:1px solid #d91453;}'
            + 'td{padding:7px;border:1px solid #efdce4;vertical-align:top;color:#303040;word-break:break-word;}'
            + 'tbody tr:nth-child(even) td{background:#fff8fb;}'
            + '.empty{text-align:center;color:#777;padding:18px;}'
            + '.footer{position:fixed;left:0;right:0;bottom:-9mm;border-top:1px solid #ead7df;padding-top:5px;color:#777;font-size:9px;display:flex;justify-content:space-between;}'
            + '.page-number:after{content:"Page " counter(page);}'
            + '@media screen{body{padding:24px;}.footer{position:static;margin-top:18px;}}'
            + '</style></head><body>'
            + '<header class="report-header">'
            + '<div class="report-logo-badge"><img class="report-logo" src="' + escapeHtml(logoUrl) + '" alt="' + escapeHtml(appName) + ' logo"></div>'
            + '<div><div class="brand">' + escapeHtml(brandName) + '</div><h1>' + escapeHtml(title) + '</h1>'
            + (subtitle ? '<div class="subtitle">' + escapeHtml(subtitle) + '</div>' : '')
            + '</div></header>'
            + '<section class="meta">'
            + '<div class="meta-item">Generated On<strong>' + escapeHtml(generatedAt) + '</strong></div>'
            + '<div class="meta-item">Prepared By<strong>' + escapeHtml(preparedBy) + '</strong></div>'
            + '<div class="meta-item">Total Records<strong>' + escapeHtml(rows.length) + '</strong></div>'
            + '</section>'
            + '<table><thead><tr>' + tableHead + '</tr></thead><tbody>' + tableBody + '</tbody></table>'
            + '<div class="footer"><span>' + escapeHtml(brandName) + ' | ' + escapeHtml(appName) + '</span><span class="page-number"></span></div>'
            + '<script>window.onload=function(){setTimeout(function(){window.print();},250);};<\/script>'
            + '</body></html>');
        win.document.close();
    }

    return {
        escapeHtml: escapeHtml,
        printTableReport: printTableReport
    };
})();
</script>
