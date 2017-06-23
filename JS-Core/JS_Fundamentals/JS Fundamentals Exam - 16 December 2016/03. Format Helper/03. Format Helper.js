function textFormater(text) {

  return text.toString()
      .replace(/([\.|,|!|\?|:|;])([ ]+|)/g, '$1 ')
      .replace(/([ ]+)(?=\.|,|!|\?|:|;)/g, '')
      .replace(/(([.]+[ ]+)+[!])/g, '...!')
      .replace(/([.])[\s]+([\d])/g, '$1$2')
      .replace(/" *(.+?) *"/, '"$1"');
}

let text = 'Terribly formatted text      .  With chaotic spacings." Terrible quoting   "! Also this date is pretty confusing : 20   .   12.  16 .';
console.log(text);
console.log(textFormater(text));
