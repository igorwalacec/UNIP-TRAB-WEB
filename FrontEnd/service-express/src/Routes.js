import React from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";
import Login from "./pages/Login";
import Home from "./pages/Home";
import NewService from "./pages/Services";

export default function() {
  return (
    <BrowserRouter>
      <Switch>
        <Route path="/" exact component={Login}></Route>
        <Route path="/Home" component={Home}></Route>
        <Route path="/NewService" component={NewService}></Route>
      </Switch>
    </BrowserRouter>
  );
}
