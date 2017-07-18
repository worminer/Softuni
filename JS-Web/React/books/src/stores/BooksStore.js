import alt from '../../../clean-react/src/alt';
import BooksActions from '../actions/BooksActions';

class BooksStore {
  constructor (){
    this.bindActions(BooksActions);
    this.lastBooks = [];
    this.sortedBooks = [];
    this.paginationConfig = {
      sortBy: "",
      sortType: "",
      itemsCount: 0,
      pagesCount: 0,
      currentPage: 1
    };
    this.bookInfo = {
      _id: '',
      title: '',
      description: '',
      createdAt: '',
      author: {},
      image: '',
      price: '',
      comments: []
    }

  }

  onGetAllBooksSuccess (){
    console.log('Success: getAllBooks')
  };

  onGetAllBooksFail (){
    console.error('ERROR: could not connect to db!')
  };

  onGetLastBooksSuccess (books){
    //console.log('Success:GetLastBooks');
    this.lastBooks = books;
  };

  onGetLastBooksFail (){
    console.error('ERROR: could not connect to db!')
  };

  onGetSortedBooksSuccess (data){
    //console.log('Success:GetSortedBooks');
    let {items, ...paginationConfig} = data;
    this.sortedBooks = items;
    this.paginationConfig = paginationConfig;
  };

  onGetSortedBooksFail (){
    console.error('ERROR: could not connect to db!')
  };

  onGetBookInfoSuccess (bookInfo){
    //console.log('Success:getBookInfo')
    this.bookInfo = bookInfo;
  };

  onGetBookInfoFail (){
    console.error('ERROR: could not connect to db!')
  };

  onDeleteBookSuccess(data){
    if (data.status === 'fail') {
      console.log('Book Not Deleted!')
    } else if (data.status === 'success') {
      console.log('Book Deleted.')
    }
  }
  onDeleteBookFail () {
    console.error('ERROR: could not connect to db!')
  }
}

export default alt.createStore(BooksStore);