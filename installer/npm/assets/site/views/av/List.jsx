import React from 'react';
import PropTypes from 'prop-types';
import superagent from 'superagent';
import Dialog from './Dialog.jsx';
import Header from './Header.jsx';
import Log from './Log.jsx';
import Tag from './Tag.jsx';
import Component from '../../../components/component';
import getApiUrl from '../../config/api.js';

class List extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data       : [],
            title      : false,
            rows_height: [],
            end        : false,
            page       : 1,
            getData    : false,
            star       : false,
            tag        : false,
            canPlay    : false
        };
    }

    componentDidMount() {
        const _this = this;
        const socket = new WebSocket('ws://localhost:8000/socket');
        // 打开Socket 
        socket.onopen = function(event) { 
            console.log('连接成功');
            // 监听消息
            socket.onmessage = function(event) { 
                const data = JSON.parse(event.data);
                if (data.event === 'scan' || data.event === 'spider') {
                    _this.refs.log.appendData(data.msg);
                } else if (data.event === 'play' && data.msg === '播放失败') {
                    alert(data.msg);
                } else if (data.event === 'openDir' && data.msg === '打开失败') {
                    alert(data.msg);
                }
            }; 
        };
       
        // 监听Socket的关闭
        socket.onclose = function(event) { 
            console.log('Client notified socket has closed', event); 
            // 关闭Socket.... 
            // socket.close() 
        }; 
        this.socket = socket;
        this.getData();
        $(window).resize(()=>{
            this.setState({ rows_height: [] }, ()=>{
                const items = $(_this.refs.waterfall).find('.item');
                _this.waterfall(items);
            });
            
        });
        $(window).scroll(()=>{
            const scrollTop = $(window).scrollTop();
            const scrollHeight = $('html').get(0).scrollHeight;
            const height = $(window).height();
            if (scrollHeight <= height + scrollTop && !_this.state.end) {
                _this.getData();
            }
        });
    }

    getChildContext() {
        return {
            component: this
        };
    }

    onClick(val) {
        const obj = this.refs.dialog;
        obj.show();
        obj.setState({ data: val });
    }

    getData() {
        const _this = this;
        const { title, star, tag, page, canPlay } = this.state;
        let { data } = this.state;
        if (_this.state.getData === false) {
            this.setState({ 'getData': true }, ()=>{
                new Promise((resolve, reject)=>{
                    let url = getApiUrl(`/getData/av?p=${ page }&size=24`);
                    if (canPlay === true)
                        url += '&canPlay=1';
                    if (title !== false)
                        url += `&title=${  title }`;
                    else if (star !== false)
                        url += `&star=${  star }`;
                    else if (tag !== false)
                        url += `&tag=${  tag }`;

                    superagent.get(url)
                        .end((err, res) => {
                            if (typeof res !== 'undefined' && res.ok) {
                                resolve(JSON.parse(res.text));
                            } else {
                                reject(err);
                            }
                        });
                }).then((returnData)=>{
                    if (returnData !== '') {
                        data = data.concat(returnData);
                        _this.setState({ 'data': data, page: page + 1 }, ()=>{
                            const _this = this;
                            const length = $('.waterfall .item:not(.active) img').length;
                            let i = 0;
                            $('.waterfall .item:not(.active) img').on('load error', () => {
                                i += 1;
                                if (i === length) {
                                    const items = $(_this.refs.waterfall).find('.item:not(.active)');
                                    page === 1 ? _this.waterfall(items) : _this.updateWaterfall(items);
                                }
                            });
                        });
                        if (canPlay === true && title !== false || star !== false || tag !== false) {
                            _this.setState({ 'end': true, 'getData': false });
                        } else {
                            _this.setState({ 'getData': false });
                        }
                    } else {
                        _this.setState({ 'end': true, 'getData': false });
                    }
                }).catch((err)=>{
                    _this.setState({ 'end': true, 'getData': false });
                });
            });
        }
    }

    socketSend(event, msg = '') {
        const data = JSON.stringify({ 'event': event, 'msg': msg });
        this.socket.send(data);
    }

    waterfall(items) {
        const space =  this.props.space;
        const width = $('body').width() - space * 2;
        const cols = Math.floor(width / (items.outerWidth() + space));
        $(this.refs.app).css({ 'width': cols * (items.outerWidth() + space) });
        const rows_height = this.state.rows_height;
        for (let i = 0;i < cols;i++) {
            rows_height.push(0);
        }
        this.updateWaterfall(items);
    }

    updateWaterfall(items) {
        const rows_height = this.state.rows_height;
        let col = 0;
        let left = 0;
        const length = items.length;
        const cols = rows_height.length;
        const space = this.props.space;
        for (let i = 0;i < length;i++) {
            const row_height_min = Math.min.apply(this, rows_height);
            for (let i = 0;i < cols;i++) {
                if (rows_height[i] === row_height_min) {
                    col = i;
                    break;
                }
            }
            left = col * (items.outerWidth() + space);
            rows_height[col] += items.eq(i).outerHeight(true) + space;
            items.eq(i).css({ 'position': 'absolute', 'top': row_height_min, 'left': left });
        }
        this.setState({ rows_height });
        items.addClass('active');

    }

    search(data) {
        const _this = this;
        if (typeof data.title !== 'undefined') {
            this.setState({ 'title': data.title, 'tag': false, 'star': false, 'data': [], 'page': 1, 'end': false, rows_height: [] }, ()=>{
                _this.getData();
            });
        } else if (typeof data.star !== 'undefined') {
            this.setState({ 'star': data.star, 'tag': false, 'title': false, 'data': [], 'page': 1, 'end': false, rows_height: [] }, ()=>{
                _this.getData();
            });
        } else if (typeof data.tag !== 'undefined') {
            this.setState({ 'tag': data.tag, 'star': false, 'title': false, 'data': [], 'page': 1, 'end': false, rows_height: [] }, ()=>{
                _this.getData();
            });
        }
    }

    top() {
        document.querySelector('html').scrollTop = 0;
    }

    render() {
        return (
            <div className="list-page">
                <Header/>
                <div className="waterfall">
                    {this.state.data.map((val)=>(
                        <div className="item" role="button" onClick={this.onClick.bind(this, val)}>
                            <img src={val.IMAGE ? `http://localhost:8000/static/Movie/${ val.IDENTIFIER }/cover.jpg` : 'http://localhost:8000/static/now_printing.jpg'} title={val.IMAGE ? val.TITLE : '暂无图片'} alt={val.IDENTIFIER}/>
                            <div className="box">
                                <p className="title">
                                    {val.TITLE}
                                </p>
                                <div className="tag">
                                    {val.PLAY ? (
                                        <span className="can-play">可播放</span>
                                    ) : null}
                                    {val.LINK.length > 0 ? (
                                        <span className="can-download">可下载</span>
                                    ) : null}
                                </div>
                                <div className="info">
                                    <span className="identifier">{val.IDENTIFIER}</span>
                                    <span className="publish-time">{val.PUBLISH_TIME}</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
                <Dialog/>
                <Log/>
                <Tag/>
                <div className="top" role="button" onClick={this.top.bind(this)}>Top</div>
            </div>
        );
    }
}

List.childContextTypes = {
    component: PropTypes.any
};

List.propTypes = {
    space: PropTypes.number
};

List.defaultProps = {
    space: 10
};

// 导出组件
export default List;