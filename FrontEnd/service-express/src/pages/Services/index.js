import React, { Component } from "react";
import Header from "../../pages/Components/Header";
import TextField from "@material-ui/core/TextField";
import Button from "@material-ui/core/Button";
import Grid from "@material-ui/core/Grid";
import DateFnsUtils from "@date-io/date-fns";
import InputLabel from "@material-ui/core/InputLabel";
import Select from "@material-ui/core/Select";
import MenuItem from "@material-ui/core/MenuItem";
import api from "../../services/api";
import {
  MuiPickersUtilsProvider,
  KeyboardTimePicker,
  KeyboardDatePicker
} from "@material-ui/pickers";
// import { Container } from './styles';

export default class NewService extends Component {
  state = {
    selectedDate: new Date(),
    typeService: [],
    typeServiceSelect: -1
  };
  componentDidMount() {
    const url = `/typeservice/read.php`;
    api.get(url).then(response => {
      console.log(response.data.result);
      this.setState({ typeService: [...response.data.result] });
    });
  }
  handleSubmit(e) {
    e.preventDefault();
  }
  handleDateChange = date => {
    this.setState({ selectedDate: date });
  };
  handleChange = event => {
    this.setState({ typeService: event.target.value });
  };
  render() {
    const style = {
      width: "80%",
      margin: "auto"
    };
    return (
      <>
        <Header name={"Novo Serviço"} />
        <div style={style}>
          <form validate="true" onSubmit={e => this.handleSubmit(e)}>
            <Grid container spacing={4}>
              <Grid item xs={6}>
                <TextField
                  variant="outlined"
                  margin="normal"
                  required
                  fullWidth
                  id="Title"
                  label="Título do Serviço"
                  name="Title"
                  autoComplete="Title"
                  autoFocus
                />
              </Grid>
              <MuiPickersUtilsProvider utils={DateFnsUtils}>
                <Grid item xs={3}>
                  <KeyboardDatePicker
                    disableToolbar
                    variant="inline"
                    format="dd/MM/yyyy"
                    margin="normal"
                    id="dataServico"
                    label="Data"
                    value={this.state.selectedDate}
                    onChange={this.handleDateChange}
                    KeyboardButtonProps={{
                      "aria-label": "Alterar Data"
                    }}
                  />
                </Grid>

                <Grid item xs={3}>
                  <KeyboardTimePicker
                    margin="normal"
                    id="time-picker"
                    label="Time picker"
                    value={this.state.selectedDate}
                    onChange={this.handleDateChange}
                    KeyboardButtonProps={{
                      "aria-label": "change time"
                    }}
                  />
                </Grid>
              </MuiPickersUtilsProvider>
              <Grid item xs={6}>
                <TextField
                  variant="outlined"
                  margin="normal"
                  required
                  fullWidth
                  name="password"
                  label="Valor"
                  type="money"
                  id="Value"
                />
              </Grid>
              <Grid item xs={6}>
                <InputLabel id="demo-simple-select-helper-label">
                  Tipo Serviço
                </InputLabel>
                <Select
                  labelId="demo-simple-select-label"
                  id="typeService"
                  value={this.typeServiceSelect}
                  onChange={this.handleChangeSelect}
                  style={{ width: "100%" }}
                >
                  <MenuItem value="-1">
                    <em>Selecione</em>
                  </MenuItem>
                  {this.state.typeService.map(item => (
                    <MenuItem key={item.id} value={item.id}>
                      {item.description}
                    </MenuItem>
                  ))}
                </Select>
              </Grid>
            </Grid>
            <Button type="submit" fullWidth variant="contained" color="primary">
              Logar
            </Button>
          </form>
        </div>
      </>
    );
  }
}
