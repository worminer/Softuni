import React from 'react'

export default class FormButtonSubmit extends React.Component {
  render () {
    let btnClassName = 'btn ' + (this.props.className || '');
    let btnText = this.props.text || 'Submit';
    return (
      <div className={this.props.containerClass}>
        <button
          //TODO: make component
          type="submit"
          className={btnClassName}
          name={this.props.name}
        >
          {btnText}
        </button>

      </div>
    )
  }
}
