import React,{Component} from 'react';
import FormHelpers from './../common/forms/FormHelpers'

export default class CreatePetForm extends Component{
  render () {
    let errors = this.props.errors || [];
    // get errors for all inputs

    let nameErr = FormHelpers.getElementError(errors,'name');
    let ageErr = FormHelpers.getElementError(errors,'age');
    let breedErr = FormHelpers.getElementError(errors,'breed');
    let imageErr = FormHelpers.getElementError(errors,'images');
    let typeErr = FormHelpers.getElementError(errors,'type');


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
            //input pet name
            //data
            elementType = 'input'
            error={nameErr}
            type='text'
            name='name'
            placeholder='Pet Name'
            value={this.props.pet.name}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <FormHelpers
            //input image
            //data
            elementType = 'input'
            error={imageErr}
            type='url'
            name='image'
            placeholder='Image'
            value={this.props.pet.image}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <FormHelpers
            //input age
            //data
            elementType = 'input'
            error={ageErr}
            type='number'
            name='age'
            placeholder='Age'
            value={this.props.pet.age}
            onChange={this.props.onChange}
            //styles
            elementErrorClass={this.props.elementErrorClass}
          />

          <div className="form-group">
            <label htmlFor="select" className="col-lg-4 control-label">Selects</label>
            <div className="col-lg-8">
              <select
                name="type"
                className="form-control"
                id="select"
                value={this.props.pet.type}
                onChange={this.props.onChange}
              >
                <option disabled value="">Choose Type</option>
                <option value='Cat' >Cat</option>
                <option value='Dog' >Dog</option>
                <option value='Other' >Other</option>
              </select>
              {typeErr ? <div className={this.props.elementErrorClass}>{typeErr}</div> : ''}
            </div>
          </div>

          <FormHelpers
            //input breed
            //data
            elementType = 'input'
            error={breedErr}
            type='text'
            name='breed'
            placeholder='Breed'
            value={this.props.pet.breed}
            onChange={this.props.onChange}
            //styles
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