import alt from '../../../clean-react/src/alt';
import booksDB from '../data/books';

class BooksActions {
  constructor (){
    this.generateActions(
      'getAllBooksSuccess',
      'getAllBooksFail',
      'getLastBooksSuccess',
      'getLastBooksFail',
      'getSortedBooksSuccess',
      'getSortedBooksFail',
      'getBookInfoSuccess',
      'getBookInfoFail',
      'deleteBookSuccess',
      'deleteBookFail',

    )
  }

  getAllBooks () {
    booksDB.getBooks().then(data => {
      this.getAllBooksSuccess(data);
    });
    return true;
  }

  getLastBooks (limit) {
    booksDB.getLastBooks(limit).then(data => {
      this.getLastBooksSuccess(data)
    });
    return true;
  }

  getSortedBooks(pageIndex,sortBy,sortType,limit) {
    booksDB.getSortedBooks(pageIndex,sortBy,sortType,limit).then(data => {
      this.getSortedBooksSuccess(data);
    });
    return true;
  }

  getBookInfo (id){
    booksDB.getBookInfo(id).then(data => {
      this.getBookInfoSuccess(data)
    });
    return true;
  }

  deleteBook (id){
    booksDB.deleteBook(id).then(data => {
      this.deleteBookSuccess(data)
    });
    return true;
  }


}

export default alt.createActions(BooksActions)