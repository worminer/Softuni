import React,{Component} from 'react';
import {Link} from 'react-router-dom';

export default class BootstrapPagination extends Component{

  render () {  
    let urlPattern = this.props.urlPattern;
    let currentPage = this.props.currentPage;
    let pagesCount = this.props.pagesCount;
    let sortBy = this.props.sortBy;
    let sortType = this.props.sortType;

    // finds an url id from the url pattern and changes it
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
    // creating default props..
    let defaultLinkProps = {
      page: currentPage
    };

    if (sortBy !== '') {
      defaultLinkProps['sortBy'] = sortBy;
      if (sortType !== '') {
        defaultLinkProps['sortType'] = sortType;
      }
    }
    let backArrow = () => {
      defaultLinkProps['page'] = Math.max(currentPage - 1,1);
      let disabledPageLiClass = this.props.disabledPageLiClass; // for some reason this has to be a local variable

      return (
          <li className={currentPage <= 1 ? disabledPageLiClass :''}>
            <Link
                to={fillPatternUrl(urlPattern,defaultLinkProps)}
            >
              {this.props.backwardArrowText}
            </Link>
          </li>
      )
    };
    let forwardArrow = () => {
      defaultLinkProps['page'] = Math.min(currentPage + 1,(pagesCount || 1));
      let disabledPageLiClass = this.props.disabledPageLiClass;// for some reason this has to be a local variable

      return (
          <li className={currentPage >= pagesCount ? disabledPageLiClass :''}>
            <Link
                to={fillPatternUrl(urlPattern,defaultLinkProps)}
            >{this.props.forwardArrowText}</Link>
          </li>
      )
    };

    let pages = () => {
      let buttons = []; // will hold all the links for the pages

      for (let i = 1; i <= this.props.pagesCount; i++) {

        defaultLinkProps['page'] = i; // set the the page number for this link
        let activeLiClass = this.props.activePageLiClass; // set the class name used for the current active link
        //push the current link
        buttons.push((
            <li
                key={i}
                className={(currentPage === i ? activeLiClass : '')}
            >
              <Link to={fillPatternUrl(urlPattern,defaultLinkProps)}>
                {i}
              </Link>
            </li>
        ));
      }

      return buttons;
    };


    return (
      <ul className={this.props.ulClasses}>
        {backArrow()}
        {pages()}
        {forwardArrow()}
      </ul>
    )
  }
}