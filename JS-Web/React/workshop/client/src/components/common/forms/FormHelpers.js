import React,{Component} from 'react';

import FormInputElement from './FormInputElement';

export default class FormHelpers extends Component{

  /**
   * this function gets the error for the element and returns it!
   * if removeElement = true .. it will also remove it from the errors array.
   */
  static getElementError(errors,element,removeElement = true) {
    let elementError = '';
    if (Object.keys(errors).length > 0 && errors[element]) {
      elementError = errors[element];
      if (removeElement) {
        delete errors[element];
      }
    }

    return elementError;
  }

  static handleFormChange (event,stateField) {
    let state = this.state[stateField];
    state[event.target.name] = event.target.value;
    this.setState({ [stateField]: state})
  }

  static extractFormErrorsFromData(data,stateErrors) {
    let errors = stateErrors;

    if (data.errors) {
      Object.keys(data.errors).map(key => errors[key] = data.errors[key]);
    }
    return errors;
  }

  render () {

    let drawElement = () => {
      let result = '';
      if (this.props.elementType === 'input') {
        result = (
          <FormInputElement
            //styles
            formGroupClass={this.props.formGroupClass}
            formItemLabelClass={this.props.formItemLabelClass}
            formElementContainerClass={this.props.formElementContainerClass}
            formElementClass={this.props.formElementClass}
            elementErrorClass={this.props.elementErrorClass}
            //data
            type={this.props.type}
            name={this.props.name}
            placeholder={this.props.placeholder}
            value={this.props.value}
            onChange={this.props.onChange}
            error={this.props.error}

          />
        );
      }

      return result;
    };
    return (
      <div>
        {drawElement()}
      </div>
    )
  }
}