import React,{Component} from 'react';
import FormHelpers from './../common/forms/FormHelpers'

export default class LoginForm extends Component {

  render () {
    let errors = this.props.errors || [];
    // get errors for all inputs

    let emailErr = FormHelpers.getElementError(errors,'email');
    let passwordErr = FormHelpers.getElementError(errors,'password');


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
            formGroupClass = {this.props.formGroupClass}
            formItemLabelClass = {this.props.formItemLabelClass}
            formElementContainerClass = {this.props.formElementContainerClass}
            formElementClass = {this.props.formElementClass}
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
            formGroupClass = {this.props.formGroupClass}
            formItemLabelClass = {this.props.formItemLabelClass}
            formElementContainerClass = {this.props.formElementContainerClass}
            formElementClass = {this.props.formElementClass}
            elementErrorClass={this.props.elementErrorClass}
          />

          <div className="form-group">
            <div className="col-md-6 col-lg-offset-4">
              <button
                //TODO: make component
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
