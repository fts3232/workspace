import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Loader extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'lazyComponent': null
        };
    }

    componentDidMount() {
        this.loadPage();
    }

    componentWillReceiveProps() {
        this.loadPage();
    }

    loadPage() {
        const { location, match } = this.props;
        let { controller, action } = match.params;
        controller = controller.toLowerCase();
        if (typeof action === 'undefined') {
            action = 'main';
        }
        action = action.substring(0, 1).toUpperCase() + action.substring(1);
        import(/* webpackChunkName: "lazy" */`../../site/views/${ controller }/index.js`).then((component) => {
            const LazyComponent = component[action];
            this.setState({ 'lazyComponent': <LazyComponent location={location}/> });

        }).catch((err) => {
            console.log(err);
            import(/* webpackChunkName: "lazy" */'../../site/views/not-found/index.js').then((component) => {
                const LazyComponent = component.default;
                this.setState({ 'lazyComponent': <LazyComponent location={location}/> });
            }).catch((err2) => {
                console.log(err2);
            });
        });
    }

    render() {
        const { lazyComponent } = this.state;
        return (
            <div>
                {lazyComponent}
            </div>
        );
    }
}

Loader.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    location: PropTypes.object,
    match   : PropTypes.object.isRequired
};
Loader.defaultProps = {
    location: {}
};// 设置默认属性

// 导出组件
export default Loader;