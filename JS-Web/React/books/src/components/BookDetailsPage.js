import React,{Component} from 'react';

import data from './../data/books';
import {Link} from "react-router-dom";


export default class BooksDetailsPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      bookInfo : {}

    };
  }

  componentDidMount() {
    let pageParams = this.props.match.params;
    let id = (parseInt(pageParams.id,10) || 1);
    data.getBookInfo(id).then(bookInfo => {
      console.log(bookInfo)
      this.setState({
        bookInfo : bookInfo,
      });

    });
  }

  render () {
    let comments = '';
    let drawInfo = () => {
      let result = '';
      if (this.state.bookInfo.author) {
        result = (
            <table className="table table-striped table-hover">
              <tbody>
              <tr>
                <th>Author: </th>
                <td>
                  <Link to={`/author/${this.state.bookInfo.author._id}`}>
                    {this.state.bookInfo.author.name}
                  </Link>
                </td>
              </tr>
              <tr>
                <th>Description: </th>
                <td>{this.state.bookInfo.description}</td>
              </tr>
              <tr>
                <th>Price: </th>
                <td>{this.state.bookInfo.price} лв.</td>
              </tr>
              <tr>
                <th>Created at : </th>
                <td>{this.state.bookInfo.createdAt}</td>
              </tr>
              </tbody>
            </table>
        );
      }
      return result;
    };
    if (this.state.bookInfo.comments) {
      comments = this.state.bookInfo.comments.map((data, index) => {
        return <div key={index}>{data}</div>;
      });
    }
    return (
      <section className="row">
        <div className="col-md-6">
          <img src={this.state.bookInfo.image} alt=""/>
        </div>
        <div className="col-md-6">
          <h1>{this.state.bookInfo.title}</h1>
          <div >
            {drawInfo()}
          </div>
        </div>
        <div className="col-md-12">
          <h1>Comments</h1>
          {comments}
        </div>

      </section>
    )
  }
}