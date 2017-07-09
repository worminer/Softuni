import React, {Component} from 'react';
import {Link} from "react-router-dom";
// components
import Pagination from './Sub-Components/Pagination';
import SortByBtn from './Sub-Components/SortByBtn';
//booksDB
import AuthorActions from '../actions/AuthorsActions';
import AuthorStore from '../stores/AuthorsStore';


export default class AuthorsPage extends Component{
  constructor(props) {
    super(props);

    this.state = AuthorStore.getState();

    this.onChange = this.onChange.bind(this);
    this.onDelete = this.onDelete.bind(this);
  }

  onChange(state){
    //to prevent setState() before component mount
    if (this.refs.root) {
      this.setState(state);
    }
  }

  componentDidMount() {
    AuthorStore.listen(this.onChange);

    this.getPageItems(this.props);
  }
  componentWillUnMount() {
    AuthorStore.unlisten(this.onChange);
  }

  componentWillReceiveProps(props) {
    this.getPageItems(props);
  }

  getPageItems (props) {
    const itemsPerPage = 10; // change to 10
    let pageParams = props.match.params;
    let currentPage = (parseInt(pageParams.page,10) || 1);
    let sortBy = (pageParams.sortBy || '');
    let sortType = (pageParams.sortType || '');

    AuthorActions.getAllAuthors(currentPage,sortBy, sortType,itemsPerPage);
  }

  onDelete(event){
    let targetId = event.target.parentNode.parentNode.attributes.id.textContent;
    AuthorActions.deleteBook(targetId);
    this.getPageItems(this.props)
  }

  render () {
    let authorsRows = this.state.allAuthors.map(author => {
      return (
        <tr key={author._id} id={author._id}>
          <td>{author._id}</td>
          <td><img src={author.picture} alt="" style={{'height' : '20px'}}/></td>
          <td><Link to={`/author/${author._id}`}>{author.name}</Link></td>
          <td><button className="btn btn-xs btn-danger" onClick={this.onDelete}>Delete</button></td>
        </tr>
      );
    });

    return (
        <section className="row" ref='root'>
          <table className="table table-striped table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Picture</th>
              <th>
                Name (
                <SortByBtn
                  sortBy={'author'}
                  urlPattern={this.props.match.path}
                  page={this.state.paginationConfig.currentPage}
                  currentSortBy={this.state.paginationConfig.sortBy}
                  sortType={this.state.paginationConfig.sortType}
                />
                )
              </th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            {authorsRows}
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