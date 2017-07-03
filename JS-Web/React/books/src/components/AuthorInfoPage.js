import React,{Component} from 'react';

import data from './../data/books';
import {Link} from "react-router-dom";


export default class AuthorInfoPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      authorInfo : {}

    };
  }

  componentDidMount() {
    let pageParams = this.props.match.params;
    let id = (parseInt(pageParams.id,10) || 1);
    data.getAuthorInfo(id).then( author => {
      this.setState({
        authorInfo : author,
      });

    });
  }

  render () {
    let books = '';

    if (this.state.authorInfo.books) {
      books = this.state.authorInfo.books.map((book, index) => {
        return <div key={index}><Link to={`/book/${book._id}`}>{book.title} </Link></div>;
      });
    }
    return (
        <section className="row">
          <div className="col-md-6">
            <img src={this.state.authorInfo.picture} alt="" style={{height: '500px'}}/>
          </div>
          <div className="col-md-6">
            <h1>{this.state.authorInfo.name}</h1>
            <div >
              <table className="table table-striped table-hover">
                <tbody>
                <tr>
                  <th>BookCount: </th>
                  <td>{(this.state.authorInfo.books || []).length}</td>
                </tr>
                <tr>
                  <th>Book List:  </th>
                  <td> {books}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
    )
  }
}