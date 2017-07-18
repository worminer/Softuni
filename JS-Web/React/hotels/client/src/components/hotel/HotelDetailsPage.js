import React, {Component} from 'react';
//stores and actions
import HotelAction from '../../actions/HotelActions';
import HotelStore from '../../stores/HotelStore';
//forms
import FormSelectComponent from '../common/forms/FormSelectComponent';
import FormOptionElement from '../common/forms/FormOptionElement';
import FormHelpers from '../common/forms/FormHelpers';
import FromTextAreaComponent from '../common/forms/FormTextAreaComponent';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
import Form from '../common/forms/Form';

import ShowMessage from '../common/ShowPopupMessage';

export default class HotelDetailsPage extends Component {

  constructor(props) {
    super(props);

    this.state = {
      hotel: {},
      comment: {
        rating: '1',
        message: '',
      },
      errors: {},
    };

    this.handleHotelsDetailsResponse = this.handleHotelsDetailsResponse.bind(this);
    HotelStore.on(HotelStore.eventTypes.HOTEL_DETAILS_FETCHED, this.handleHotelsDetailsResponse);

    this.handleHotelsCreateCommentResponse = this.handleHotelsCreateCommentResponse.bind(this);
    HotelStore.on(HotelStore.eventTypes.COMMENT_CREATED, this.handleHotelsCreateCommentResponse);
  }

  componentWillUnmount() {
    HotelStore.removeListener(HotelStore.eventTypes.HOTEL_DETAILS_FETCHED,
      this.handleHotelsDetailsResponse);
    HotelStore.removeListener(HotelStore.eventTypes.COMMENT_CREATED,
      this.handleHotelsCreateCommentResponse);
  }

  componentDidMount() {
    HotelAction.details(this.props.match.params.id);

    //because on the first mount the rating is not selected
    this.setState({
      comment:{
        rating:1
      }
    })
  }

  handleHotelsDetailsResponse(data) {
    //console.log(data);
    this.setState({
      hotel: data,
    });
  }

  handleHotelsCreateCommentResponse(data) {
    console.log(data);
    this.setState({errors: {}});//clear errors
    let errors = FormHelpers.extractFormErrorsFromData(data, this.state.errors);

    if (!data.success) {
      errors['message'] = {
        message: data.message,
        displayed: false,
      };
      this.setState({
        errors: errors,
      });
    } else {
      ShowMessage.success(data.message);
      this.setState({
        comment: {
          rating: '',
          message: '',
        }
      });
    }
  }
  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'comment');
  }

  handleAddComment(event) {
    event.preventDefault();
    if (!this.validateUserData()) {
      return;
    }
    this.setState({errors: {}});//if form validation passed.. clear errors if any
    HotelAction.createComment(this.state.comment,this.state.hotel.id);
  }

  validateUserData() {
    const comment = this.state.comment;
    let isFormValid = true;
    let errors = {};
    // validate rating

    let rating = parseInt(comment.rating,10) || 0;
    if (rating < 1 || rating > 5) {
      isFormValid = false;
      errors['rating'] = {
        message: 'Rating must be between 1 and 5.',
        displayed: false,
      };
    }

    
    if (Object.keys(errors).length > 0) {
      errors['formError'] = {
        message: 'Check the form for errors.',
        displayed: false,
      };
      this.setState({
        errors,
      });
    }

    return isFormValid;
  }

  render() {
    let hotel = this.state.hotel;
    let errors = this.state.errors || {};

    let rating = FormHelpers.getElementError(errors, 'rating');
    let comment = FormHelpers.getElementError(errors, 'comment');

    let voteOptions = [];
    for (let i = 1; i <= 5; i++) {
      voteOptions.push(
        <FormOptionElement
          key={i}
          label={`${i} Stars`}
          value={i}
        />,
      );

    }

    // prepare to display all other errors
    let errorMessagesLeft = Object.keys(errors).map(key => {
      if (errors[key].displayed === false) {
        return (<div key={key} className=''>{errors[key].message}</div>);
      }
      return '';
    }).filter(e => e !== '');

    return (
      <section className="row well">
        <section>
          <div className="">
            <div className="col-md-4">
              <img className="hotel-homepage-image" src={hotel.image}
                   alt={hotel.name + ' no image'}/>
            </div>
            <div className="col-md-8">
              <table className="table table-striped table-hover ">
                <tbody>
                <tr>
                  <th>Name</th>
                  <td>{hotel.name}</td>
                </tr>
                <tr>
                  <th>Description</th>
                  <td style={{
                    wordWrap: 'break-word',
                    wordBreak: 'break-all',
                  }}>{hotel.description} </td>
                </tr>
                <tr>
                  <th>Number of rooms</th>
                  <td>{hotel.numberOfRooms}</td>
                </tr>
                <tr>
                  <th>Added On</th>
                  <td>{hotel.createdOn}</td>
                </tr>
                <tr>
                  <th>ID</th>
                  <td>{hotel.id}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <section>
          <div>
            <Form
              //data
              formErrorBoxClass="text-danger well"
              // callbacks
              onChange={this.handleFormChange.bind(this)}
              onSubmit={this.handleAddComment.bind(this)}
              // errors
              errors={errorMessagesLeft}
              //form style config
              formClass="col-md-6 col-md-offset-3
                        col-sm-8 col-sm-offset-2
                        col-xs-10 col-xs-offset-1
                        well flipInX animated
                        "
              formLegend="Leave a comment and rate."
            >
              <FormSelectComponent
                //input hotel Description
                //data
                error={rating}
                multiple='false'
                rows='5'
                name='rating'
                placeholder='Rate'
                selected={this.state.comment.rating}
                onChange={this.handleFormChange.bind(this)}
                //styles
                formGroupClass={rating ? 'has-error' : ''}
                formItemLabelClass='col-md-4'
                formElementContainerClass='col-md-8'
                elementErrorClass='text-danger formFieldErrorText well well-sm'
              >
                {voteOptions}
              </FormSelectComponent>

              <FromTextAreaComponent
                //input hotel Description
                //data
                error={comment}
                rows='5'
                name='message'
                placeholder='Leave a comment.'
                value={this.state.comment.message}
                onChange={this.handleFormChange.bind(this)}
                //styles
                formGroupClass={comment ? 'has-error' : ''}
                formItemLabelClass='col-md-4'
                formElementContainerClass='col-md-8'
                elementErrorClass='text-danger formFieldErrorText well well-sm'
              />
              <div className="form-group">
                <FormButtonSubmit
                  containerClass="col-md-8 col-md-offset-4"
                  className='btn-success'
                  text="Add Comment"
                />
              </div>
            </Form>
          </div>
        </section>
      </section>

    );
  }
}
