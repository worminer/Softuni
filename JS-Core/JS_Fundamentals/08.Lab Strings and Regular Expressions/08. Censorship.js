function censorship(text, forbiddenWords) {
  for(let word of forbiddenWords) {
    text = text.split(word).join("-".repeat(word.length));
  }
  return text;
}

censorship('roses are red, violets are blue', [', violets are', 'red']);