function validateAjax(data) {
  let encriptionHash = data.pop();
  let requests = [];
  let respond = '';

  // create Map for each request
  for (let row of data) {
    let [key, value] = row.split(': ');
    if (key === 'Method') {
      requests.push(new Map);
    }
    requests[requests.length-1].set(key,value);
  }

  // remove invalid requests invalid request
  requests = requests.filter(e => e.get('Method') === 'GET' ||
      e.get('Method') === 'POST' ||
      e.get('Method') === 'PUT' ||
      e.get('Method') === 'DELETE'
  );

  for (let request of requests) {
    let credentialsMatch ='';
    let method = request.get('Method');
    if (method === 'GET') {
      credentialsMatch = request.get('Credentials').match(/Basic|Bearer ([\w|\d]+)/);
    } else {
      credentialsMatch = request.get('Credentials').match(/Bearer ([\w|\d]+)/);
    }
    let contentMatch = request.get('Content').match(/[\w\d.]+/);
    if ( contentMatch === null || contentMatch[0] !== request.get('Content')) {
      respond += `Response-Code:400\n`;
      continue;
    }
    // if credential are valid
    if (credentialsMatch === null || credentialsMatch[0] !== request.get('Credentials')) {
      respond += `Response-Method:${method}&Code:401\n`;
      continue;
    }
    //If a request fails because of invalid authorization token, (Hash password failed to decode)
    if (!checkValidCredential(credentialsMatch, encriptionHash)) {
      respond += `Response-Method:${method}&Code:403\n`;
      continue;
    }


    //if everything is ok
    respond += `Response-Method:${method}&Code:200&Header:${credentialsMatch[1]}\n`;

  }

  function checkValidCredential(credentials, hash) {
    let tokens = hash.split('');
    for (let i = 0; i < tokens.length -1; i += 2) {
      let matches = credentials[1].split(tokens[i+1]).length -1;
      if ( matches === Number(tokens[i])) {
        return true;
      }
    }
    return false;
  }
  console.log(respond);
}

validateAjax([
  'Method: GET',
  'Credentials: Bearer asd918721jsdbhjslkfqwkqiuwjoxXJIdahefJAB',
  'Content: users.asd.1782452.278asd',
  'Method: POST',
  'Credentials: Basic 028591u3jtndkgwndsdkfjwelfqkjwporjqebhas',
  'Content: Johnathan',
  '2q'
]);

validateAjax([
  'Method: PUT',
  'Credentials: Bearer as9133jsdbhjslkfqwkqiuwjoxXJIdahefJAB',
  'Content: users.asd/1782452$278///**asd123',
  'Method: POST',
  'Credentials: Bearer 028591u3jtndkgwndskfjwelfqkjwporjqebhas',
  'Content: Johnathan',
  'Method: DELETE',
  'Credentials: Bearer 05366u3jtndkgwndssfsfgeryerrrrrryjihvx',
  'Content: This.is.a.sample.content',
  '2e5g',
]);