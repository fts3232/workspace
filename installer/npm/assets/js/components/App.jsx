import React from "react";
import PropTypes from "prop-types";
import Header from "./Header";
import Footer from "./Footer";
import { renderRoutes } from "react-router-config";

class App extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    return (
      <div>
        <Header />
        {renderRoutes(this.props.route.routes)}
        <Footer />
      </div>
    );
  }
}

App.propTypes = {
  //属性校验器，表示改属性必须是bool，否则报错
};
App.defaultProps = {}; //设置默认属性

export default App;
