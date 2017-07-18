export default class FormHelpers{

  /**
   * this function gets the error for the element and returns it!
   * if markAsDisplayed = true .. will change the display status of the obj.
   */
  static getElementError(errors, element, markAsDisplayed = true) {
    let elementError = '';
    if (Object.keys(errors).length > 0 && errors[element]) {

      elementError = errors[element].message;
      if (markAsDisplayed) {
        errors[element].displayed = true;
      }
    }
    return elementError;
  }

  /**
   * handles form changes and saves them in the state
   * USE bind(this) !!
   */
  static handleFormChange (event,stateField) {
    let state = this.state;
    state[stateField][event.target.name] = event.target.value;
    this.setState(state)
  }

  /**
   * extracts errors from data obj
   */
  static extractFormErrorsFromData(data) {
    let errors = {};
    if (data.errors) {
      Object.keys(data.errors)
      .map(key => errors[key] = {
        message: data.errors[key],
        displayed: false
      });

    }
    return errors;
  }
}