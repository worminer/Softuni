import React,{Component} from 'react';
import {Link} from 'react-router-dom';

export default class SortByBtn extends Component{
  render () {
    let urlPattern = this.props.urlPattern;
    let currentPage = this.props.page;
    let currentSortBy = this.props.currentSortBy;
    let sortBy = this.props.sortBy;
    let sortType = this.props.sortType;
    let newSortType = 'asc';
    if (sortType !== 'desc' && currentSortBy === sortBy) {
      newSortType = 'desc';
    } else {
      newSortType = 'asc';
    }

    let fillPatternUrl = (urlPattern, urlElementObj) => {
      let url = (urlPattern || '');

      for (let element in urlElementObj) {
        let regex = new RegExp(`:${element}[?]`,'g');
        url = url.replace(regex, urlElementObj[element]);
      }
      let regex = new RegExp(`(/|):[^?]+[?](/|)`,'g');
      url = url.replace(regex, '');
      return url
    };
    let linkConfig = {
      page: currentPage
    };

    if (sortBy && sortBy !== '') {
        linkConfig['sortBy'] = sortBy;
      linkConfig['sortType'] = newSortType;
    }

    return (
      <span>sort:
        <Link to={fillPatternUrl(urlPattern,linkConfig)}>
          {newSortType.toString().toUpperCase()}
        </Link>
      </span>

    )
  }
}