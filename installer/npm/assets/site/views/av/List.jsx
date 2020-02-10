import React from 'react';
import PropTypes from 'prop-types';
import superagent from 'superagent';
import Component from '../../../components/component';
import getApiUrl from '../../config/api.js';
import Button from '../../../components/button';
import { Form, Input } from '../../../components/form';
import Breadcrumb from '../../../components/breadcrumb';
import { Col, Row } from '../../../components/grid';
import Panel from '../../../components/panel';
import Modal from '../../../components/modal';

class List extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data      : [],
            rowsHeight: [],
            page      : 1,
            canPlay   : false,
            loading   : false,
            showLog   : false,
            showTag   : false
        };
        this.socket = null;
    }

    componentDidMount() {
        /* const socket = new WebSocket('ws://localhost:8001/socket');
        // 打开Socket
        socket.onopen = () => {
            console.log('连接成功');
            // 监听消息
            socket.onmessage = (event) => {
                const data = JSON.parse(event.data);
                // console.log(data);
                if (data.event === 'scan' || data.event === 'spider') {
                    const { log } = this.state;
                    log.push(data.msg);
                    this.setState({ 'log': log });
                } else if (data.event === 'play' && data.msg === '播放失败') {
                    alert(data.msg);
                } else if (data.event === 'openDir' && data.msg === '打开失败') {
                    alert(data.msg);
                }
            };
            socket.onerror = (event) => {
                console.log(event);
            };
        };
        socket.onclose = (event) => {
            console.log('Client notified socket has closed', event);
            // 关闭Socket....
            // socket.close()
        };
        this.socket = socket; */
        window.onresize = () => {
            this.setState({ rowsHeight: [] }, () => {
                this.waterfall();
            });
        };
        /* window.scroll = ()=>{
            const scrollTop = $(window).scrollTop();
            const scrollHeight = $('html').get(0).scrollHeight;
            const height = $(window).height();
            if (scrollHeight <= height + scrollTop && !_this.state.end) {
                _this.getData();
            }
        }; */
        this.getData();
    }

    getData() {
        const { searchKey, searchValue, page, canPlay, loading } = this.state;
        let { data } = this.state;
        const query = { page, size: 24, searchKey, searchValue, canPlay };

        const url = getApiUrl('/api/av/get');
        if (loading === false) {
            new Promise((resolve, reject) => {
                superagent.get(url)
                    .query(query)
                    .end((err, res) => {
                        if (typeof res !== 'undefined' && res.ok) {
                            resolve(JSON.parse(res.text));
                        } else {
                            reject(err);
                        }
                    });
            }).then((res) => {
                if (res.status) {
                    data = data.concat(res.list);
                    this.setState({ 'data': data, page: page + 1 }, () => {
                        const items = document.querySelectorAll('.waterfall .item:not(.active) img');
                        const { length } = items;
                        for (let i = 0; i < length; i++) {
                            items[i].onerror = () => {
                                if (i === length - 1) {
                                    page === 1 ? this.waterfall() : this.updateWaterfall();
                                }
                            };
                            items[i].onload = () => {
                                if (i === length - 1) {
                                    page === 1 ? this.waterfall() : this.updateWaterfall();
                                }
                            };
                        }
                    });
                } else {
                    this.setState({ 'loading': false });
                }
            }).catch((err) => {
                console.log(err);
                this.setState({ 'loading': false });
            });
        }
    }

    getCanPlay() {
        const { canPlay } = this.state;
        this.setState({ 'canPlay': !canPlay, 'data': [], 'page': 1, 'loading': false, rowsHeight: [] }, () => {
            this.getData();
        });
    }

    setCover(video, value) {
        const url = getApiUrl('/api/av/setCover');
        new Promise((resolve, reject) => {
            superagent.post(url)
                .field('cover', value)
                .field('path', video.path)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((res) => {
            if (res.status) {
                const { data } = this.state;
                const index = data.indexOf(video);
                data[index].cover = `${ res.cover  }?random=${  Math.random() }`;
                this.setState({ data, rowsHeight: [] }, () => {
                    this.waterfall();
                });
                return false;
            }
            alert(res.msg);
            return true;
        }).catch((err) => {
            console.log(err);
            return true;
        });
    }

    triggerCoverInput() {
        this.coverInput.focus();
    }

    deleteVideo(video) {
        const url = getApiUrl('/api/av/delete');
        const query = { path: video.path };
        new Promise((resolve, reject) => {
            superagent.get(url)
                .query(query)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((res) => {
            if (res.status) {
                const { data } = this.state;
                const index = data.indexOf(video);
                data.splice(index, 1);
                this.setState({ data, rowsHeight: [] }, () => {
                    this.modal.onClose();
                    this.waterfall();
                });
                return false;
            }
            alert(res.msg);
            return true;
        }).catch((err) => {
            console.log(err);
            return true;
        });
    }

    waterfall() {
        const { space } = this.props;
        let width = document.querySelector('.panel').offsetWidth - space * 2;
        if (width > document.body.offsetWidth - document.querySelector('.layout-sider').offsetWidth) {
            width = document.body.offsetWidth - document.querySelector('.layout-sider').offsetWidth - space * 2;
        }
        const cols = Math.floor(width / (document.querySelector('.waterfall .item').offsetWidth + space));
        width = cols * (document.querySelector('.waterfall .item').offsetWidth + space);
        document.querySelector('.waterfall').style.width = `${ width }px`;
        const { rowsHeight } = this.state;
        for (let i = 0; i < cols; i++) {
            rowsHeight.push(0);
        }
        this.updateWaterfall();
    }

    updateWaterfall() {
        const items = document.querySelectorAll('.waterfall .item');
        const { rowsHeight } = this.state;
        let left = 0;
        const { length } = items;
        const cols = rowsHeight.length;
        const { space } = this.props;
        for (let i = 0; i < length; i++) {
            const col = i % cols;
            left = col * (document.querySelector('.waterfall .item').offsetWidth + space);
            items[i].style.position = 'absolute';
            items[i].style.top = `${ rowsHeight[col]  }px`;
            items[i].style.left = `${ left  }px`;
            if (items[i].className.indexOf('active') === -1) {
                items[i].className = items[i].className !== null ? `${ items[i].className } active` : 'active';
            }
            rowsHeight[col] += items[i].offsetHeight + space;
        }
        const rowsHeightMax = Math.max.apply(this, rowsHeight);
        document.querySelector('.waterfall').style.height = `${ rowsHeightMax }px`;
        this.setState({ rowsHeight });

    }

    search(key, value) {
        this.setState({ 'searchKey': key, 'searchValue': value, loading: false, rowsHeight: [], data: [], page: 1 }, () => {
            this.getData();
        });
    }

    top() {
        document.querySelector('.layout-content').scrollTo(0, 0);
    }

    socketSend(event, msg = '') {
        const data = JSON.stringify({ 'event': event, 'msg': msg });
        this.socket.send(data);
    }

    openDir(path) {
        new Promise((resolve, reject) => {
            superagent.get(getApiUrl('/api/av/openPath'))
                .query({ 'path': path })
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then(() => true).catch((err) => {
            console.log(err);
            return true;
        });
    }

    showModal(data) {
        const props = {
            'title'     : data.title,
            'className' : 'movie',
            'showButton': false,
            'content'   : (
                <div>
                    <Row gutter={15}>
                        <Col span={9} className="box">
                            <img src={data.cover} alt={data.title}/>
                        </Col>
                        <Col span={3}>
                            <div className="info">
                                <p>番号：{data.title}</p>
                                <div className="button-box">
                                    <a href={`potplayer://${  data.video }`}><Button>播放</Button></a>
                                    <Button onClick={this.triggerCoverInput.bind(this)}>
                                        <span>设置封面</span>
                                        <Form id="cover">
                                            <Input
                                                ref={(c) => {
                                                    this.coverInput = c;
                                                }}
                                                onChange={(value) => {
                                                    this.setCover(data, value);
                                                }}
                                                name='cover'
                                                type='file'
                                                style={{ 'display': 'none' }}
                                            />
                                        </Form>
                                    </Button>
                                    <Button onClick={this.showDeleteConfirm.bind(this, data)}>删除</Button>
                                </div>
                            </div>
                        </Col>
                    </Row>
                </div>
            )
        };
        this.modal = Modal.show(props);
    }

    showDeleteConfirm(data) {
        const props = {
            'title'    : '删除',
            'content'  : '是否删除该影片',
            'onConfirm': () => this.deleteVideo(data)
        };
        return Modal.confirm(props);
    }

    showLog() {
        this.setState({ 'showLog': !this.state.showLog });
    }

    showTag() {
        this.setState({ 'showTag': !this.state.showTag });
    }

    render() {
        const breadcrumb = [{ 'name': 'AV', 'path': '/av' }];
        return (
            <Row className="list-page">
                <Col span={12}>
                    <Breadcrumb data={breadcrumb}/>
                </Col>
                <Col span={12}>
                    <Panel>
                        <div className="header margin-bottom-10">
                            <Form onSubmit={(data) => {
                                this.search('title', data.title);
                            }}
                            >
                                <Input name='title'/>
                                <Button>搜索</Button>
                            </Form>
                        </div>
                        <div className="waterfall">
                            {this.state.data.map((val, i) => (
                                <div className="item" role="button" onClick={this.showModal.bind(this, val)} key={i}>
                                    <img src={val.cover} title={val.title} alt={val.title}/>
                                    <div className="box">
                                        <p className="title">
                                            {val.title}
                                        </p>
                                        <div className="info">
                                            <span className="identifier">{val.title}</span> / <span className="publish-time">{val.time}</span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                        <div className="top" role="button" onClick={this.top.bind(this)}>Top</div>
                    </Panel>
                </Col>
            </Row>
        );
    }
}

List.propTypes = {
    space: PropTypes.number
};

List.defaultProps = {
    space: 10
};

// 导出组件
export default List;