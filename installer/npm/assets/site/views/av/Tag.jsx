import React from 'react';
import PropTypes from 'prop-types';
import superagent from 'superagent';
import Component from '../../../components/component';
import getApiUrl from '../../config/api.js';

class Tag extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'data'  : [],
            'toggle': false
        };
    }

    componentDidMount() {
        const _this = this;
        new Promise((resolve, reject)=>{
            const url = getApiUrl('/getData/tag');
            superagent.get(url)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data)=>{
            _this.setState({ 'data': data });
        }).catch((err)=>{
            console.log(err);
        });
    }

    parent() {
        return this.context.component;
    }

    toggle() {
        this.setState({ 'toggle': !this.state.toggle });
    }

    itemClick(id) {
        this.parent().search({ 'tag': id });
        this.setState({ 'toggle': false });
    }

    render() {
        return (
            <div className={this.classNames('tag-wrapper', { 'hidden': !this.state.toggle })}>
                <h3>Tag列表</h3>
                <div className="list">
                    {this.state.data.map((v)=>(<span role="button" onClick={this.itemClick.bind(this, v.TAG_ID)}>{v.TAG_NAME}</span>))}
                </div>
                <div className="btn" role="button" onClick={this.toggle.bind(this)}>{this.state.toggle ? '收回' : '展开'}</div>
            </div>
        );
    }
}

Tag.contextTypes = {
    component: PropTypes.any
};

Tag.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
  
};
Tag.defaultProps = {
  
};// 设置默认属性

// 导出组件
export default Tag;