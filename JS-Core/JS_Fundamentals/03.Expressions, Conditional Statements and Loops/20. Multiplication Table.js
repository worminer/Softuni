function multiplicationTable(n) {
  console.log('<table border=\'1\'>');

  let line = '<tr><th>x</th>';
  for (let x = 1; x <= n; x++) {
    line += '<th>' + x + '</th>';
  }
  line += '</tr\n';
  for (let i = 1; i <= n; i++) {
    line += '<tr><th>' + i + '</th>';

    for (y = 1; y <= n; y++) {
      line += '<td>' + y * i + '</td>';
    }
    line += '</tr>';
    console.log(line);
    line = '';
  }
  console.log('</table>');
}