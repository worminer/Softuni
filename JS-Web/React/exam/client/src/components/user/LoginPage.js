import React, {Component} from 'react';

//components
import ShowMessage from './../common/ShowPopupMessage'

//user
import UserActions from '../../actions/UserActions';
import UserStore from '../../stores/UserStore';
import Auth from '../user/Auth';

//forms
import FormHelpers from '../common/forms/FormHelpers';
import Form from '../common/forms/Form';
import FormInputElement from '../common/forms/FormInputElement';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
//validation
import validate from '../../utill/validate';


export default class LoginPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      user: {
        email: 'worminer@gmail.com',
        password: '',
      },
      errors: {},

    };

    this.handleLoginResponse = this.handleLoginResponse.bind(this);
    UserStore.on(UserStore.eventTypes.USER_LOGGED, this.handleLoginResponse);
  }

  componentWillUnmount() {
    UserStore.removeListener(UserStore.eventTypes.USER_LOGGED,
        this.handleLoginResponse);
  }

  handleLoginResponse(data) {
    let errors = FormHelpers.extractFormErrorsFromData(data);
    console.log(errors);
    if (!data.success) {
      errors['message'] = {
        message: data.message,
        displayed: false,
      };
      this.setState({
        errors: errors,
      });
    } else {
      Auth.authenticateUser(data.token);
      Auth.setUser(data.user);
      ShowMessage.success(data.message);

      this.props.history.push('/user/home');
    }

  }

  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'user');
  }

  handleUserLogin(event) {
    event.preventDefault();
    if (!this.validateUserData()) {
      return;
    }
    this.setState({errors: {}});//if form validation passed.. clear errors
    UserActions.login(this.state.user);
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

    //validate passwords
    let isPasswordValid = validate.password(user.password);
    if (isPasswordValid !== true) {
      isFormValid = false;
      errors['password'] = {
        message: isPasswordValid,
        displayed: false,
      };
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
    let errors = this.state.errors || [];
    // get errors for all inputs

    let emailErr = FormHelpers.getElementError(errors, 'email');
    let passwordErr = FormHelpers.getElementError(errors, 'password');

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
              onSubmit={this.handleUserLogin.bind(this)}
              // errors
              errors={errorMessagesLeft}
              //form style config
              formClass="
          col-md-6 col-md-offset-3
          col-sm-8 col-sm-offset-2
          col-xs-10 col-xs-offset-1
          well flipInX animated"
              formLegend="Login"
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
                //input password
                //data
                elementType='input'
                error={passwordErr}
                type='password'
                name='password'
                placeholder='Password'
                value={this.state.user.password}
                onChange={this.handleFormChange.bind(this)}
                //styles
                formGroupClass={emailErr ? 'has-error' : ''}
                formItemLabelClass='col-md-4'
                formElementContainerClass='col-md-8'
                elementErrorClass='text-danger formFieldErrorText well well-sm'
            />

            <div className="form-group">
              <FormButtonSubmit
                  containerClass="col-md-6 col-lg-offset-4"
                  className='btn-primary'
                  text="Login"
              />
            </div>
          </Form>
        </section>
    );
  }
}