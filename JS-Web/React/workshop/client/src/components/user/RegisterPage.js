import React,{Component} from 'react';

import ShowMessage from './../common/ShowPopupMessage';
import FormHelpers from './../common/forms/FormHelpers';
import RegisterForm from './RegisterForm';
import UserActions from '../../actions/UserActions';
import UserStore from '../../stores/UserStore';

export default class RegisterPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      user: {
        email: '',
        name: '',
        password: '',
        confirmPassword : ''
      },
      errors: []

    };

    this.handleRegistrationResponse = this.handleRegistrationResponse.bind(this);
    UserStore.on(UserStore.eventTypes.USER_REGISTERED,this.handleRegistrationResponse);
  }

  componentWillUnmount() {
    UserStore.removeListener(UserStore.eventTypes.USER_REGISTERED, this.handleRegistrationResponse);
  }



  handleRegistrationResponse (data) {
    let errors = FormHelpers.extractFormErrorsFromData(data,this.state.errors);

    if (!data.success) {
      errors['message'] = data.message;
      this.setState({
        errors: errors
      })
    } else {
      ShowMessage.success(data.message);
      this.props.history.push('/user/login');
    }

  }

  handleFormChange (event) {
    FormHelpers.handleFormChange.bind(this)(event, 'user');
  }

  handleUserRegistration (event) {
    event.preventDefault();
    if(!this.validateUserData()) {
      return;
    }

    UserActions.register(this.state.user);
  }

  validateUserData() {
    const user = this.state.user;
    let isFormValid = true;
    let errors = this.state.errors;

    if (user.password !== user.confirmPassword) {
      errors['password'] = 'Passwords mismatch!';
      isFormValid = false;
    } else {
      errors['password']= '';
    }

    if (Object.keys(errors).length > 0) {
      this.setState({
        errors
      });
    }

    return isFormValid;
  }
  render () {
    return (
      <RegisterForm
        //form style config
        formClass="form-horizontal col-md-6 col-lg-offset-3"
        formLegend="Registration"
        errorBoxMessageClass = 'errorBoxMessage'
        elementErrorClass="formFieldErrorText bg-danger"
        //data
        user={this.state.user}
        // callbacks
        onChange={this.handleFormChange.bind(this)}
        onSave={this.handleUserRegistration.bind(this)}
        // errors
        errors={this.state.errors}
      />

        
    )
  }
}