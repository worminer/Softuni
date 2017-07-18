import React,{Component} from 'react';

export default class FormInputElement extends Component{
  render () {
    let type = this.props.type || 'text';
    let formGroupClass ='form-group ' + (this.props.formGroupClass || '');
    let formItemLabelClass = 'control-label ' + (this.props.formItemLabelClass || '');
    let formElementClass = 'form-control ' + (this.props.formElementClass || '');

    let errorMessageBox = '';
    if (this.props.error && this.props.error !=='') {
      errorMessageBox = (
        <div className={this.props.elementErrorClass}>{this.props.error}</div>
      );
    }

    return (
      <div className={formGroupClass}>
        <label
          className={formItemLabelClass}
          htmlFor={this.props.name}
        >
          {this.props.placeholder}
        </label>
        <div className={this.props.formElementContainerClass}>
          <input
            className={formElementClass}
            type={type}
            name={this.props.name}
            id={this.props.name}
            placeholder={this.props.placeholder}
            value={this.props.value}
            onChange={this.props.onChange}
          />
          {errorMessageBox}
        </div>
      </div>

    )
  }
}