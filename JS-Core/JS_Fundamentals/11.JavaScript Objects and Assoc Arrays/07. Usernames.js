function sortUsernames(usernameArr) {
  let usernames = Array.from(new Set(usernameArr))
      .sort((a,b) => a.length < b.length ? -1 : a.length > b.length ? 1 : a < b ? -1 : 1)
      .forEach(e => console.log(e));
}

sortUsernames(
    [
      'Denise',
      'Ignatius',
      'Iric',
      'Iris',
      'Iria',
      'Iriz',
      'Isacc',
      'Indie',
      'Dean',
      'Donatello',
      'Enfuego',
      'Benjamin',
      'Biser',
      'Bounty',
      'Renard',
      'Rot',
    ]
);