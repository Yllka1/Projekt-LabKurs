import React from 'react'
import styles from "../styles/Footer.module.css"

const  Footer = () => {
  return (
    <div className= {styles.container}>
    <div className= {styles.item}>
        {/* <Image scr = "/img/bg.png" layot = "fill" alt = "" /> */}
        </div>   
    <div className= {styles.item}>
    <div className= {styles.card}>
      <h2 className= {styles.motto}>
      OH YES, WE DID THE PIZZA, WELL BAKED SLICE OF PIZZA.
      </h2>
      
    </div>
    <div className= {styles.card}>
      <h1 className = {styles.title}>FIND OUR RESTAURANTS </h1>
      <p className = {styles.text}>
        1654 R. Don Road  #304.
        <br /> NewYork, 85022
        <br /> (602) 867-1013
      </p>
      <p className = {styles.text}>
        1654 R. Don Road  #304.
        <br /> NewYork, 85022
        <br /> (602) 867-1013
      </p>
      <p className = {styles.text}>
        1654 R. Don Road  #304.
        <br /> NewYork, 85022
        <br /> (602) 867-1013
      </p>
      <p className = {styles.text}>
        1654 R. Don Road  #304.
        <br /> NewYork, 85022
        <br /> (602) 867-1013
      </p>
    </div>
    <div className= {styles.card}>
    <h1 className = {styles.title}>WORKING HOUR</h1>
    <p className = {styles.text}>
      MONDAY UNTIL FRIDAY 
      <br /> 9:30 - 22:00
      </p>      
      <p className = {styles.text}>
      MONDAY UNTIL FRIDAY 
      <br /> 9:30 - 22:00
      </p>  
    </div>

    </div>
      
      </div>
  );
};

export default Footer