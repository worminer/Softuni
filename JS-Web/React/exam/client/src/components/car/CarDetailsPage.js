import React, {Component} from 'react';
//stores and actions
import CarAction from '../../actions/CarActions';
import CarStore from '../../stores/CarStore';
//forms
import FormSelectComponent from '../common/forms/FormSelectComponent';
import FormOptionElement from '../common/forms/FormOptionElement';
import FormHelpers from '../common/forms/FormHelpers';
import FromTextAreaComponent from '../common/forms/FormTextAreaComponent';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
import Form from '../common/forms/Form';

import ShowMessage from '../common/ShowPopupMessage';

export default class CarDetailsPage extends Component {

  constructor(props) {
    super(props);

    this.state = {
      car: {
        createdOn:'',
        engine:'',
        id:'',
        image:'',
        make:'',
        mileage:'',
        model:'',
        price:'',
        year:''
      },
      reviews: [],
      comment: {
        rating: '1',
        message: '',
      },
      errors: {},
      likeStatus: {
        success: '',
        message: ''
      },
    };

    this.handleCarDetailsResponse = this.handleCarDetailsResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CAR_DETAILS_FETCHED, this.handleCarDetailsResponse);

    this.handleCarCreateCommentResponse = this.handleCarCreateCommentResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CAR_COMMENT_CREATED, this.handleCarCreateCommentResponse);

    this.handleCarLikeThisResponse = this.handleCarLikeThisResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CAR_LIKED_THIS, this.handleCarLikeThisResponse);

    this.handleCarReviewsResponse = this.handleCarReviewsResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CAR_REVIEWS_FETCHED, this.handleCarReviewsResponse);
    
  }

  componentWillUnmount() {
    CarStore.removeListener(CarStore.eventTypes.CAR_DETAILS_FETCHED,
      this.handleCarDetailsResponse);
    CarStore.removeListener(CarStore.eventTypes.CAR_COMMENT_CREATED,
      this.handleCarCreateCommentResponse);
    CarStore.removeListener(CarStore.eventTypes.CAR_LIKED_THIS,
      this.handleCarLikeThisResponse);
    CarStore.removeListener(CarStore.eventTypes.CAR_REVIEWS_FETCHED,
      this.handleCarReviewsResponse);
  }

  componentDidMount() {
    CarAction.details(this.props.match.params.id);
    CarAction.getReviews(this.props.match.params.id);
    //because on the first mount the rating is not selected
    this.setState({
      comment:{
        rating:1
      }
    })

  }
  handleCarReviewsResponse(data){
    this.setState({
      reviews:data
    })
  }
  handleCarLikeThisResponse(data){
    this.setState({
      likeStatus : data
    })
  }
  handleCarDetailsResponse(data) {
    //console.log(data);
    this.setState({
      car: data,
    });
  }

  handleCarCreateCommentResponse(data) {
    //console.log(data);
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

    CarAction.getReviews(this.props.match.params.id);

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
    CarAction.createComment(this.state.comment,this.state.car.id);
  }

  handleLikeThis(event) {
    event.preventDefault();
    CarAction.likeThis(this.state.car.id);
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
    let car = this.state.car;
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

    let reviews = this.state.reviews.map((review,index) => {

      let date = new Date(review.createdOn)
      return (
        <div key={index} className="panel">
          {index+1} - User: {review.user} placed {review.rating} stars on {date.toLocaleString()}.
        </div>
      );
    });
    return (
      <section className="row well">
        <section>
          <div className=''>
            <div className="col-md-5">
              <img className="car-details-image"
                   src={car.image}
                   alt={car.make + ' no image'}/>
            </div>
            <div className="col-md-7">
              <table className="table table-striped table-hover ">
                <tbody>
                <tr>
                  <th>Car Make: </th>
                  <td>{car.make}</td>
                </tr>
                <tr>
                  <th>Car Model: </th>
                  <td>{car.model}</td>
                </tr>
                <tr>
                  <th>Car Engine</th>
                  <td>{car.engine}</td>
                </tr>
                <tr>
                  <th>Car Mileage</th>
                  <td>{car.mileage}</td>
                </tr>
                <tr>
                  <th>Car Price</th>
                  <td>{car.price}</td>
                </tr>
                <tr>
                  <th>Car Year</th>
                  <td>{car.year}</td>
                </tr>
                <tr>
                  <th>Added on: </th>
                  <td>{car.createdOn}</td>
                </tr>
                </tbody>
              </table>
              <div className="form-group">
                <div className={(this.state.likeStatus.success ? 'text-success': 'text-danger')}>{this.state.likeStatus.message}</div>
                <FormButtonSubmit
                  onClick={this.handleLikeThis.bind(this)}
                  containerClass="col-md-8 col-md-offset-4"
                  className='btn-success'
                  text="Like this!"
                />
              </div>
            </div>
          </div>
        </section>

        <section>
          <div className="">
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
              formLegend="Review this car ?"
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
        <section className="col-md-12">
          <div className="text-center">
            <h1>Reviews for this car</h1>
          </div>
          {reviews}
        </section>
      </section>

    );
  }
}
