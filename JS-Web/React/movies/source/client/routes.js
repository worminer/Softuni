import React, {component} from 'react';
import { Route } from 'react-router';

import App from './components/App';
import Home from './components/Home';
import MovieAdd from './components/MovieAdd';

//import UserProfile from './components/UserProfile';
//<Route path='user/profile/:userId' component={UserProfile} />

export default (
  <Route component={ App } >
    <Route path='/' component={Home} />
    <Route path='/movie/add' component={MovieAdd} />

  </Route>
)