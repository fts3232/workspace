import React from 'react';
import { renderRoutes } from 'react-router-config';
import PropTypes from 'prop-types';
import Header from './Header';
import Footer from './Footer';

function App({ route }) {
    return (
        <div>
            <Header />
            {renderRoutes(route.routes)}
            <Footer />
        </div>
    );
}

App.propTypes = {
    // 属性校验器，表示改属性必须是bool，否则报错
    route: PropTypes.object.isRequired
};
App.defaultProps = {
    // 设置默认属性
};

export default App;
