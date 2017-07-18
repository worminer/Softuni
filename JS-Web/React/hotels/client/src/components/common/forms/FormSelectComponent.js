import React,{Component} from 'react';

export default class FormSelectComponent extends Component{
  render () {
    let formGroupClass ='form-group ' + (this.props.formGroupClass || '');
    let formItemLabelClass = 'control-label ' + (this.props.formItemLabelClass || '');
    let formElementClass = 'form-control ' + (this.props.formElementClass || '');
    let multiple = [];
    multiple.push();
    let errorMessageBox = '';
    if (this.props.error && this.props.error !=='') {
      errorMessageBox = (
        <div className={this.props.elementErrorClass}>{this.props.error}</div>
      );
    }
    return (
      <div className={formGroupClass}>
        <label
          htmlFor={this.props.name}
          className={formItemLabelClass}
        >
          {this.props.placeholder}
        </label>
        <div className={this.props.formElementContainerClass}>
          <select
            className={formElementClass}
            id={this.props.name}
            name={this.props.name}
            multiple={this.props.multiple === 'true' ? true : false}
            value={this.props.selected}
            onChange={this.props.onChange}
          >
            {this.props.children}
          </select>
          {errorMessageBox}

      </div>
    </div>
    )
  }
}