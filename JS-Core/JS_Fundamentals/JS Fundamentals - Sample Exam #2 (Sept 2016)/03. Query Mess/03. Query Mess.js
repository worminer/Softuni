function queryString(queries) {
  let results = [];

  for (let query of queries) {
    let currentResult = new Map;
    if (query.match(/^(?:(?:http|https):\/\/).+?[?]/) !== null) {
      query = query.split('?')[1]
    }
    // clear space madness
    query = query.replace(/([+]|(%20))+/g, ' ');

    let queryParts = query.split('&');
    for (let part of queryParts) {
      let [key, val] = part.split('=');
      key = key.trim();
      val = val.trim();
      if (!currentResult.has(key)) {
        currentResult.set(key,[])
      }
      currentResult.get(key).push(val);
    }
    let result = '';
    for (let line of currentResult) {
      result+= `${line[0]}=[${line[1].join(', ')}]`;
    }
    console.log(result)
  }

}

queryString([
  'login=student&password=student',
  'field=value1&field=value2&field=value3',
  'http://example.com/over/there?name=ferret',
  'foo=%20foo&value=+val&foo+=5+%20+203',
  'foo=poo%20&value=valley&dog=wow+',
  'url=https://softuni.bg/trainings/coursesinstances/details/1070',
  'https://softuni.bg/trainings.asp?trainer=nakov&course=oop&course=php',
    ]);