<!-- The front is based on of my SVG link hover effect https://codepen.io/Zeaklous/pen/kyGqm -->
<style>
@import 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto:300';

$padding:30px;

* { box-sizing: border-box; }

body { background: #757575; overflow-x: hidden; }
.container {
  perspective: 800px;
  
  /* Styling */  
  color: #fff;
  font-family: 'Open Sans', sans-serif;
  text-transform: uppercase;
  letter-spacing: 4px;
  
  /* Center it */
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.card {
  /* Styling */
  width: 700px;
  height: 400px;
  background: rgb(20,20,20);
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);  
  
  /* Card flipping effects */
  transform-style: preserve-3d;
  transition: 0.6s; 
}

/* Front styling */
.front {
  /* Center the name + outline (almost) */
  line-height: 390px; /* Height - some (because visual center is a little higher than actual center) */
  text-align: center;
}
.logo {
  outline: 1px solid #19F6E8;
  display: inline-block;
  padding: 15px 40px;
  
  text-transform: uppercase;
  font-family: 'Roboto', sans-serif;
  font-size: 1.4em;
  font-weight: normal;
  line-height: 32px;
  letter-spacing: 8px;
}

/* Back styling */
.back {
  background: #15CCC0;
  padding: $padding;
}
.name {
  color: #3B3B3B;
  margin-bottom: 0;
}
p {
  margin: 0.8em 0;
}
.info {
  position: absolute;
  bottom: $padding;
  left: $padding;
  color: #3b3b3b;
}
.property {
  color: #fff;
}

/* Make semi-responsive */
@media (max-width:700px) {
  .card { transform: scale(.5); }
  .container:hover .card { transform: scale(.5) rotateY(-180deg) translateZ(1px); }
}
</style>
<div class="container">
    <div class="card">
      <div class="back side">
      <h3 class="name">{{$name}}</h3>
        <div>Front-end developer</div>      
        <div class="info">
        <p><span class="property">Email: </span>{{$email}}</p>
          <p><span class="property">Twitter: </span>@piyal/</p>
        <p><span class="property">Phone: </span>{{$phone}}</p>
          <p><span class="property">Website: </span>piyal.com</p>
        </div>
      </div>
      
    </div>
  </div>