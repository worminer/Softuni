function jsonToTable(jsonArr) {
  let html = '<table>\n';

  for (let jsonStr of jsonArr) {
    let row = JSON.parse(jsonStr);
    html += `  <tr>
      <td>${escapeHtml(row.name)}</td>
      <td>${escapeHtml(row.position)}</td>
      <td>${escapeHtml(row.salary)}</td>
  <tr>\n`;
  }
  html += '</table>';

  return html;

  function escapeHtml(unsafe) {
    return unsafe.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
  }
}

console.log(jsonToTable(
    [
      '{"name":"Pesho","position":"Promenliva","salary":100000}',
      '{"name":"Teo","position":"Lecturer","salary":1000}',
      '{"name":"Georgi","position":"Lecturer","salary":1000}',
    ]
));