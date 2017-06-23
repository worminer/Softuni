function validateMessage(notValidatedMessage) {
  let message = notValidatedMessage.match(/<message (?: |(?:[a-z]+="[\w .]+"))+>((?:.|\n|\r)*?)<\/message>/);
  if (message === null || notValidatedMessage.localeCompare(message[0])) {
    console.log('Invalid message format');
    return;
  }

  let from = message[0].match(/from="([a-zA-z0-9 .]+)"/);
  let to = message[0].match(/to="([a-zA-z0-9 .]+)"/);

  if (from === null || to === null) {
    console.log('Missing attributes');
    return;
  }

  from = from[1];
  to = to[1];
  let paragraphs = message[1].split(/\n/);

  // print
  console.log(`<article>`);
  console.log(`  <div>From: <span class="sender">${from}</span></div>`);
  console.log(`  <div>To: <span class="recipient">${to}</span></div>`);
  console.log(`  <div>`);
  for (let line of paragraphs) {
    console.log(`    <p>${line}</p>`);
  }
  console.log(`  </div>`);
  console.log(`</article>`);


}
//validateMessage('<message to="Bob" from="Alice" timestamp="1497254092">Hey man, what\'s up?</message>');
//validateMessage('<message from="John Doe" to="Alice">Not much, just chillin. How about you?</message>');
//validateMessage('<message to="Bob" from="Alice" timestamp="1497254114">Same old, same old\nLet\'s go out for a beer</message>');
validateMessage('<message from="Hillary" to="Edward" secret:true>VGhpcyBpcyBhIHRlc3Q</message>')
//validateMessage('<message from="Alice" timestamp="1497254112">This is a test</message>');
//validateMessage('<message to="Matilda" from="Charlie"><media type="image" src="slyfox.jpg"/></message><meta version="2.0"/>');
//validateMessage('<message from="MasterBlaster" to="TheAnimal" color="#FF340B">FWD: Funny stuff</message>');
//validateMessage('<message from="Hillary" to="Edward" ');
//validateMessage('secret:true>VGhpcyBpcyBhIHRlc3Q</message>')