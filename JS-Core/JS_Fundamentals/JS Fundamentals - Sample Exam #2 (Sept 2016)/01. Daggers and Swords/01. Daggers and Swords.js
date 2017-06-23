'use strict';
function bladeSorter(blades) {
  blades = blades
      .map(Number)
      .map(num => Math.floor(num))
      .filter(e => {
        return e > 10 ? e : '';
      });
  let html = '<table border="1">\n' +
      '<thead>\n' +
      '<tr><th colspan="3">Blades</th></tr>\n'+
      '<tr><th>Length [cm]</th><th>Type</th><th>Application</th></tr>\n' +
      '</thead>\n' +
      '<tbody>\n';

  for (let bladeSize of blades) {
    let bladeGranpaSize = '';
    let bladeType = 'dagger';
    if (bladeSize > 40) {
      bladeType = 'sword';
    }
    switch (bladeSize % 5){
      case 1:
        bladeGranpaSize = 'blade';
        break;
      case 2:
        bladeGranpaSize = 'quite a blade';
        break;
      case 3:
        bladeGranpaSize = 'pants-scraper';
        break;
      case 4:
        bladeGranpaSize = 'frog-butcher';
        break;
      case 0:
        bladeGranpaSize = '*rap-poker';
        break;
    }

    html += `<tr><td>${bladeSize}</td><td>${bladeType}</td><td>${bladeGranpaSize}</td></tr>\n`;
  }

  html += '</tbody>\n</table>';
  console.log(html);
}

bladeSorter([
  '17.8',
  '19.4',
  '13',
  '55.8',
  '126.96541651',
  '3',
])

