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
import UserHomePage from '../user/UserHomePage';
//cars
import AddCarPage from '../car/AddCarPage';
import ListCarsPage from '../car/ListCarsPage';
import CarDetailsPage from '../car/CarDetailsPage';
import UserCarsPage from '../car/UserCarsPage';

const routes = () => (
  <Switch>
    <Route path='/' exact        component={HomePage}/>
    <Route path='/user/register' component={RegisterPage}/>
    <Route path='/user/login'    component={LoginPage}/>

    <PrivateRoute path='/user/home'    component={UserHomePage}/>
    <PrivateRoute path='/user/logout'  component={LogoutPage}/>
    <PrivateRoute path='/user/profile' component={ProfilePage}/>

    <PrivateRoute path='/cars/create'       component={AddCarPage}/>
    <PrivateRoute path='/car/details/:id'   component={CarDetailsPage}/>
    <PrivateRoute path='/user/cars/'        component={UserCarsPage}/>
    <Route path='/cars/all/:page?/:search?' component={ListCarsPage}/>

    <Route component={NotFoundPage}/>
  </Switch>
);

export default routes;