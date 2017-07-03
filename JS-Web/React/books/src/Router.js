import React from 'react';
import {Switch, Route} from 'react-router-dom';

import NotFoundPage from './components/NotFoundPage';

import HomePage from './components/HomePage';
import BooksPage from './components/BooksPage';
import BookDetailsPage from './components/BookDetailsPage';
import AuthorInfoPage from './components/AuthorInfoPage';
import AuthorsPage from './components/AuthorsPage';

const routes = () => (
  <Switch>
    <Route exact path='/' component={HomePage}/>
    <Route path='/books/all/:page?/:sortBy?/:sortType?' component={BooksPage}/>
    <Route path='/book/:id' component={BookDetailsPage}/>
    <Route path='/authors/:page?/:sortBy?/:sortType?' component={AuthorsPage}/>
    <Route path='/author/:id' component={AuthorInfoPage}/>

    <Route component={NotFoundPage}/>
  </Switch>
);

export default routes;