import React,{Component} from 'react';

export default class Form extends Component {
  render () {
    let formClass = 'form-horizontal ' + (this.props.formClass || '');
    let errorBox = '';
    if (this.props.errors && this.props.errors.length > 0) {
      errorBox = (
        <div className={this.props.formErrorBoxClass}>
          {this.props.errors}
        </div>
      )
    }
    return (
      <form onSubmit={this.props.onSubmit} className={formClass}>
        <fieldset>
          <legend>{this.props.formLegend}</legend>
          {errorBox}
          {this.props.children}
        </fieldset>
      </form>
    )
  }
}
