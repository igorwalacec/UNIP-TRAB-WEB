import React, { Component } from "react";
import Card from "@material-ui/core/Card";
import CardActionArea from "@material-ui/core/CardActionArea";
import CardActions from "@material-ui/core/CardActions";
import CardContent from "@material-ui/core/CardContent";
import Fab from "@material-ui/core/Fab";
import AddIcon from "@material-ui/icons/Add";
import Typography from "@material-ui/core/Typography";
import api from "../../services/api";
import { Redirect } from "react-router-dom";

export default class Services extends Component {
  state = {
    services: [],
    redirectNewService: false
  };
  componentDidMount() {
    const id_user = encodeURIComponent(
      JSON.parse(localStorage.getItem("informations")).id_user
    );

    const url = `/service/getServicesByUser.php?Id_User=${id_user}`;
    api.get(url).then(response => {
      console.log(response.data.result);
      this.setState({ services: [...response.data.result] });
    });
  }

  render() {
    if (this.state.redirectNewService) {
      return <Redirect to="/NewService" />;
    } else if (this.state.services.lenght === 0) {
      return <h1>Você náo solicitou nenhum serviço</h1>;
    } else {
      const buttonAdd = {
        position: "fixed",
        bottom: "40px",
        right: "40px"
      };
      const card = {
        width: "40%",
        minHeight: "150px",
        marginTop: "30px",
        marginLeft: "auto",
        marginRight: "auto"
      };
      return (
        <>
          {this.state.services.map(item => (
            <Card key={item.Id_Service} style={card}>
              <CardActionArea>
                <CardContent>
                  <Typography gutterBottom variant="h5" component="h2">
                    {item.Title_Service} - {item.Description_Type_Service}
                  </Typography>
                  <Typography gutterBottom variant="h6" component="h6">
                    {new Date(item.Date_Service).toLocaleDateString()}
                  </Typography>
                  <Typography
                    variant="body2"
                    color="textSecondary"
                    component="p"
                  >
                    {item.Description_Service}
                  </Typography>
                  <Typography
                    variant="body2"
                    color="textSecondary"
                    component="p"
                  >
                    <strong>Valor: R${item.Value_Service}</strong>
                  </Typography>
                </CardContent>
              </CardActionArea>
              <CardActions>
                {/* <Button size="small" color="primary"></Button>
                <Button size="small" color="primary">
                  Learn More
                </Button> */}
              </CardActions>
            </Card>
          ))}
          <Fab
            color="primary"
            aria-label="add"
            style={buttonAdd}
            onClick={() => {
              this.setState({ redirectNewService: true });
            }}
          >
            <AddIcon />
          </Fab>
        </>
      );
    }
  }
}
