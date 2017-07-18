import React,{Component} from 'react';

export default class FormOptionElement extends Component{
  render () {
    return (
      <option value={this.props.value}>{this.props.label}</option>
    )
  }
}