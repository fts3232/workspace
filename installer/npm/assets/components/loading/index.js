import Loading from './Loading.jsx';

Loading.show = () => {
    const div = document.createElement('div');
    const willUnmount = () => {
        ReactDOM.unmountComponentAtNode(div);
        document.body.removeChild(div);
    };
    let loading;
    // react-router
    ReactDOM.render((
        <Loading willUnmount={willUnmount} ref={(component)=>{ loading = component; }}/>
    ), div);
    document.body.appendChild(div);
    return loading;
};

export default Loading;