import React,{Component} from 'react';
import FormHelpers from './../common/forms/FormHelpers'

export default class RegisterForm extends Component {

  render () {
    let errors = this.props.errors || [];
    // get errors for all inputs

    let emailErr = FormHelpers.getElementError(errors,'email');
    let nameErr = FormHelpers.getElementError(errors,'name');
    let passwordErr = FormHelpers.getElementError(errors,'password');
    let confirmPasswordErr = FormHelpers.getElementError(errors,'confirmPassword');


    // prepare to display all other errors

    let errorMessagesLeft = Object.keys(errors).map(key => {
      if (errors[key]) {
        return (
          <div key={key} className={this.props.errorBoxMessageClass}>{errors[key]}</div>
        );
      }
      return '';
    });

    return (
      <form className={this.props.formClass}>
        <fieldset>
          <legend>{this.props.formLegend}</legend>

          <div className="bg-danger">{errorMessagesLeft}</div>
          <FormHelpers
            //input email
            //data
            elementType = 'input'
            error={emailErr}
            type='email'
            name='email'
            placeholder='E-mail'
            value={this.props.user.email}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <FormHelpers
            //input name
            //data
            elementType = 'input'
            error={nameErr}
            type='text'
            name='name'
            placeholder='Name'
            value={this.props.user.name}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <FormHelpers
            //input password
            //data
            elementType = 'input'
            error={passwordErr}
            type='password'
            name='password'
            placeholder='Password'
            value={this.props.user.password}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <FormHelpers
            //input password
            //data
            elementType = 'input'
            error={confirmPasswordErr}
            type='password'
            name='confirmPassword'
            placeholder='Confirm Password'
            value={this.props.user.confirmPassword}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <div className="form-group">
            <div className="col-md-6 col-lg-offset-4">
              <button
                //TODO: this button suld be a component
                type="submit"
                className="btn btn-primary"
                onClick={this.props.onSave}
              >
                Submit
              </button>
            </div>
          </div>

        </fieldset>
      </form>
    )
  }
}
