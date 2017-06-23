function usernames(arr) {
  let usernames = [];
  for (let mail of arr) {
    mail = mail.split('@');
    let user = mail[0] + '.';
    mail[1].split('.').forEach(x => user += x[0]);
    usernames.push(user);
  }

  console.log(usernames.join(", "));
}

usernames(['peshoo@gmail.com', 'todor_43@mail.dir.bg', 'foo@bar.com'])