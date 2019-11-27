import React from "react";
import Button from "@material-ui/core/Button";
import CssBaseline from "@material-ui/core/CssBaseline";
import TextField from "@material-ui/core/TextField";
import Typography from "@material-ui/core/Typography";
import { makeStyles } from "@material-ui/core/styles";
import Container from "@material-ui/core/Container";
import Snackbar from "@material-ui/core/Snackbar";
import { Redirect } from "react-router-dom";

import api from "../../services/api";

const useStyles = makeStyles(theme => ({
  paper: {
    marginTop: theme.spacing(8),
    display: "flex",
    flexDirection: "column",
    alignItems: "center"
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main
  },
  form: {
    width: "100%", // Fix IE 11 issue.
    marginTop: theme.spacing(1)
  },
  submit: {
    margin: theme.spacing(3, 0, 2)
  }
}));

export default function Login() {
  const [state, setState] = React.useState({
    open: false,
    vertical: "top",
    horizontal: "right",
    message: "",
    redirectUser: false,
    redirectProvider: false
  });

  const {
    vertical,
    horizontal,
    open,
    message,
    redirectUser,
    redirectProvider
  } = state;

  const handleClose = () => {
    setState({ ...state, open: false });
  };

  async function handleSubmit(e) {
    e.preventDefault();
    const Email = encodeURIComponent(document.querySelector("#Email").value);
    const Password = encodeURIComponent(
      document.querySelector("#Password").value
    );
    const url = `/user/login.php?Email=${Email}&Password=${Password}`;
    await api
      .post(url)
      .then(response => {
        if (response.data.id_provider != null) {
          setState({ redirectProvider: true });
        } else {
          setState({ redirectUser: true });
        }
        localStorage.setItem("informations", JSON.stringify(response.data));
      })
      .catch(error => {
        setState({
          open: true,
          ...{
            vertical: "top",
            horizontal: "right",
            message: error.response.data.message
          }
        });
      });
  }

  const classes = useStyles();

  if (redirectUser) {
    return <Redirect to="/Home" />;
  } else if (redirectProvider) {
    return <Redirect to="/Services" />;
  } else {
    return (
      <Container component="main" maxWidth="xs">
        <CssBaseline />
        <div className={classes.paper}>
          <Typography component="h1" variant="h5">
            Logar
          </Typography>
          <form
            className={classes.form}
            validate="true"
            onSubmit={e => handleSubmit(e)}
          >
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="Email"
              label="Endereço de Email"
              name="Email"
              autoComplete="email"
              autoFocus
            />
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              name="password"
              label="Senha"
              type="password"
              id="Password"
              autoComplete="current-password"
            />
            <Button
              type="submit"
              fullWidth
              variant="contained"
              color="primary"
              className={classes.submit}
            >
              Logar
            </Button>
          </form>
        </div>
        <Snackbar
          anchorOrigin={{ vertical, horizontal }}
          key={`${vertical},${horizontal}`}
          open={open}
          onClose={handleClose}
          ContentProps={{
            "aria-describedby": "message-id"
          }}
          message={<span id="message-id">{message}</span>}
        />
      </Container>
    );
  }
}
