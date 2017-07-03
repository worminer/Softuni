import React, {Component} from 'react';

//components
import Pagination from './Sub-Components/Pagination';
import SortByBtn from './Sub-Components/SortByBtn';
//data
import data from '../data/books';

export default class BooksPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      books : [],
      paginationConfig: {},
    };
  }

  componentDidMount() {
    this.getPageItems(this.props);
  }

  getPageItems (props) {
    const itemsPerPage = 10; // change to 10
    let pageParams = props.match.params;
    let currentPage = (parseInt(pageParams.page,10) || 1);
    let sortBy = (pageParams.sortBy || '');
    let sortType = (pageParams.sortType || '');

    data.getSortedBooks(currentPage,sortBy, sortType,itemsPerPage).then(books => {
      let {items, ...paginationConfig} = books;
      
      this.setState({
        books : items,
        paginationConfig: paginationConfig,
      });
    });
  }

  componentWillReceiveProps(props) {
    this.getPageItems(props);
  }

  render () {

    let books = this.state.books.map(book => (
        <tr key={book._id}>
          <td>{book._id}</td>
          <td>{book.title}</td>
          <td>{book.author.name}</td>
          <td>{book.createdAt}</td>
          <td>{book.price} лв.</td>
        </tr>
    ));

    return (
      <section className="row">
        <table className="table table-striped table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>
              <SortByBtn
                sortBy={'title'}
                urlPattern={this.props.match.path}
                page={this.state.paginationConfig.currentPage}
                currentSortBy={this.state.paginationConfig.sortBy}
                sortType={this.state.paginationConfig.sortType}
              />
            </th>
            <th>
              <SortByBtn
                sortBy={'author'}
                urlPattern={this.props.match.path}
                page={this.state.paginationConfig.currentPage}
                currentSortBy={this.state.paginationConfig.sortBy}
                sortType={this.state.paginationConfig.sortType}
              />
            </th>
            <th>
              Date Added
              <SortByBtn
                sortBy={'date'}
                urlPattern={this.props.match.path}
                page={this.state.paginationConfig.currentPage}
                currentSortBy={this.state.paginationConfig.sortBy}
                sortType={this.state.paginationConfig.sortType}
              />
            </th>
            <th>Price</th>
          </tr>
          </thead>
          <tbody>
          {books}
          </tbody>
        </table>
        <div className="text-center">
          <Pagination
              ulClasses = 'pagination pagination-sm'
              activePageLiClass = 'active'
              disabledPageLiClass = 'disabled'
              pagesCount = {this.state.paginationConfig.pagesCount}
              urlPattern = {this.props.match.path}
              currentPage = {this.state.paginationConfig.currentPage}
              sortBy = {this.state.paginationConfig.sortBy}
              sortType = {this.state.paginationConfig.sortType}
              forwardArrowText = '&raquo;'
              backwardArrowText = '&laquo;'
          />
        </div>
      </section>
    )
  }
}