import React,{Component} from 'react';
import {Link} from 'react-router-dom';
import Auth from  './../user/Auth';
import UserStore from  './../../stores/UserStore';

export default class Header extends Component{
  constructor(props) {
    super(props);

    this.state = {
      username : Auth.getUser().name
    };

    this.handleUserLoggedIn = this.handleUserLoggedIn.bind(this);

    UserStore.on(UserStore.eventTypes.USER_LOGGED,this.handleUserLoggedIn)
  }
  
  componentWillUnmount() {
    UserStore.removeListener(UserStore.eventTypes.USER_LOGGED, this.handleUserLoggedIn);
  }

  handleUserLoggedIn(data) {
    if (data.success) {
      this.setState({
        username: data.user.name
      })
    }
  }
  
  
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
            { Auth.isUserAuthenticated() ? (
              <ul className="nav navbar-nav">
                <li>
                  <Link to={'/hotels/add'}>Add Hotel</Link>
                </li>
              </ul>
            ) : ''}

              { Auth.isUserAuthenticated() ? (
                <ul className="nav navbar-nav navbar-right">
                  <li>
                    <Link to={'/user/profile'}>{this.state.username ? `Wellcome ${this.state.username}` : 'Profile'}</Link>
                  </li>
                  <li>
                    <Link to={'/user/logout'}>Logout</Link>
                  </li>
                </ul>
                ) : (
              <ul className="nav navbar-nav navbar-right">
                <li>
                  <Link to={'/user/register'}>Register</Link>
                </li>
                <li>
                  <Link to={'/user/login'}>Login</Link>
                </li>
              </ul>
              )}

          </div>
        </div>
      </nav>
    </header>
    )
  }  
}