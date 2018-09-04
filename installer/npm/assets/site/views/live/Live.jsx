import React from 'react';
import superagent from 'superagent';
import Component from '../../../components/component';
import getApiUrl from '../../config/api.js';

class Live extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'data'   : [],
            'loading': false
        };
    }

    componentDidMount() {
        const socket = new WebSocket('ws://localhost:8000/socket');
        const _this = this;
        // 打开Socket
        socket.onopen = function () {
            console.log('连接成功');
            _this.getData();
            // 监听消息
            socket.onmessage = function (event) {
                const data = JSON.parse(event.data);
                _this.refs.header.setState({ 'loading': false, 'data': data.msg });
            };
        };
        // 监听Socket的关闭
        socket.onclose = function (event) {
            console.log('Client notified socket has closed', event);
            // 关闭Socket....
            // socket.close()
        };
        this.socket = socket;
    }

    getData() {
        const _this = this;
        this.setState({ 'loading': true }, () => {
            new Promise((resolve, reject) => {
                const url = getApiUrl('/getData/live');
                superagent.get(url)
                    .end((err, res) => {
                        if (typeof res !== 'undefined' && res.ok) {
                            resolve(JSON.parse(res.text));
                        } else {
                            reject(err);
                        }
                    });
            }).then((data) => {
                if (data !== '') {
                    _this.setState({ 'loading': false, 'data': data });
                } else {
                    _this.setState({ 'loading': false });
                }
            }).catch((err) => {
                console.log(err);
                _this.setState({ 'loading': false });
            });
        });
    }

    updateData() {
        const data = JSON.stringify({ 'event': 'updateLive', 'msg': '' });
        this.socket.send(data);
    }

    update() {
        if (!this.state.loading) {
            this.setState({ 'loading': true });
            this.parent().updateData();
        }
    }

    render() {
        const group = [];
        const { data } = this.state;
        const groupName = {
            'douyu'  : '斗鱼',
            'huya'   : '虎牙',
            'panda'  : '熊猫',
            'longzhu': '龙珠'
        };
        for (const i in data) {
            const items = [];
            for (const j in data[i]) {
                const roomInfo = data[i][j][1];
                items.push(
                    <div className="item">
                        <a href={data[i][j][0]} target="_blank" rel="noopener noreferrer">
                            <img src={roomInfo.screenshot} alt={roomInfo.room_name}/>
                            <span className={this.classNames('state', { 'off': !roomInfo.state })}>{roomInfo.state ? '正在直播' : '已下播'}</span>
                            <div className="msg">
                                <p><span className="title">{roomInfo.room_name}</span></p>
                                <p>
                                    <span className="nickname">{roomInfo.nickname}</span>
                                    <span className="category">{roomInfo.category}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                );
            }
            group.push(
                <div className="item-group">
                    <h3>{groupName[i]}</h3>
                    <div className="items">
                        {items}
                    </div>
                </div>
            );
        }
        return (
            <div className="live-list-page">
                <div className="header">
                    <button className={this.classNames({ 'loading': this.state.loading })} onClick={this.update.bind(this)}>{this.state.loading ? '加载中' : '更新数据'}</button>
                </div>
                {group}
            </div>
        );
    }
}

Live.propTypes = {};

Live.defaultProps = {};

// 导出组件
export default Live;