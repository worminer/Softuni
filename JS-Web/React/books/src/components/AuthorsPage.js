import React, {Component} from 'react';
import {Link} from "react-router-dom";
// components
import Pagination from './Sub-Components/Pagination';
import SortByBtn from './Sub-Components/SortByBtn';
//data
import data from '../data/books';

export default class BooksPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      authors : [],
      paginationConfig: {}
    };
  }

  componentDidMount() {
    this.getPageItems(this.props);
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

    data.getAuthors(currentPage,sortBy, sortType,itemsPerPage).then(authors => {
      let {items, ...config} = authors;
      this.setState({
        authors: items,
        paginationConfig:config,
      });
    });
  }



  render () {
    let authorRows = this.state.authors.map(author => {
      return (
        <tr key={author._id}>
          <th>{author._id}</th>
          <th><img src={author.picture} alt="" style={{'height' : '20px'}}/></th>
          <th><Link to={`/author/${author._id}`}>{author.name}</Link></th>
        </tr>
      );
    });

    return (
        <section className="row">
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
            </tr>
            </thead>
            <tbody>
            {authorRows}
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