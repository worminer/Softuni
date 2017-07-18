import {Component} from 'react';
import Auth from './Auth';

export default class LogoutPage extends Component{
  componentWillMount() {
    Auth.deauthenticateUser();
    Auth.removeUser();
    this.props.history.push('/user/login');
  }
  render () {
    return null;
  }
}