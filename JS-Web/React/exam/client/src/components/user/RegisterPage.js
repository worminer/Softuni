import React, {Component} from 'react';

//user
import ShowMessage from './../common/ShowPopupMessage';
import UserActions from '../../actions/UserActions';
import UserStore from '../../stores/UserStore';
//forms
import FormHelpers from '../common/forms/FormHelpers';
import Form from '../common/forms/Form';
import FormInputElement from '../common/forms/FormInputElement';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
//validation
import validate from '../../utill/validate';

export default class RegisterPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      user: {
        email: '',
        name: '',
        password: '',
        confirmPassword: '',
      },
      errors: {},

    };

    this.handleRegistrationResponse = this.handleRegistrationResponse.bind(
        this);
    UserStore.on(UserStore.eventTypes.USER_REGISTERED,
        this.handleRegistrationResponse);
  }

  componentWillUnmount() {
    UserStore.removeListener(UserStore.eventTypes.USER_REGISTERED,
        this.handleRegistrationResponse);
  }

  handleRegistrationResponse(data) {
    this.setState({errors: {}});//clear errors
    let errors = FormHelpers.extractFormErrorsFromData(data, this.state.errors);

    if (!data.success) {
      errors['message'] = {
        message: data.message,
        displayed: false,
      };
      this.setState({
        errors: errors,
      });
    } else {
      ShowMessage.success(data.message);
      this.props.history.push('/user/login');
    }

  }

  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'user');
  }

  handleUserRegistration(event) {
    event.preventDefault();
    if (!this.validateUserData()) {
      return;
    }
    //this.setState({errors: {}});//if form validation passed.. clear errors
    UserActions.register(this.state.user);

  }

  validateUserData() {
    const user = this.state.user;
    let isFormValid = true;
    let errors = {};
    // validate email
    let isValidEmail = validate.email(user.email);
    if (isValidEmail !== true) {
      isFormValid = false;
      errors['email'] = {
        message: isValidEmail,
        displayed: false,
      };
    }
    // validate name
    let isNameVlid = validate.name(user.name);
    if (isNameVlid !== true) {
      isFormValid = false;
      errors['name'] = {
        message: isNameVlid,
        displayed: false,
      };
    }

    //validate passwords
    let isPasswordValid = validate.password(user.password);
    let isConfirmPasswordValid = validate.password(user.confirmPassword);

    let arePasswordsMatching = validate.passwordsMatch(user.password, user.confirmPassword);
    if (isPasswordValid !== true) {
      isFormValid = false;
      errors['password'] = {
        message: isPasswordValid,
        displayed: false,
      };
    }

    if (isConfirmPasswordValid !== true) {
      isFormValid = false;
      errors['confirmPassword'] = {
        message: isConfirmPasswordValid,
        displayed: false,
      };
    }

    if (isPasswordValid === true || isConfirmPasswordValid === true) {
      if (arePasswordsMatching !== true) {
        isFormValid = false;
        errors['password'] = {
          message: arePasswordsMatching,
          displayed: false,
        };
        errors['confirmPassword'] = {
          message: arePasswordsMatching,
          displayed: false,
        };
      }
    }

    if (Object.keys(errors).length > 0) {
      errors['formError'] = {
        message: 'Check the form for errors.',
        displayed: false,
      };
      this.setState({
        errors,
      });
    }

    return isFormValid;
  }

  render() {
    let errors = this.state.errors || {};

    // get errors for all inputs
    let emailErr = FormHelpers.getElementError(errors, 'email');
    let nameErr = FormHelpers.getElementError(errors, 'name');
    let passwordErr = FormHelpers.getElementError(errors, 'password');
    let confirmPasswordErr = FormHelpers.getElementError(errors,'confirmPassword');


    // prepare to display all other errors
    let errorMessagesLeft = Object.keys(errors).map(key => {
      if (errors[key].displayed === false) {
        return (<div key={key} className='' >{errors[key].message}</div>);
      }
      return '';
    }).filter(e => e !== '');

    return (
      <section className="row">
        <Form
            //data
            formErrorBoxClass="text-danger well"
            // callbacks
            onChange={this.handleFormChange.bind(this)}
            onSubmit={this.handleUserRegistration.bind(this)}
            // errors
            errors={errorMessagesLeft}
            //form style config
            formClass="
        col-md-6 col-md-offset-3
        col-sm-8 col-sm-offset-2
        col-xs-10 col-xs-offset-1
        well flipInX animated"

            formLegend="Register"
        >
          <FormInputElement
              //input email
              //data
              error={emailErr}
              type='email'
              name='email'
              placeholder='E-mail'
              value={this.state.user.email}
              onChange={this.handleFormChange.bind(this)}
              //styles
              formGroupClass={emailErr ? 'has-error' : ''}
              formItemLabelClass='col-md-4'
              formElementContainerClass='col-md-8'
              elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
              //input name
              //data
              error={nameErr}
              type='text'
              name='name'
              placeholder='Name'
              value={this.state.user.name}
              onChange={this.handleFormChange.bind(this)}
              //styles
              formGroupClass={nameErr ? 'has-error' : ''}
              formItemLabelClass='col-md-4'
              formElementContainerClass='col-md-8'
              elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
              //input password
              //data
              error={passwordErr}
              type='password'
              name='password'
              placeholder='Password'
              value={this.state.user.password}
              onChange={this.handleFormChange.bind(this)}
              //styles
              formGroupClass={passwordErr ? 'has-error' : ''}
              formItemLabelClass='col-md-4'
              formElementContainerClass='col-md-8'
              elementErrorClass='text-danger formFieldErrorText well well-sm'
          />
          <FormInputElement
              //input confirm password
              //data
              error={confirmPasswordErr}
              type='password'
              name='confirmPassword'
              placeholder='Confirm Password'
              value={this.state.user.confirmPassword}
              onChange={this.handleFormChange.bind(this)}
              //styles
              formGroupClass={confirmPasswordErr ? 'has-error' : ''}
              formItemLabelClass='col-md-4'
              formElementContainerClass='col-md-8'
              elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <div className="form-group">
            <FormButtonSubmit
                containerClass="col-md-8 col-md-offset-4"
                className='btn-success'
                text="Register"
            />
          </div>
        </Form>
      </section>

    );
  }
}