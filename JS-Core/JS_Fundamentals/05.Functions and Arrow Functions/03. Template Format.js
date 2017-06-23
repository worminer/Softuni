function templateing(array) {
  let html = `<?xml version="1.0" encoding="UTF-8"?>\n`;
  html += `<quiz>\n`;
  for (let i = 0; i < array.length; i+= 2) {
    let question = array[i], answer = array[i + 1];
    make(question, answer);
  }

  html += `</quiz>\n`;
  console.log(html);

  function make(question, answer) {
    html += `  <question>\n`;
    html += `    ${question}\n`;
    html += `  </question>\n`;
    html += `  <answer>\n`;
    html += `    ${answer}\n`;
    html += `  </answer>\n`;
  }
}

templateing(["Dry ice is a frozen form of which gas?",
  "Carbon Dioxide",
  "What is the brightest star in the night sky?",
  "Sirius"]
);