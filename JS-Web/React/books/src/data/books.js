//import util from './../utils/utill';
const noImageScg = 'https://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon.svg';
const bookCount = 250;
const maxCommentCount = 10;
const authorsNames = ['Agatha Christie','William Shakespeare','Barbara Cartland','Danielle Steel','Harold Robbins','Georges Simenon','Sidney Sheldon','Enid Blyton','J. K. Rowling','Dr.Seuss','Gilbert Patten','Leo Tolstoy','Corín Tellado','Jackie Collins','Horatio Alger, Jr.','R. L. Stine','Dean Koontz','Nora Roberts','Alexander Pushkin','Stephen King','Paulo Coelho','Louis LAmour','Erle Stanley Gardner','Jin Yong','Jirō Akagawa','Janet Dailey','Edgar Wallace','Robert Ludlum','James Patterson','Frédéric Dard','Jeffrey Archer','Stan and Jan Berenstain','Roald Dahl','John Grisham','Zane Grey','Irving Wallace','J. R. R. Tolkien','Karl May','MickeySpillane','C. S. Lewis','Kyotaro Nishimura','Dan Brown','Ann M. Martin','Ryōtarō Shiba','Arthur Hailey','Gérard de Villiers','Beatrix Potter','MichaelCrichton','Richard Scarry','Clive Cussler','Alistair MacLean','Ken Follett','Astrid Lindgren','Debbie Macomber','EL James','Eiji Yoshikawa','CatherineCookson','Stephenie Meyer','Norman Bridwell','David Baldacci','Evan Hunter','Andrew Neiderman','Roger Hargreaves','Anne Rice','Robin Cook','WilburSmith','Erskine Caldwell','Judith Krantz','Eleanor Hibbert','Lewis Carroll','Denise Robins','Cao Xueqin','Ian Fleming','Hermann Hesse','Rex Stout','AnneGolon','Frank G. Slaughter','Edgar Rice Burroughs','John Creasey','James Michener','Yasuo Uchida','Seiichi Morimura','Mary Higgins Clark','Penny Jordan','Patricia Cornwell','Tom Clancy'];
const authorsDB = [];
const books = ['The Tale of Peter Rabbit','The Odyssey','Jonathan Livingston Seagull','The Very Hungry Caterpillar','A Message to Garcia','Sofies verden (Sophie\'s World)','Flowers in','the Attic','To Kill a Mockingbird','Angels & Demons','Kane and Abel','Как закалялась сталь ','Война и мир (Voyna i mir; War and Peace)','Het Achterhuis (The Diary of a Young Girl, The Diary of Anne Frank)','Le avventure di Pinocchio. Storia di un burattino (The','Adventures of Pinocchio)','You Can Heal Your Life','Your Erroneous Zones','The Late, Great Planet Earth','The Thorn Birds','The Kite Runner','Valley','of the Dolls','In His Steps: What Would Jesus Do?','The Lost Symbol','Gone with the Wind','The Purpose Driven Life','The Revolt of Mamie Stover','Män','som hatar kvinnor (The Girl with the Dragon Tattoo)','Молодая гвардия (Molodaya Gvardiya; The Young Guard)','Who Moved My Cheese?','The Great Gatsby','The Wind in the Willows','The 7 Habits of Highly Effective People','Поднятая целина (Podnyataya Tselina; Virgin Soil Upturned)','The Celestine Prophecy','The','Hunger Games','The Shack','Дядя Степа (Dyadya Styopa; Uncle Styopa)','The Godfather','Love Story','The Bermuda Triangle','Things Fall Apart','Animal','Farm','狼图腾 (Wolf Totem)','The Happy Hooker: My Own Story','Jaws','Love You Forever','The Women\'s Room','What to Expect When You\'re Expecting','The','Adventures of Huckleberry Finn','The Secret Diary of Adrian Mole, Aged 13¾','Pride and Prejudice','Kon-Tiki: Across the Pacific in a Raft','Osudy','dobrého vojáka Švejka za světové války (The Good Soldier Švejk)','Where the Wild Things Are','The Power of Positive Thinking','The Secret','Fear of Flying','Dune','Charlie and the Chocolate Factory','Roger Hargreaves','Anne Rice','Robin Cook','Wilbur Smith','Erskine Caldwell','Judith Krantz','Eleanor Hibbert','Lewis Carroll','Denise Robins','Cao Xueqin','Ian Fleming','Hermann Hesse','Rex','Stout','Anne Golon','Frank G. Slaughter','Edgar Rice Burroughs','John Creasey','James Michener','Yasuo Uchida','Seiichi Morimura','Mary Higgins Clark','Penny Jordan','Patricia Cornwell','Tom Clancy'];

let booksDB = [];
// create authors
for (let i = 0; i < authorsNames.length; i++) {
  authorsDB.push({
    _id: i+1,
    name: authorsNames[i],
    picture: noImageScg
  });

}

// create random lastBooks
for (let i = 1; i <= bookCount; i++) {
  let bookTitle = books[Math.floor(Math.random()*books.length)];
  let bookAuthor = authorsDB[Math.floor(Math.random()*authorsDB.length)];
  let bookObj = {
    _id: i,
    title :  `${bookTitle}`,
    description: `This is a dummy generated Book named "${bookTitle}" by "${bookAuthor.name}"`,
    author: bookAuthor,
    image : 'http://blog.bookprinting-china.com/xundi/upimages/201151701953317.jpg', // some dummy image
    price : Math.floor(Math.random()*100).toFixed(2),
    comments: [],
    createdAt: Math.floor(Math.random()*10 + 1)
  };
  for (let j = Math.floor(Math.random()*maxCommentCount); j <= maxCommentCount; j++) {
    let comment = `Comment #${maxCommentCount - j + 1} is : Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, illum?`;
    bookObj.comments.push(comment);

  }
  booksDB.push(bookObj);
}

