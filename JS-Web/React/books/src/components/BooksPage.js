import React, {Component} from 'react';
//components
import Pagination from './Sub-Components/Pagination';
import SortByBtn from './Sub-Components/SortByBtn';
//booksDB
import BooksStore from '../stores/BooksStore';
import BooksActions from '../actions/BooksActions';
import {Link} from "react-router-dom";

export default class BooksPage extends Component{
  constructor(props) {
    super(props);

    this.state = BooksStore.getState();
    //bind that mofo
    this.onChange = this.onChange.bind(this);
    this.onDelete = this.onDelete.bind(this);
  }

  onChange(state) {
    //to prevent setState() before component mount
    if (this.refs.root) {
      this.setState(state);
    }
  }

  componentDidMount() {
    BooksStore.listen(this.onChange);

    this.getPageItems(this.props)

  }

  componentWillUnMount() {
    BooksStore.unlisten(this.onChange);
  }

  getPageItems (props) {

    const itemsPerPage = 10; // change to 10
    let pageParams = props.match.params;
    let currentPage = (parseInt(pageParams.page,10) || 1);
    let sortBy = (pageParams.sortBy || '');
    let sortType = (pageParams.sortType || '');

    BooksActions.getSortedBooks(currentPage,sortBy, sortType,itemsPerPage);
  }

  componentWillReceiveProps(props) {
    console.log('recieving props')
    //this.getPageItems(props);
  }
  
  onDelete(event){
    //$(event.target).parent().parent().attr('id') // for jq
    let targetId = event.target.parentNode.parentNode.attributes.id.textContent;
    BooksActions.deleteBook(targetId);
    this.getPageItems(this.props)
  }

  render () {

    let books = this.state.sortedBooks.map(book => (
        <tr key={book._id} id={book._id}>
          <td>{book._id}</td>
          <td><Link to={`/book/${book._id}`}>{book.title}</Link></td>
          <td><Link to={`/author/${book.author._id}`}>{book.author.name}</Link></td>
          <td>{book.createdAt}</td>
          <td>{book.price} лв.</td>
          <td><button onClick={this.onDelete} className="btn btn-xs btn-danger">delete</button></td>
        </tr>
    ));

    return (
      <section className="row" ref='root'>
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
            <th>Actions</th>
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