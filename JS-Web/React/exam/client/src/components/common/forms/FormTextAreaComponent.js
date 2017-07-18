import React,{Component} from 'react';

export default class FormTextAreaComponent extends Component{
  render () {
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
          htmlFor={this.props.name}
          className={formItemLabelClass}
        >
          {this.props.placeholder}
        </label>
        <div className={this.props.formElementContainerClass}>
          <textarea
            className={formElementClass}
            rows={this.props.rows}
            cols={this.props.cols}
            name={this.props.name}
            id={this.props.name}
            placeholder={this.props.placeholder}
            onChange={this.props.onChange}
          >
          </textarea>
          {errorMessageBox}
        </div>
      </div>
        
    )
  }
}