//booksDB = util.shuffleArray(booksDB);


export default {

  getBooks: () => {
    let books = booksDB.slice(0);
    return new Promise((resolve, reject) => {
      resolve(books);
    })
  },

  getLastBooks: (limit, desc = false) => {
    limit = (Number(limit) || 0);
    let books = booksDB.slice(0);
    books.sort((a, b)=>{
        return a.createdAt > b.createdAt ? -1 : 1;
    });
    books.length = Math.max(0, limit);
    return new Promise((resolve, reject) => {
      resolve(books);
    })
  },

  getSortedBooks(pageIndex, sortBy = null, sortType = 'asc' , limit = 10){
    let items = booksDB.slice(0);
    if (sortBy === 'author') {

      items.sort((a, b) => {
        return a.author.name.localeCompare(b.author.name);
      });

      if (sortType === 'desc') {
        items.reverse();
      }

    } else if (sortBy === 'title') {

      items.sort((a, b) => {
        return a.title.localeCompare(b.title);
      });

      if (sortType === 'desc') {
        items.reverse();
      }

    } else if (sortBy === 'date') {
      items.sort((a, b)=>{
        return a.createdAt > b.createdAt ? 1 : -1;
      });
      if (sortType === 'desc') {
        items.reverse();
      }
    }

    limit = Math.max(0,limit);
    let pagesCount = Math.ceil(booksDB.length / limit);
    pageIndex = Math.min(Math.max(1,pageIndex),pagesCount);
    let firstElementIndex = (pageIndex-1) * limit;
    items = items.slice(firstElementIndex, firstElementIndex + limit);

    return new Promise((resolve, reject) => {
      resolve({
        items       : items,
        sortBy      : sortBy,
        sortType    : sortType,
        itemsCount  : booksDB.length,
        pagesCount  : pagesCount,
        currentPage : pageIndex,
      });
    })
  },

  getBookInfo: (id) => {
    id = (parseInt(id,10) || 0);
    let currentBook = {};
    for (let bookIndex in booksDB) {
      if (booksDB[bookIndex]._id !== id) {
        continue;
      }
      currentBook = booksDB[bookIndex];
    }
    return new Promise((resolve, reject)=>{
      resolve (currentBook);
    });
  },
  
  deleteBook : (id) => {
    id = parseInt(id,10);
    let status = 'fail';
    for (let bookIndex in booksDB) {
      bookIndex = parseInt(bookIndex,10);
      if (booksDB[bookIndex]._id !== id) {
        continue;
      }

      if (booksDB[bookIndex]) {
        booksDB.splice(bookIndex,1);
        status = 'success';
      }
    }

    //
    return new Promise((resolve, reject) => {
      resolve({
        status: status
      });
    });
  },

  getAuthors: (pageIndex, sortBy = null, sortType = 'asc' , limit = 10) => {
    let authors = authorsDB.slice(0);
    if (sortBy === 'author') {

      authors.sort((a, b) => {
        return a.name.localeCompare(b.name);
      });

      if (sortType === 'desc') {
        authors.reverse();
      }
    }

    limit = Math.max(0,limit);
    let pagesCount = Math.ceil(authorsDB.length / limit);
    pageIndex = Math.min(Math.max(1,pageIndex),pagesCount);
    let firstElementIndex = (pageIndex-1) * limit;
    authors = authors.slice(firstElementIndex, firstElementIndex + limit);

    return new Promise((resolve, reject) => {
      resolve({
        items       : authors,
        sortBy      : sortBy,
        sortType    : sortType,
        itemsCount  : authorsDB.length,
        pagesCount  : pagesCount,
        currentPage : pageIndex,
      });
    })
  },

  getAuthorInfo(id){
    id = (parseInt(id,10) || 0);
    let currentAuthor;
    for (let author of authorsDB) {
      if (author._id !== id) {
        continue;
      }
      currentAuthor = author;
    }
    let books = [];
    for (let book of booksDB) {
      if (book.author._id === currentAuthor._id) {
        books.push(book);
      }
    }
    currentAuthor['books'] = books;
    return new Promise((resolve, reject)=>{
      resolve (currentAuthor);
    });
  },
  deleteAuthor: (id) =>{
    id = parseInt(id,10);
    let status = 'fail';
    let currentAuthor = '';
    let booksRemoved = [];

    for (let authorIndex in authorsDB) {
      authorIndex = parseInt(authorIndex, 10);
      if (authorsDB[authorIndex]._id !== id) {
        continue;
      }
      currentAuthor = authorsDB[authorIndex];
      for (let bookIndex in booksDB) {
        bookIndex = parseInt(bookIndex,10);
        if (booksDB[bookIndex].author === currentAuthor) {
          booksRemoved.push(booksDB.splice(bookIndex,1)[0].title);
        }
      }

      if (authorsDB[authorIndex]) {
        authorsDB.splice(authorIndex,1);
        status = 'success';
      }
    }
    return new Promise((resolve, reject) => {
      resolve({
        status: status,
        deletedAuthor: currentAuthor.name,
        deletedBooks : booksRemoved
      });
    });
  }
}