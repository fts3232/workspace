import React from 'react';
import Component from '../../../components/component';

class Log extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'data'  : [],
            'toggle': false
        };
    }

    resetData() {
        this.setState({ 'data': [] });
    }

    appendData(msg) {
        const { data } = this.state;
        data.push(msg);
        this.setState({ 'data': data }, ()=>{
            document.querySelector('.list').scrollTop( document.querySelector('.list').scrollHeight);
        });
    }

    toggle() {
        this.setState({ 'toggle': !this.state.toggle });
    }

    render() {
        return (
            <div className={this.classNames('log-wrapper', { 'hidden': !this.state.toggle })}>
                <h3>运行记录</h3>
                <div className="list" >
                    {this.state.data.map((v)=>(<p>{v}</p>))}
                </div>
                <div className="btn" role="button" onClick={this.toggle.bind(this)}>{this.state.toggle ? '收回' : '展开'}</div>
            </div>
        );
    }
}

Log.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
  
};
Log.defaultProps = {
  
};// 设置默认属性

// 导出组件
export default Log;