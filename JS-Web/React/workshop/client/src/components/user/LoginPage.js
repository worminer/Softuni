import React,{Component} from 'react';

import ShowMessage from './../common/ShowPopupMessage'

import LoginForm from './LoginForm';

import UserActions from '../../actions/UserActions';
import UserStore from '../../stores/UserStore';
import FormHelpers from "../common/forms/FormHelpers";
import Auth from '../user/Auth';


export default class RegisterPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      user: {
        email: 'test@abv.bg',
        password: '',
      },
      errors: []

    };

    this.handleLoginResponse = this.handleLoginResponse.bind(this);
    UserStore.on(UserStore.eventTypes.USER_LOGGED,this.handleLoginResponse)
  }

  componentWillUnmount() {
    UserStore.removeListener(UserStore.eventTypes.USER_LOGGED, this.handleLoginResponse);
  }

  handleLoginResponse (data) {
    let errors = FormHelpers.extractFormErrorsFromData(data,this.state.errors);

    if (!data.success) {
      errors['message'] = data.message;
      this.setState({
        errors: errors
      })
    } else {
      Auth.authenticateUser(data.token);
      Auth.setUser(data.user);
      ShowMessage.success(data.message);
    }

  }

  handleFormChange (event) {
    FormHelpers.handleFormChange.bind(this)(event, 'user');
  }

  handleUserLogin (event) {
    event.preventDefault();
    if(!this.validateUserData()) {
      return;
    }

    UserActions.login(this.state.user);
  }

  validateUserData() {
    return true;

    // const user = this.state.user;
    // let isFormValid = true;
    // let errors = this.state.errors;

    //TODO: validate form
    // if (user.password !== user.confirmPassword) {
    //   errors['password'] = 'Passwords mismatch!';
    //   isFormValid = false;
    // } else {
    //   errors['password']= '';
    // }

    // if (Object.keys(errors).length > 0) {
    //   this.setState({
    //     errors
    //   });
    // }
    //
    // return isFormValid;
  }

  render () {
    return (
      <LoginForm
        //form style config
        formClass="form-horizontal col-md-6 col-lg-offset-3"
        formLegend="Login"
        errorBoxMessageClass = 'errorBoxMessage'
        elementErrorClass="formFieldErrorText bg-danger"
        //data
        user={this.state.user}
        // callbacks
        onChange={this.handleFormChange.bind(this)}
        onSave={this.handleUserLogin.bind(this)}
        // errors
        errors={this.state.errors}
      />


    )
  }
}