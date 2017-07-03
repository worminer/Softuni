import React,{Component} from 'react';
import {Link} from 'react-router-dom';

export default class Header extends Component{
  render () {
    return (
    <header>
      <nav className="navbar navbar-default">
        <div className="container">
          <div className="navbar-header">
            <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span className="sr-only">Toggle navigation</span>
              <span className="icon-bar"></span>
              <span className="icon-bar"></span>
              <span className="icon-bar"></span>
            </button>
            <Link className="navbar-brand" to={'/'}>Home</Link>
          </div>

          <div className="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul className="nav navbar-nav">
              <li className="active">
                <Link to={`/books/all`}>Books <span className="sr-only">(current)</span></Link>
              </li>
              <li>
                <Link to={`/authors/`}>Authors</Link>
              </li>
              <li>
                <Link to={{pathname:'/books/all/2', }} >test</Link>
              </li>
            </ul>

            <ul className="nav navbar-nav navbar-right">
              <li>
                <Link to={'/'}>Right</Link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    )
  }
}