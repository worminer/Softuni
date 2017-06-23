function solve(input) {
  let data = JSON.parse(input);

  let html = '<table>\n';
  html += '  <tr>';
  for (let key in data[0]) {
    html += `<th>${key}</th>`
  }
  html += '</tr>\n';
  data.forEach(obj => {
    html += '  <tr>';
    for(let key in obj) {
      let value = obj[key];
      if (isNaN(value)) {
        value = escape(value);
      }

      html += `<td>${value}</td>`;
    }
    html += '</tr>\n';
  });

  html += `</table>`;
  console.log(html);

  function escape(text) {
    text = text.replace(/&/g, '&amp;');
    text = text.replace(/</g, '&lt;');
    text = text.replace(/>/g, '&gt;');
    text = text.replace(/"/g, '&quot;');
    text = text.replace(/'/g, '&#39;');

    return text;
  }
}

solve('[{"Name":"Tomatoes & Chips","Price":2.35},{"Name":"J&B Chocolate","Price":0.96}]');