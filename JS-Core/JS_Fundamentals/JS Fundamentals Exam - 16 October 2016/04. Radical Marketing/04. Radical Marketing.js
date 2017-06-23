function marketSolve(data) {
  let database = new Map;

  for (let line of data) {
    let tokens = line.split('-')
    if (tokens.length === 1) {
      // register new person
      let newUser = tokens[0];
      if (!database.has(newUser)) {
        database.set(newUser, new Set())
      }
    } else if (tokens.length === 2) {
      // register subscriber
      let [subscriber, user] = tokens;
      if (user !== subscriber) {
        if (database.has(user) && database.has(subscriber)) {
          database.get(user).add(subscriber);
        }
      }
    } else {
      // something gone wrong .. ignore!
    }
  }

  database = [...database].sort((a,b) =>{
    if (a[1].size < b[1].size) {
    // if A have more subs then B .. return A
      return 1;
    } else if (a[1].size > b[1].size) {
      return -1;
    } else {
      let aSubTo = 0;
      let bSubTo = 0;
      for (let user of database) {
        if (user[1].has(a[0])) {
          aSubTo++;
        }
        if (user[1].has(b[0])) {
          bSubTo++;
        }
      }
      if (aSubTo > bSubTo) {
        return -1;
      } else if (aSubTo < bSubTo) {
        return 1;
      } else {
        return 0;
      }
    }
  });

  let vip = [...database][0];
  let vipSubs = [...vip[1]];
  console.log(vip[0]);
  for (let i = 0; i < vipSubs.length; i++) {
    console.log(`${i+1}. ${vipSubs[i]}`)
  }


}
console.log('*'.repeat(20));
marketSolve([
  'A',
  'B',
  'C',
  'D',
  'E',
  'Z',
  'B-A',
  'C-A',
  'D-A',
  'B-Z',
  'C-Z',
  'D-Z',
  'A-E',
]);

console.log('*'.repeat(20));
// marketSolve([
//   'J',
//   'G',
//   'P',
//   'R',
//   'C',
//   'J-G',
//   'G-J',
//   'P-R',
//   'R-P',
//   'C-J',
// ]);
console.log('*'.repeat(20));