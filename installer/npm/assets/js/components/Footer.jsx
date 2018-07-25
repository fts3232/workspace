import React from 'react';
import PropTypes from 'prop-types';

class Footer extends React.Component {
    constructor(props){
        super(props);
    }
    render() {
        return (
            <div>
                Footer
            </div>
        );
    }
}

Footer.propTypes={//属性校验器，表示改属性必须是bool，否则报错

}
Footer.defaultProps={

};//设置默认属性

export default Footer;