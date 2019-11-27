import React from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";
import Login from "./pages/Login";

export default function() {
  return (
    <BrowserRouter>
      <Switch>
        <Route path="/" exact component={Login}></Route>
      </Switch>
    </BrowserRouter>
  );
}
