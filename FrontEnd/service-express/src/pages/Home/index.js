import React from "react";
import Header from "../../pages/Components/Header";
import Services from "../../pages/Components/Services";
// import { Container } from './styles';

export default function Home() {
  return (
    <>
      <Header name={"Serviços"} />
      <Services />
    </>
  );
}
