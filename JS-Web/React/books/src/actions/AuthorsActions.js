import alt from '../../../clean-react/src/alt';
import bookDB from '../data/books';

class AuthorsActions {
  constructor (){
    this.generateActions(
      'getAllAuthorsSuccess',
      'getAllAuthorsFail',
      'getAuthorInfoSuccess',
      'getAuthorInfoFail',
      'deleteAuthorSuccess',
      'deleteAuthorFail',
    )
  }

  getAllAuthors (currentPage,sortBy, sortType,itemsPerPage) {
    bookDB.getAuthors(currentPage,sortBy, sortType,itemsPerPage).then(data => {
      this.getAllAuthorsSuccess(data);
    });
    return true;
  }

  getAuthorInfo (id) {
    bookDB.getAuthorInfo(id).then(data => {
      this.getAuthorInfoSuccess(data)
    });
    return true;
  }

  deleteBook(targetId) {
    bookDB.deleteAuthor(targetId).then(data => {
      this.deleteAuthorSuccess(data)
    });
    return true;
  }
}

export default alt.createActions(AuthorsActions);