import React,{Component} from 'react';
import PetActions from '../../actions/PetActions';
import PetStore from '../../stores/PetStore';
import FormHelpers from '../common/forms/FormHelpers';
import ShowMessage from '../common/ShowPopupMessage';

export default class PetDetailsPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      pet:[],
      petId: parseInt(this.props.match.params.id, 10) || 1,
      pageError: '',
      errors: [],
      comment: {
        message: ''
      },
      comments: []

    };
    this.handlePetDetailsResponse = this.handlePetDetailsResponse.bind(this);
    PetStore.on(
      PetStore.eventTypes.PET_FETCHED_DETAILS,
      this.handlePetDetailsResponse
    );
    
    this.handlePetAddCommentResponse = this.handlePetAddCommentResponse.bind(this);
    PetStore.on(
      PetStore.eventTypes.PET_ADD_COMMENT,
      this.handlePetAddCommentResponse
    )
    
    this.handlePetFetchCommentResponse = this.handlePetFetchCommentResponse.bind(this);
    PetStore.on(
      PetStore.eventTypes.PET_FETCH_COMMENTS,
      this.handlePetFetchCommentResponse
    )
  }
  
  componentWillUnmount() {
    PetStore.removeListener(
      PetStore.eventTypes.PET_FETCHED_DETAILS,
      this.handlePetDetailsResponse
    );
    PetStore.removeListener(
      PetStore.eventTypes.PET_ADD_COMMENT,
      this.handlePetAddCommentResponse
    )
    PetStore.removeListener(
      PetStore.eventTypes.PET_FETCH_COMMENTS,
      this.handlePetFetchCommentResponse
    )
  }
  handlePetFetchCommentResponse(data) {
    this.setState({
      comments: data
    });
  }
  handlePetAddCommentResponse(data) {
    console.log(data)
    if (!data.success) {
      let errors = this.state.errors;
      errors['message'] = data.message;
      this.setState({
        errors: errors
      })
    } else {
      this.setState({
        comment: {
          message: ''
        }
      });
      ShowMessage.success(data.message);
    }
  }

  handlePetDetailsResponse (data) {
    if (data.hasOwnProperty('success')) {
      this.setState({
        pageError: data.message
      });
    } else {
      this.setState({
        pet: data
      });
      this.fetchComments(this.state.petId)
    }
  }

  fetchComments(id) {
    PetActions.fetchComments(id)
  }
  componentWillMount() {
    PetActions.details(this.state.petId)
  }
  handleFormChange (event) {
    FormHelpers.handleFormChange.bind(this)(event, 'comment');
  }
  handlePetCommentCreate (event) {
    event.preventDefault();
    if(!this.validatePetCommentData()) {
      return;
    }

    PetActions.addComment(this.state.petId, this.state.comment);
  }

  validatePetCommentData() {
    return true;

    // const user = this.state.user;
    // let isFormValid = true;
    // let errors = this.state.errors;

    //TODO: validate form
    // if (user.password !== user.confirmPassword) {
    //   errors['password'] = 'Passwords mismatch!';
    //   isFormValid = false;
    // } else {
    //   errors['password']= '';
    // }

    // if (Object.keys(errors).length > 0) {
    //   this.setState({
    //     errors
    //   });
    // }
    //
    // return isFormValid;
  }
  
  render () {
    let comments = this.state.comments.map((comment) => {
      return (
        <div key={comment.createdOn} className="col-md-12">
          <blockquote>
            <p>{comment.message}</p>
            <small>user:{comment.user}</small>
          </blockquote>
        </div>
      )
    });
    let petInfo = () => (
      <div>
        <div className="col-md-6">
          <img src={this.state.pet.image} style={{
            width:'100%',
            border: '1px solid black',
            boxSizing: 'border-box'
          }} alt=""/>
        </div>
        <div className="col-md-6">
          <table className="table table-striped table-hover">

            <tbody>
            <tr>
              <th>ID</th>
              <td>{this.state.pet.id}</td>
            </tr>
            <tr>
              <th>Name</th>
              <td>{this.state.pet.name}</td>
            </tr>
            <tr>
              <th>Type</th>
              <td>{this.state.pet.type}</td>
            </tr>
            <tr>
              <th>Breed</th>
              <td>{this.state.pet.breed}</td>
            </tr>
            <tr>
              <th>Age</th>
              <td>{this.state.pet.age}</td>
            </tr>

            </tbody>
          </table>
        </div>
        <div className="col-md-12">
          <div>{errors}</div>
          <form className="form-horizontal">
            <fieldset>
              <legend>Leave a comment.</legend>
              <div className="col-md-6" >
                <div className="form-group">
                  <div className="col-lg-10">
                    <textarea
                      className="form-control"
                      rows="3"
                      id="textArea"
                      name="message"
                      value={this.state.comment.message}
                      onChange={this.handleFormChange.bind(this)}
                    />
                  </div>
                </div>
                <div className="form-group">
                  <div className="col-lg-10">
                    <button
                      type="submit"
                      className="btn btn-primary"
                      onClick={this.handlePetCommentCreate.bind(this)}
                    >
                      Send
                    </button>
                  </div>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        <div className="col-md-12">
          <h1>{comments}</h1>
        </div>
      </div>
    );


    let errors = (Object.keys(this.state.errors).map(key => this.state.errors[key]).join('\n'))

    return (
      <section className="row well">
        <div>
          {this.state.pageError !== '' ? (
            <div className="text-center">
              <h1>{this.state.pageError}</h1>
            </div>
          ) :
            petInfo()

          }
        </div>

      </section>
        
    )
  }
}