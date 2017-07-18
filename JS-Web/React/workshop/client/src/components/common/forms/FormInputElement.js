import React,{Component} from 'react';

export default class FormInputElement extends Component{
  render () {
    // by default all the forms will be configured to use Bootstrap classes .
    let type = this.props.type || 'text';
    let formGroupClass = this.props.formGroupClass || 'form-group';
    let formItemLabelClass = this.props.formItemLabelClass || 'col-md-4 control-label';
    let formElementContainerClass = this.props.formElementContainerClass || 'col-md-8';
    let formElementClass = this.props.formElementClass || 'form-control';
    let elementErrorClass = this.props.elementErrorClass || 'bg-danger';

    let errorMessage = () => {
      let errorElement = '';
      if (this.props.error) {
        errorElement = (
          <div className={elementErrorClass}>{this.props.error}</div>
        );
      }
      return errorElement;
    };
    return (
      <div className={formGroupClass}>
        <label
          className={formItemLabelClass}
          htmlFor={this.props.name}
        >
          {this.props.placeholder}
        </label>
        <div className={formElementContainerClass}>
          <input
            className={formElementClass}
            type={type}
            name={this.props.name}
            placeholder={this.props.placeholder}
            value={this.props.value}
            onChange={this.props.onChange}
          />
          {errorMessage()}
        </div>
      </div>

    )
  }
}