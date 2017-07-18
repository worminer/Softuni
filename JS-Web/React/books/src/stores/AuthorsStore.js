import alt from '../../../clean-react/src/alt';
import AuthorActions from '../actions/AuthorsActions';

class AuthorsStore {
  constructor (){
    this.bindActions(AuthorActions);
    this.allAuthors = [];
    this.authorInfo = {
      _id: '',
      name: "",
      picture: "",
      books: []
    };
    this.paginationConfig = {};
  }

  onGetAllAuthorsSuccess (authors){
    //console.log('Success: getAllAuthors');
    let {items, ...paginationConfig} = authors
    this.allAuthors = items;
    this.paginationConfig = paginationConfig;
  };

  onGetAllAuthorsFail (){
    console.error('ERROR: could not connect to db!')
  };
  onGetAuthorInfoSuccess (author){
    //console.log('Success: Get Author Info')
    this.authorInfo = author;
  };

  onGetAuthorInfoFail (){
    console.error('ERROR: could not connect to db!')
  };

  onDeleteAuthorSuccess (data) {
    if (data.status === 'fail') {
      console.log('Error: Author is not Deleted')
    } else if (data.status === 'success') {
      console.log(`Success: ${data.deletedAuthor} deleted successfully`);
      if (data.deletedBooks.length !== 0) {
        console.log(`BooksRemoved: ${data.deletedBooks.join(', ')}`)
      } else {
        console.log(`BooksRemoved: Don't Have Books`)
      }

    }
  }

  onDeleteAuthorFail () {
    console.error('ERROR: could not connect to db!')
  }

}

export default alt.createStore(AuthorsStore);