function chessBoard(bordSize) {
  let html = '<div class="chessboard">\n';
  for (let row = 0; row < bordSize; row++) {
    html += '  <div>\n';
    let color = (row % 2 === 0) ? 'black' : 'white';
    for (let col = 0; column < bordSize; column++) {
      html += `    <span class="${color}"></span>\n`;
      color = (color === 'white') ? 'black' : 'white';
    }
    html += '  </div>\n';
  }

  return html + '</div>';
}

console.log(chessBoard());