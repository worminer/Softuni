import React from 'react';
import {Switch, Route} from 'react-router-dom';
import PrivateRoute from './PrivateRoute';
import NotFoundPage from '../common/NotFoundPage';

import HomePage from '../HomePage';
// user
import RegisterPage from '../user/RegisterPage';
import LoginPage from '../user/LoginPage';
import LogoutPage from '../user/LogoutPage';
import ProfilePage from '../user/ProfilePage';
import UserHomePage from '../user/HomePage';

import CreatePetPage from  '../pets/CreatePetPage';
import ListPetsPage from  '../pets/ListPetsPage';
import PetDetailsPage from  '../pets/PetDetailsPage';

const routes = () => (
  <Switch>
    <Route exact path='/' component={HomePage}/>
    <Route path='/user/register' component={RegisterPage}/>
    <Route path='/user/login' component={LoginPage}/>

    <PrivateRoute path='/user/home' component={UserHomePage}/>
    <PrivateRoute path='/user/logout' component={LogoutPage}/>
    <PrivateRoute path='/user/profile' component={ProfilePage}/>

    <PrivateRoute path='/pets/add' component={CreatePetPage}/>
    <PrivateRoute path='/pets/list/:page?' component={ListPetsPage}/>

    <PrivateRoute path='/pet/details/:id' component={PetDetailsPage}/>



      <Route component={NotFoundPage}/>
  </Switch>
);

export default routes;